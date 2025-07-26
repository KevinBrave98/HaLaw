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

const remoteAudio = document.getElementById("remoteAudio");

// ============================

// 🔑 Generate TURN Credentials (Time-based)

// ============================

function generateTurnCredentials() {
    // Most TURN servers use time-limited credentials

    const ttl = 24 * 3600; // 24 hours

    const timestamp = Math.floor(Date.now() / 1000) + ttl;

    const tempUsername = `${timestamp}:halaw`;

    // If your TURN server uses HMAC-SHA1 for credentials:

    // You'd need to generate the credential using your shared secret

    // For now, let's try both static and time-based approaches

    return [
        // Static credentials (your current setup)

        {
            username: "halaw",

            credential: "halawAhKnR123",
        },

        // Time-based credentials (if your TURN server supports this)

        {
            username: tempUsername,

            credential: "halawAhKnR123", // This should be HMAC-SHA1 hash in production
        },
    ];
}

// ============================

// 🧪 TURN Server Diagnostic

// ============================

async function testTurnServer() {
    console.log("🧪 Testing TURN server connectivity...");

    const credentials = generateTurnCredentials();

    // Test multiple credential configurations

    for (let i = 0; i < credentials.length; i++) {
        const cred = credentials[i];

        console.log(`🧪 Testing TURN config ${i + 1}:`, cred.username);

        const testConfig = {
            iceServers: [
                {
                    urls: ["turn:34.101.170.104:3478?transport=udp"],

                    username: cred.username,

                    credential: cred.credential,
                },
            ],

            iceTransportPolicy: "all",
        };

        const testPC = new RTCPeerConnection(testConfig);

        const result = await new Promise((resolve) => {
            let relayFound = false;

            let testTimeout;

            testPC.onicecandidate = (event) => {
                if (event.candidate) {
                    console.log(`🧪 Test candidate (config ${i + 1}):`, {
                        type: event.candidate.type,

                        protocol: event.candidate.protocol,

                        address: event.candidate.address,

                        port: event.candidate.port,
                    });

                    if (event.candidate.type === "relay") {
                        relayFound = true;

                        console.log(
                            `✅ TURN server working with config ${i + 1}!`
                        );
                    }
                } else {
                    console.log(
                        `🧪 Test ICE gathering completed for config ${i + 1}`
                    );

                    clearTimeout(testTimeout);

                    testPC.close();

                    resolve(relayFound);
                }
            };

            testPC.onicegatheringstatechange = () => {
                console.log(
                    `🧪 Test ICE gathering state (config ${i + 1}):`,
                    testPC.iceGatheringState
                );
            };

            // Create a dummy offer to trigger ICE gathering

            testPC
                .createOffer({ offerToReceiveAudio: true })

                .then((offer) => testPC.setLocalDescription(offer))

                .catch((err) => {
                    console.error(
                        `🧪 Test offer failed for config ${i + 1}:`,
                        err
                    );

                    testPC.close();

                    resolve(false);
                });

            // Timeout after 8 seconds

            testTimeout = setTimeout(() => {
                console.warn(`🧪 TURN test timed out for config ${i + 1}`);

                testPC.close();

                resolve(relayFound);
            }, 8000);
        });

        if (result) {
            console.log(`✅ TURN server works with config ${i + 1}`);

            return { working: true, config: cred };
        }
    }

    console.error("❌ No working TURN server configuration found");

    return { working: false, config: credentials[0] };
}

// ============================

// 🛠 SDP Helpers

// ============================

function sanitizeSSRC(sdp) {
    if (!sdp || typeof sdp !== "string") return sdp;

    let lines = sdp.split(/\r\n|\n/);

    let fixed = lines.map((line) => {
        if (line.startsWith("a=ssrc:")) {
            if (line.includes("cname:{")) {
                console.warn("⚠️ Fixing malformed SSRC cname:", line);

                return line.replace(/\{|\}/g, "");
            }
        }

        return line;
    });

    return fixed.join("\r\n");
}

// 🚑 Fix malformed telephone-event lines (Chrome bug)

function fixTelephoneEvent(sdp) {
    if (!sdp || typeof sdp !== "string") return sdp;

    console.log("🔧 Checking for telephone-event issues");

    // Fix malformed rtpmap lines for telephone-event

    let fixedSdp = sdp.replace(
        /^a=rtpmap:(\d+)\s+telephone-event\/8000$/gm,

        "a=rtpmap:$1 telephone-event/8000/1"
    );

    // Remove any duplicate or malformed telephone-event lines

    let lines = fixedSdp.split(/\r\n|\n/);

    let seenTelephoneEventRtpmap = new Set();

    lines = lines.filter((line) => {
        if (line.match(/^a=rtpmap:\d+\s+telephone-event/)) {
            const match = line.match(/^a=rtpmap:(\d+)/);

            if (match) {
                const payloadType = match[1];

                if (seenTelephoneEventRtpmap.has(payloadType)) {
                    console.warn(
                        "⚠️ Removing duplicate telephone-event rtpmap:",
                        line
                    );

                    return false;
                }

                seenTelephoneEventRtpmap.add(payloadType);

                // Ensure proper format

                if (
                    !line.includes("/8000/1") &&
                    line.includes("telephone-event/8000")
                ) {
                    console.warn("⚠️ Fixing telephone-event format:", line);

                    return false; // Remove malformed line, proper one will be added above
                }
            }
        }

        return true;
    });

    return lines.join("\r\n");
}

function cleanAudioOnlySDP(sdp) {
    console.log("🗑️ Audio-only call - cleaning SDP");

    // First fix telephone-event issues

    sdp = fixTelephoneEvent(sdp);

    // Then remove SSRC lines

    return sdp.replace(/^a=ssrc:[^\r\n]*\r?\n?/gm, "");
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

        let sdp = sessionDescription.sdp;

        console.log("🔍 Original SDP length:", sdp.length);

        const hasVideo = /m=video/.test(sdp);

        console.log("🎥 Video call detected:", hasVideo);

        sdp = sanitizeSSRC(sdp);

        if (!hasVideo) {
            sdp = cleanAudioOnlySDP(sdp);
        }

        sdp = sdp.replace(/(\r\n){3,}/g, "\r\n\r\n");

        const cleanedSessionDesc = new RTCSessionDescription({
            type: sessionDescription.type,

            sdp: sdp,
        });

        await peerConnection.setRemoteDescription(cleanedSessionDesc);

        console.log("✅ Remote description set successfully");

        return true;
    } catch (error) {
        console.error("❌ Error setting remote description:", error);

        throw error;
    }
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
        localStream.getTracks().forEach((t) => t.stop());

        localStream = null;
    }

    if (callStatus) callStatus.classList.add("d-none");
}

// ============================

// 🧊 ICE Candidate Helper

// ============================

async function processPendingCandidates() {
    if (
        !peerConnection ||
        !peerConnection.remoteDescription ||
        pendingCandidates.length === 0
    )
        return;

    console.log(
        `🔄 Processing ${pendingCandidates.length} pending ICE candidates`
    );

    const candidatesToProcess = [...pendingCandidates];

    pendingCandidates = [];

    for (const candidate of candidatesToProcess) {
        try {
            await peerConnection.addIceCandidate(candidate);

            console.log("✅ Queued ICE candidate added");
        } catch (err) {
            console.error("❌ Error adding queued ICE candidate:", err);
        }
    }
}

async function ensurePeerConnection() {
    if (!peerConnection) {
        console.log("🔧 Creating PeerConnection with forced TURN relay…");

        const turnServers = [
            {
                urls: "turn:34.101.170.104:3478?transport=udp",
                username: "halaw",
                credential: "halawAhKnR123",
            },

            {
                urls: "turn:34.101.170.104:80?transport=udp",
                username: "halaw",
                credential: "halawAhKnR123",
            },

            {
                urls: "turn:34.101.170.104:443?transport=udp",
                username: "halaw",
                credential: "halawAhKnR123",
            },

            {
                urls: "turn:34.101.170.104:3478?transport=tcp",
                username: "halaw",
                credential: "halawAhKnR123",
            },

            {
                urls: "turns:34.101.170.104:5349?transport=tcp",
                username: "halaw",
                credential: "halawAhKnR123",
            },
        ];

        const pcConfig = {
            iceTransportPolicy: "all", // force relay only, for testing

            iceServers: turnServers,

            bundlePolicy: "max-bundle",

            rtcpMuxPolicy: "require",
        };

        peerConnection = new RTCPeerConnection(pcConfig);

        peerConnection.onicecandidate = async (event) => {
            if (!callActive || !peerConnection) return;

            if (event.candidate) {
                console.log("📤 ICE candidate:", event.candidate);

                if (event.candidate.type === "relay") {
                    console.log("🎯 RELAY CANDIDATE FOUND!");
                }

                try {
                    await axios.post("/call/ice", {
                        call_id: window.callId,
                        candidate: event.candidate,
                    });
                } catch (err) {
                    console.error("❌ Failed to send ICE:", err);
                }
            } else {
                console.log("✅ ICE gathering complete");
            }
        };

        peerConnection.ontrack = (event) => {
            console.log("🎧 Remote track received", event.streams);

            if (remoteAudio && event.streams && event.streams[0]) {
                remoteAudio.srcObject = event.streams[0];

                remoteAudio.autoplay = true;

                remoteAudio.muted = false;

                remoteAudio.hidden = false;

                console.log("✅ remoteAudio playing");
            }
        };

        peerConnection.oniceconnectionstatechange = () => {
            console.log(
                "🌐 ICE connection state:",
                peerConnection.iceConnectionState
            );

            if (peerConnection.iceConnectionState === "failed") {
                console.error(
                    "❌ ICE connection failed – check TURN connectivity and logs"
                );
            }
        };
    }
}

// ============================

// 📞 Start Call

// ============================

async function startCall(video = false) {
    try {
        console.log("📞 Starting call…");

        await ensurePeerConnection();

        const constraints = {
            audio: {
                echoCancellation: true,

                noiseSuppression: true,

                autoGainControl: true,
            },

            video: video,
        };

        localStream = await navigator.mediaDevices.getUserMedia(constraints);

        localStream.getTracks().forEach((track) => {
            console.log("🎵 Adding track:", track.kind, track.enabled);

            peerConnection.addTrack(track, localStream);
        });

        const offer = await peerConnection.createOffer({
            offerToReceiveAudio: true,

            offerToReceiveVideo: video,
        });

        await peerConnection.setLocalDescription(offer);

        // Wait for some ICE candidates to be gathered

        console.log("⏳ Waiting for ICE candidates...");

        await new Promise((resolve) => {
            let gathered = 0;

            const originalHandler = peerConnection.onicecandidate;

            peerConnection.onicecandidate = (event) => {
                if (originalHandler) originalHandler(event);

                if (event.candidate) {
                    gathered++;

                    if (gathered >= 3) {
                        // Wait for at least 3 candidates

                        resolve();
                    }
                } else {
                    resolve(); // ICE gathering completed
                }
            };

            // Don't wait more than 5 seconds

            setTimeout(resolve, 5000);
        });

        await axios.post("/call/offer", { call_id: window.callId, offer });

        callActive = true;

        if (callStatus) callStatus.classList.remove("d-none");

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

        startCall(false);
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

                if (!localStream) {
                    try {
                        const constraints = {
                            audio: {
                                echoCancellation: true,

                                noiseSuppression: true,

                                autoGainControl: true,
                            },

                            video: false,
                        };

                        localStream = await navigator.mediaDevices.getUserMedia(
                            constraints
                        );

                        localStream.getTracks().forEach((t) => {
                            console.log("🎵 Adding answerer track:", t.kind);

                            peerConnection.addTrack(t, localStream);
                        });
                    } catch (err) {
                        console.error("❌ Error accessing local media:", err);
                    }
                }

                await setRemoteDescriptionSafely(peerConnection, e.offer);

                remoteDescriptionSet = true;

                isProcessingRemoteDescription = false;

                console.log("✅ Offer set as remote description");

                await processPendingCandidates();

                const answer = await peerConnection.createAnswer({
                    offerToReceiveAudio: true,

                    offerToReceiveVideo: false,
                });

                await peerConnection.setLocalDescription(answer);

                await axios.post("/call/answer", {
                    call_id: window.callId,
                    answer,
                });

                if (callStatus) callStatus.classList.remove("d-none");

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

                if (!peerConnection) return;

                if (peerConnection.signalingState === "have-local-offer") {
                    isProcessingRemoteDescription = true;

                    await setRemoteDescriptionSafely(peerConnection, e.answer);

                    remoteDescriptionSet = true;

                    isProcessingRemoteDescription = false;

                    console.log("✅ Answer set as remote description");

                    await processPendingCandidates();
                }
            } catch (err) {
                console.error("❌ Error handling answer:", err);

                isProcessingRemoteDescription = false;
            }
        })

        .listen(".candidate", async (e) => {
            if (!peerConnection || !callActive) return;

            if (
                !e.candidate ||
                !e.candidate.candidate ||
                e.candidate.candidate.trim() === ""
            )
                return;

            try {
                const candidate = new RTCIceCandidate(e.candidate);

                console.log("📥 Received remote ICE candidate:", {
                    type: candidate.type,

                    protocol: candidate.protocol,

                    address: candidate.address,

                    port: candidate.port,
                });

                const canAddImmediately =
                    peerConnection.remoteDescription &&
                    peerConnection.remoteDescription.sdp &&
                    !isProcessingRemoteDescription;

                if (canAddImmediately) {
                    try {
                        await peerConnection.addIceCandidate(candidate);

                        console.log(
                            "✅ Remote ICE candidate added immediately"
                        );

                        return;
                    } catch (err) {
                        console.warn(
                            "⚠️ Failed to add remote candidate immediately:",
                            err.message
                        );
                    }
                }

                pendingCandidates.push(candidate);

                console.log("⏳ Remote ICE candidate queued");
            } catch (err) {
                console.error("❌ Error processing remote ICE candidate:", err);
            }
        })

        .listen(".call-ended", () => {
            console.log("📴 Call ended by other side");

            cleanupCall();
        });
}
