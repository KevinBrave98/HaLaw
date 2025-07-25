import axios from "axios";

// ============================
// 🔧 Global variables
// ============================
let peerConnection = null;
let localStream = null;
let pendingCandidates = [];
let remoteDescriptionSet = false;
let callActive = false;
let isProcessingRemoteDescription = false;

const callStatus = document.getElementById("callStatus");
const endCallBtn = document.getElementById("endCallBtn");
const startCallLink = document.getElementById("startCallLink");

function cleanSDP(sdp) {
    if (!sdp || typeof sdp !== "string") {
        console.warn("⚠️ Invalid SDP provided for cleaning");
        return sdp;
    }

    console.log("🔍 Original SDP length:", sdp.length);

    let cleanedSDP = sdp;
    let changesMade = false;

    // ✅ Detect if the SDP negotiates video
    const hasVideo = /m=video/.test(cleanedSDP);
    console.log("🎥 Video call detected:", hasVideo);

    if (!hasVideo) {
        // 🎧 Audio-only: remove *all* SSRC lines
        console.log(
            "🗑️ Audio-only call - removing ALL SSRC lines for maximum compatibility"
        );
        const allSSRCRegex = /^a=ssrc:[^\r\n]*\r?\n?/gm;
        const ssrcMatches = cleanedSDP.match(allSSRCRegex);
        if (ssrcMatches && ssrcMatches.length > 0) {
            console.log("🗑️ Removing SSRC lines:", ssrcMatches);
            cleanedSDP = cleanedSDP.replace(allSSRCRegex, "");
            changesMade = true;
        }
    } else {
        // 🎥 Video: leave SSRC lines intact
        console.log("✅ Video call - keeping SSRC lines intact");
        // (If you ever need to add msid/mslabel fixes, you can do it here.)
    }

    // ✨ Clean up excessive blank lines
    cleanedSDP = cleanedSDP.replace(/(\r\n){3,}/g, "\r\n\r\n");

    if (changesMade) {
        console.log("🧹 SDP cleaned successfully");
        console.log("🔍 Cleaned SDP length:", cleanedSDP.length);

        const remainingSSRCLines = cleanedSDP
            .split("\n")
            .filter((line) => line.startsWith("a=ssrc:"));
        if (remainingSSRCLines.length > 0) {
            console.log(
                "🔍 Remaining SSRC lines:",
                remainingSSRCLines.slice(0, 3)
            );
        }
    } else {
        console.log("ℹ️ No SDP cleaning needed");
    }

    return cleanedSDP;
}

// ============================
// 🔒 Safe Remote Description Setter
// ============================
async function setRemoteDescriptionSafely(peerConnection, sessionDescription) {
    try {
        console.log(
            "🔍 Setting remote description, type:",
            sessionDescription.type
        );

        // Log problematic SDP lines for debugging
        if (
            sessionDescription.sdp &&
            sessionDescription.sdp.includes("ssrc:")
        ) {
            const ssrcLines = sessionDescription.sdp
                .split("\n")
                .filter((line) => line.includes("ssrc:"));
            console.log("🔍 SSRC lines found:", ssrcLines.slice(0, 3)); // Show first 3 for debugging
        }

        // Clean the SDP before setting
        // const cleanedSDP = cleanSDP(sessionDescription.sdp);
        // const cleanedSessionDesc = new RTCSessionDescription({
        //     type: sessionDescription.type,
        //     sdp: cleanedSDP,
        // });

        await peerConnection.setRemoteDescription(cleanedSessionDesc);
        console.log("✅ Remote description set successfully");
        return true;
    } catch (error) {
        console.error("❌ Error setting remote description:", error);

        // Log the exact SDP line that's causing issues for further debugging
        if (error.message && error.message.includes("ssrc:")) {
            const match = error.message.match(/a=ssrc:[\d\s\w:-]+/);
            if (match) {
                console.error("🔍 Problematic SDP line:", match[0]);
            }
        }

        throw error;
    }
}

// ============================
// 🎨 UI Helper
// ============================
function showCallStatus() {
    if (callStatus) callStatus.classList.remove("d-none");
}
function hideCallStatus() {
    if (callStatus) callStatus.classList.add("d-none");
}

// ============================
// 📞 Cleanup
// ============================
function cleanupCall() {
    console.log("🧹 Cleaning up call…");
    callActive = false;
    remoteDescriptionSet = false;
    isProcessingRemoteDescription = false;
    pendingCandidates = [];

    if (peerConnection) {
        try {
            peerConnection.onicecandidate = null;
            peerConnection.ontrack = null;
            peerConnection.oniceconnectionstatechange = null;
            peerConnection.close();
        } catch (e) {
            console.warn("Error closing peerConnection", e);
        }
        peerConnection = null;
    }

    if (localStream) {
        localStream.getTracks().forEach((track) => track.stop());
        localStream = null;
    }

    hideCallStatus();
}

// ============================
// 🧊 ICE Candidate Helper
// ============================
async function processPendingCandidates() {
    if (
        !peerConnection ||
        !remoteDescriptionSet ||
        pendingCandidates.length === 0
    ) {
        return;
    }

    console.log(
        `🔄 Processing ${pendingCandidates.length} pending ICE candidates`
    );

    for (const candidate of pendingCandidates) {
        try {
            await peerConnection.addIceCandidate(candidate);
            console.log("✅ Queued ICE candidate added successfully");
        } catch (err) {
            console.error("❌ Error adding queued ICE candidate:", err);
        }
    }
    pendingCandidates = [];
}

// ============================
// 📡 Ensure PeerConnection
// ============================
async function ensurePeerConnection() {
    if (!peerConnection) {
        peerConnection = new RTCPeerConnection({
            iceTransportPolicy: "relay", // Temporarily changed from "relay" for debugging
            iceServers: [
                // { urls: "stun:stun.l.google.com:19302" },
                {
                    urls: [
                        "turn:34.101.170.104:3478?transport=udp",
                        "turn:34.101.170.104:3478?transport=tcp",
                        "turns:34.101.170.104:5349?transport=tcp",
                    ],
                    username: "halaw",
                    credential: "halawAhKnR123",
                },
            ],
        });

        peerConnection.onicecandidate = async (event) => {
            if (!peerConnection || !callActive) return;

            if (event.candidate) {
                // Log detailed candidate info for debugging
                console.log("🔍 ICE Candidate Details:", {
                    type: event.candidate.type,
                    protocol: event.candidate.protocol,
                    address: event.candidate.address,
                    port: event.candidate.port,
                    priority: event.candidate.priority,
                    foundation: event.candidate.foundation,
                    candidate: event.candidate.candidate,
                });

                // Only send non-empty candidates
                if (
                    event.candidate.candidate &&
                    event.candidate.candidate.trim() !== ""
                ) {
                    console.log("📤 Sending ICE candidate:", event.candidate);
                    try {
                        await axios.post("/call/ice", {
                            call_id: window.callId,
                            candidate: event.candidate,
                        });
                    } catch (err) {
                        console.error("Error sending ICE:", err);
                    }
                } else {
                    console.log("🔚 End-of-candidates signal received");
                }
            } else {
                console.log("🔚 ICE gathering completed");
            }
        };

        peerConnection.ontrack = (event) => {
            console.log("🎧 Remote track received", event.streams);
            const remoteAudio = document.getElementById("remoteAudio");
            if (remoteAudio && event.streams && event.streams[0]) {
                remoteAudio.srcObject = event.streams[0];
                remoteAudio.autoplay = true;
                remoteAudio.muted = false;
                remoteAudio.hidden = false;
                console.log("✅ remoteAudio playing");
            }
        };

        peerConnection.oniceconnectionstatechange = () => {
            console.log("🌐 ICE state:", peerConnection.iceConnectionState);

            if (peerConnection.iceConnectionState === "failed") {
                console.log("❌ ICE connection failed, attempting ICE restart");
                // Optionally trigger ICE restart
                // restartIce();
            }
        };

        peerConnection.onsignalingstatechange = () => {
            console.log("📡 Signaling state:", peerConnection.signalingState);
        };
    }
}

// ============================
// 📞 Start Call (Caller)
// ============================
async function startCall() {
    try {
        console.log("📞 Starting call…");
        await ensurePeerConnection();

        localStream = await navigator.mediaDevices.getUserMedia({
            audio: true,
        });

        localStream.getTracks().forEach((track) => {
            peerConnection.addTrack(track, localStream);
        });

        const offer = await peerConnection.createOffer({
            offerToReceiveAudio: true,
            offerToReceiveVideo: false,
        });

        await peerConnection.setLocalDescription(offer);

        await axios.post("/call/offer", {
            call_id: window.callId,
            offer,
        });

        callActive = true;
        showCallStatus();
        console.log("✅ Offer sent");
    } catch (err) {
        console.error("❌ Error starting call:", err);
        cleanupCall();
    }
}

// ============================
// 🛑 End Call
// ============================
async function endCall() {
    try {
        await axios.post("/call/end", { call_id: window.callId });
    } catch (err) {
        console.error("Error notifying end call:", err);
    }
    cleanupCall();
}

// ============================
// 🔗 UI Events
// ============================
if (startCallLink) {
    startCallLink.addEventListener("click", (e) => {
        e.preventDefault();
        startCall();
    });
}
if (endCallBtn) {
    endCallBtn.addEventListener("click", (e) => {
        e.preventDefault();
        endCall();
    });
}

// ============================
// 📡 Echo Signaling
// ============================
if (window.callId) {
    Echo.private(`callroom.${window.callId}`)
        .listen(".offer", async (e) => {
            try {
                console.log("📥 Received offer:", e.offer);

                callActive = true;
                isProcessingRemoteDescription = true;
                await ensurePeerConnection();

                // Add local mic before setting remote description
                if (!localStream) {
                    try {
                        localStream = await navigator.mediaDevices.getUserMedia(
                            {
                                audio: true,
                            }
                        );
                        localStream
                            .getTracks()
                            .forEach((track) =>
                                peerConnection.addTrack(track, localStream)
                            );
                    } catch (err) {
                        console.error("❌ Lawyer mic error:", err);
                    }
                }

                // Set remote description using the safe method
                await setRemoteDescriptionSafely(peerConnection, e.offer);
                remoteDescriptionSet = true;
                isProcessingRemoteDescription = false;
                console.log("✅ Offer set as remote description");

                // Process any pending ICE candidates
                await processPendingCandidates();

                // Create and send answer
                const answer = await peerConnection.createAnswer();
                await peerConnection.setLocalDescription(answer);

                await axios.post("/call/answer", {
                    call_id: window.callId,
                    answer,
                });

                showCallStatus();
                console.log("✅ Answer sent");
            } catch (err) {
                console.error("❌ Error handling offer:", err);
                isProcessingRemoteDescription = false;
                cleanupCall();
            }
        })
        .listen(".answer", async (e) => {
            try {
                console.log("📥 Received answer:", e.answer);
                console.log("📥 Full event object:", e);

                if (!peerConnection) {
                    console.warn("No peer connection available");
                    return;
                }

                if (!e.answer) {
                    console.error("❌ Received undefined answer");
                    return;
                }

                if (!e.answer.type || !e.answer.sdp) {
                    console.error("❌ Invalid answer format:", e.answer);
                    return;
                }

                // Check if we should set the remote description
                if (peerConnection.signalingState === "have-local-offer") {
                    isProcessingRemoteDescription = true;
                    await setRemoteDescriptionSafely(peerConnection, e.answer);
                    remoteDescriptionSet = true;
                    isProcessingRemoteDescription = false;
                    console.log("✅ Answer set as remote description");

                    await processPendingCandidates();
                } else {
                    console.log(
                        "ℹ️ Ignoring answer - wrong signaling state:",
                        peerConnection.signalingState
                    );
                }
            } catch (err) {
                console.error("❌ Error handling answer:", err);
                isProcessingRemoteDescription = false;
            }
        })
        .listen(".candidate", async (e) => {
            if (!peerConnection || !callActive) {
                console.warn("⚠️ Ignoring ICE because call not active");
                return;
            }

            if (
                !e.candidate ||
                !e.candidate.candidate ||
                e.candidate.candidate.trim() === ""
            ) {
                console.log("ℹ️ Received empty ICE candidate, ignoring");
                return;
            }

            try {
                const candidate = new RTCIceCandidate(e.candidate);

                // Wait if remote description is being processed
                if (isProcessingRemoteDescription) {
                    console.log(
                        "⏳ Waiting for remote description processing to complete"
                    );
                    // Add a small delay and retry
                    setTimeout(async () => {
                        if (
                            remoteDescriptionSet &&
                            !isProcessingRemoteDescription
                        ) {
                            try {
                                await peerConnection.addIceCandidate(candidate);
                                console.log("✅ Delayed ICE candidate added");
                            } catch (err) {
                                console.error(
                                    "❌ Error adding delayed ICE candidate:",
                                    err
                                );
                            }
                        } else {
                            pendingCandidates.push(candidate);
                            console.log(
                                "⏳ Added ICE candidate to pending queue (delayed)"
                            );
                        }
                    }, 100);
                    return;
                }

                if (remoteDescriptionSet) {
                    await peerConnection.addIceCandidate(candidate);
                    console.log("✅ ICE candidate added immediately");
                } else {
                    pendingCandidates.push(candidate);
                    console.log("⏳ Added ICE candidate to pending queue");
                }
            } catch (err) {
                console.error("❌ Error processing ICE candidate:", err);
                // Don't add to pending queue if there's a parsing error
            }
        })
        .listen(".call-ended", () => {
            console.log("📴 Call ended by other side");
            cleanupCall();
        });
}
