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
    if (!peerConnection || !remoteDescriptionSet || pendingCandidates.length === 0) {
        return;
    }

    console.log(`🔄 Processing ${pendingCandidates.length} pending ICE candidates`);
    
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
            iceTransportPolicy: "all", // Temporarily changed from "relay" for debugging
            iceServers: [
                { urls: "stun:stun.l.google.com:19302" },
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
                    candidate: event.candidate.candidate
                });
                
                // Only send non-empty candidates
                if (event.candidate.candidate && event.candidate.candidate.trim() !== '') {
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
            
            if (peerConnection.iceConnectionState === 'failed') {
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
            offerToReceiveVideo: false
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
                        localStream = await navigator.mediaDevices.getUserMedia({
                            audio: true,
                        });
                        localStream.getTracks().forEach((track) =>
                            peerConnection.addTrack(track, localStream)
                        );
                    } catch (err) {
                        console.error("❌ Lawyer mic error:", err);
                    }
                }

                // Set remote description
                await peerConnection.setRemoteDescription(new RTCSessionDescription(e.offer));
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
                    
                    await peerConnection.setRemoteDescription(new RTCSessionDescription(e.answer));
                    remoteDescriptionSet = true;
                    isProcessingRemoteDescription = false;
                    console.log("✅ Answer set as remote description");

                    await processPendingCandidates();
                } else {
                    console.log("ℹ️ Ignoring answer - wrong signaling state:", peerConnection.signalingState);
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

            if (!e.candidate || !e.candidate.candidate || e.candidate.candidate.trim() === '') {
                console.log("ℹ️ Received empty ICE candidate, ignoring");
                return;
            }

            try {
                const candidate = new RTCIceCandidate(e.candidate);
                
                // Wait if remote description is being processed
                if (isProcessingRemoteDescription) {
                    console.log("⏳ Waiting for remote description processing to complete");
                    // Add a small delay and retry
                    setTimeout(async () => {
                        if (remoteDescriptionSet && !isProcessingRemoteDescription) {
                            try {
                                await peerConnection.addIceCandidate(candidate);
                                console.log("✅ Delayed ICE candidate added");
                            } catch (err) {
                                console.error("❌ Error adding delayed ICE candidate:", err);
                            }
                        } else {
                            pendingCandidates.push(candidate);
                            console.log("⏳ Added ICE candidate to pending queue (delayed)");
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