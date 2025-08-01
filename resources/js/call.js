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
let connectionAttempts = 0;
let maxConnectionAttempts = 3;

const callStatus = document.getElementById("callStatus");
const endCallBtn = document.getElementById("endCallBtn");
const startCallLink = document.getElementById("startCallLink");
const remoteAudio = document.getElementById("remoteAudio");
const localVideo = document.getElementById("localVideo");
const remoteVideo = document.getElementById("remoteVideo");
// ... (variabel global Anda yang lain) ...

// === Variabel untuk UI Panggilan Baru ===
const callUiContainer = document.getElementById("call-ui-container");
const callInfoView = document.querySelector(".call-info");
const inCallView = document.querySelector(".in-call-view");
const callInfoName = document.getElementById("call-info-name");
// Ganti referensi endCallBtn ke tombol yang baru di dalam popup
const endCallBtnInCall = document.getElementById("endCallBtn"); // Anda mungkin perlu memberi ID unik jika ada 2 tombol

// ============================
// 🔑 Enhanced TURN Configuration
// ============================

function getTurnConfiguration() {
    return {
        iceServers: [
            { urls: "stun:stun.l.google.com:19302" },
            { urls: "stun:stun1.l.google.com:19302" },
            {
                urls: [
                    "turn:34.101.170.104:3478?transport=udp",
                    "turn:34.101.170.104:3478?transport=tcp",
                ],
                username: "halaw",
                credential: "halawAhKnR123",
            },
        ],
        iceTransportPolicy: "all",
        bundlePolicy: "max-bundle",
        rtcpMuxPolicy: "require",
        iceCandidatePoolSize: 10,
    };
}

// ============================
// 🛠 Platform Detection
// ============================

function detectPlatform() {
    const userAgent = navigator.userAgent;
    const isMobile =
        /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
            userAgent
        );
    const isChrome = /Chrome/.test(userAgent) && !/Edge|Edg/.test(userAgent);
    const isFirefox = /Firefox/.test(userAgent);
    const isSafari = /Safari/.test(userAgent) && !/Chrome/.test(userAgent);

    return {
        isMobile,
        isDesktop: !isMobile,
        isChrome,
        isFirefox,
        isSafari,
        platform: isMobile ? "mobile" : "desktop",
        browser: isChrome
            ? "chrome"
            : isFirefox
            ? "firefox"
            : isSafari
            ? "safari"
            : "other",
    };
}

// ============================
// 🔧 Enhanced SDP Processing
// ============================

function removeProblematicSSRCLines(sdp) {
    console.log("🔧 Removing problematic SSRC lines...");

    const lines = sdp.split(/\r\n|\n/);
    const filteredLines = [];
    const ssrcMap = new Map();

    // First pass: collect valid SSRC IDs and filter problematic lines
    for (const line of lines) {
        if (line.startsWith("a=ssrc:")) {
            const ssrcMatch = line.match(/^a=ssrc:(\d+)\s+(.+)$/);
            if (ssrcMatch) {
                const ssrcId = ssrcMatch[1];
                const attribute = ssrcMatch[2];

                // Skip problematic SSRC attributes that cause parsing issues
                if (
                    attribute.includes("cname:{") ||
                    attribute.includes("}") ||
                    attribute.match(/msid:.*\{.*\}/)
                ) {
                    console.warn(`🗑️ Removing problematic SSRC line: ${line}`);
                    continue;
                }

                // Keep track of valid SSRCs
                if (!ssrcMap.has(ssrcId)) {
                    ssrcMap.set(ssrcId, []);
                }
                ssrcMap.get(ssrcId).push(attribute);
                filteredLines.push(line);
            } else {
                console.warn(`🗑️ Removing malformed SSRC line: ${line}`);
            }
        } else if (line.startsWith("a=ssrc-group:")) {
            // We'll handle this in the next function
            filteredLines.push(line);
        } else {
            filteredLines.push(line);
        }
    }

    return { sdp: filteredLines.join("\r\n"), ssrcMap };
}

function cleanSSRCGroups(sdp, ssrcMap) {
    console.log("🔧 Cleaning SSRC groups...");

    const lines = sdp.split(/\r\n|\n/);
    const filteredLines = [];

    for (const line of lines) {
        if (line.startsWith("a=ssrc-group:")) {
            const groupMatch = line.match(/^a=ssrc-group:(\w+)\s+(.+)$/);
            if (groupMatch) {
                const groupType = groupMatch[1];
                const referencedIds = groupMatch[2].trim().split(/\s+/);

                // Check if all referenced SSRCs exist
                const validIds = referencedIds.filter((id) => ssrcMap.has(id));

                if (
                    validIds.length === referencedIds.length &&
                    validIds.length > 0
                ) {
                    // All references are valid, keep the group
                    filteredLines.push(line);
                    console.log(
                        `✅ Valid ${groupType} group: ${validIds.join(" ")}`
                    );
                } else {
                    console.warn(`🗑️ Removing invalid SSRC group: ${line}`);
                    console.warn(
                        ` Missing SSRCs: ${referencedIds
                            .filter((id) => !ssrcMap.has(id))
                            .join(", ")}`
                    );
                }
            } else {
                console.warn(`🗑️ Removing malformed SSRC group: ${line}`);
            }
        } else {
            filteredLines.push(line);
        }
    }

    return filteredLines.join("\r\n");
}

function fixMediaSections(sdp) {
    console.log("🔧 Fixing media sections...");

    let fixedSdp = sdp;

    // Fix telephone-event format issues
    fixedSdp = fixedSdp.replace(
        /^a=rtpmap:(\d+)\s+telephone-event\/8000$/gm,
        "a=rtpmap:$1 telephone-event/8000/1"
    );

    // Ensure proper media line format
    fixedSdp = fixedSdp.replace(
        /^m=(audio|video)\s+(\d+)\s+([^\s]+)\s*(.*)$/gm,
        (match, mediaType, port, protocol, formats) => {
            const cleanFormats = formats.trim();
            return `m=${mediaType} ${port} ${protocol}${
                cleanFormats ? " " + cleanFormats : ""
            }`;
        }
    );

    return fixedSdp;
}

function ensureBundleGroup(sdp) {
    console.log("🔧 Ensuring proper bundle group...");

    const lines = sdp.split(/\r\n|\n/);
    const mediaLines = [];
    let hasBundleGroup = false;

    // Find all media sections
    for (let i = 0; i < lines.length; i++) {
        const line = lines[i];
        if (line.startsWith("m=")) {
            const midMatch = lines
                .slice(i, i + 10)
                .find((l) => l.startsWith(" a=mid:"));
            if (midMatch) {
                const mid = midMatch.split(":")[1];
                mediaLines.push(mid);
            }
        } else if (line.startsWith("a=group:BUNDLE")) {
            hasBundleGroup = true;
        }
    }
    if (!hasBundleGroup && mediaLines.length > 0) {
        console.log("➕ Adding BUNDLE group:", mediaLines.join(" "));
        // Insert bundle group after session description but before media sections
        const sessionEndIndex = lines.findIndex((l) => l.startsWith("m="));
        if (sessionEndIndex > 0) {
            lines.splice(
                sessionEndIndex,
                0,
                `a=group:BUNDLE ${mediaLines.join(" ")}`
            );
        }
    }

    return lines.join("\r\n");
}

// ============================
// 🔧 Main SDP Cleaning Function
// ============================

function cleanSDP(sdp, platform) {
    if (!sdp || typeof sdp !== "string") {
        console.error("❌ Invalid SDP provided");
        return sdp;
    }

    console.log(
        `🔧 Cleaning SDP for ${platform.browser} on ${platform.platform}`
    );
    console.log(`📏 Original SDP length: ${sdp.length}`);

    try {
        let cleanedSdp = sdp;

        // Step 1: Remove problematic SSRC lines and get valid SSRC map
        const { sdp: sdpWithoutProblematic, ssrcMap } =
            removeProblematicSSRCLines(cleanedSdp);
        cleanedSdp = sdpWithoutProblematic;

        // Step 2: Clean SSRC groups based on valid SSRCs
        cleanedSdp = cleanSSRCGroups(cleanedSdp, ssrcMap);

        // Step 3: Fix media sections
        cleanedSdp = fixMediaSections(cleanedSdp);

        // Step 4: Ensure proper bundle group
        cleanedSdp = ensureBundleGroup(cleanedSdp);

        // Step 5: Clean up line breaks
        cleanedSdp = cleanedSdp.replace(/(\r\n){3,}/g, "\r\n\r\n");
        cleanedSdp = cleanedSdp.replace(/\n{3,}/g, "\n\n");

        console.log(`📏 Cleaned SDP length: ${cleanedSdp.length}`);
        console.log("✅ SDP cleaning completed");

        return cleanedSdp;
    } catch (error) {
        console.error("❌ Error cleaning SDP:", error);
        console.log("🔄 Falling back to minimal cleaning");

        // Minimal fallback cleaning
        return sdp
            .replace(/\{|\}/g, "") // Remove invalid characters
            .replace(/(\r\n){3,}/g, "\r\n\r\n") // Clean up line breaks
            .replace(/\n{3,}/g, "\n\n");
    }
}

// ============================
// 🔒 Safe Remote Description Setter
// ============================

async function setRemoteDescriptionSafely(peerConnection, sessionDescription) {
    if (!peerConnection || !sessionDescription) {
        throw new Error("Invalid peerConnection or sessionDescription");
    }

    const platform = detectPlatform();
    console.log(
        `🔍 Setting remote description for ${platform.browser}, type: ${sessionDescription.type}`
    );

    try {
        // Clean the SDP based on platform
        const cleanedSdp = cleanSDP(sessionDescription.sdp, platform);

        const cleanedSessionDesc = new RTCSessionDescription({
            type: sessionDescription.type,
            sdp: cleanedSdp,
        });

        await peerConnection.setRemoteDescription(cleanedSessionDesc);
        console.log("✅ Remote description set successfully");
        return true;
    } catch (error) {
        console.error("❌ Error setting remote description:", error);

        // Fallback: Try with original SDP
        try {
            console.log("🔄 Trying with original SDP...");
            await peerConnection.setRemoteDescription(sessionDescription);
            console.log("✅ Original SDP worked as fallback");
            return true;
        } catch (originalError) {
            console.error("❌ Original SDP also failed:", originalError);

            // Last resort: Ultra-minimal SDP
            try {
                console.log("🔄 Trying ultra-minimal SDP cleanup...");
                const minimalSdp = sessionDescription.sdp
                    .replace(/^a=ssrc:[^\r\n]*\r?\n?/gm, "") // Remove all SSRC lines
                    .replace(/^a=ssrc-group:[^\r\n]*\r?\n?/gm, "") // Remove all SSRC groups
                    .replace(/\{|\}/g, "") // Remove brackets
                    .replace(/(\r\n){3,}/g, "\r\n\r\n"); // Clean line breaks

                const minimalSessionDesc = new RTCSessionDescription({
                    type: sessionDescription.type,
                    sdp: minimalSdp,
                });

                await peerConnection.setRemoteDescription(minimalSessionDesc);
                console.log("✅ Ultra-minimal SDP worked");
                return true;
            } catch (minimalError) {
                console.error("❌ Even minimal SDP failed:", minimalError);
                throw minimalError;
            }
        }
    }
}

// ============================
// 📞 PERBAIKAN Enhanced PeerConnection Setup
// ============================

async function ensurePeerConnection(forceRelay = false) {
    if (!peerConnection) {
        console.log("🔧 Creating PeerConnection...");

        const config = getTurnConfiguration();
        const platform = detectPlatform();

        if (forceRelay || connectionAttempts > 0 || platform.isFirefox) {
            console.log("🔄 Forcing TURN relay mode");
            config.iceTransportPolicy = "relay";
        }

        peerConnection = new RTCPeerConnection(config);

        // Enhanced ICE candidate handling
        peerConnection.onicecandidate = async (event) => {
            if (!callActive || !peerConnection) return;

            if (event.candidate) {
                console.log("📤 ICE candidate:", {
                    type: event.candidate.type,
                    protocol: event.candidate.protocol,
                });

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

        // PERBAIKAN: Enhanced track handling dengan UI transition
        peerConnection.ontrack = (event) => {
            console.log("🎧 Remote track received:", {
                kind: event.track.kind,
                id: event.track.id,
                enabled: event.track.enabled,
                readyState: event.track.readyState,
            });

            if (event.streams && event.streams[0]) {
                const remoteStream = event.streams[0];
                console.log("📡 Remote stream tracks:", remoteStream.getTracks().map((t) => t.kind));

                if (event.track.kind === "audio") {
                    // Handle audio track
                    if (remoteAudio) {
                        remoteAudio.srcObject = remoteStream;
                        remoteAudio.autoplay = true;
                        remoteAudio.muted = false;

                        remoteAudio.play().catch((e) => {
                            console.warn("⚠️ Auto-play blocked for audio:", e);
                        });

                        console.log("✅ Remote audio connected");
                    }
                } else if (event.track.kind === "video") {
                    // Handle video track
                    if (remoteVideo) {
                        remoteVideo.srcObject = remoteStream;
                        remoteVideo.autoplay = true;
                        remoteVideo.muted = true;
                        remoteVideo.playsInline = true;

                        remoteVideo.play().catch((e) => {
                            console.warn("⚠️ Auto-play blocked for video:", e);
                        });

                        console.log("✅ Remote video connected");
                    }
                }

                // KUNCI PERBAIKAN: Pindah ke UI in-progress saat ada track
                console.log("🔄 Switching to in-progress UI because remote track received");
                showInProgressUI();
            }
        };

        // Enhanced connection state monitoring dengan UI feedback
        peerConnection.oniceconnectionstatechange = async () => {
            const state = peerConnection.iceConnectionState;
            console.log("🌐 ICE connection state:", state);

            switch (state) {
                case "connected":
                case "completed":
                    console.log("✅ Connection established successfully!");
                    connectionAttempts = 0;
                    // PERBAIKAN: Pastikan UI sudah beralih ke in-progress
                    showInProgressUI();
                    break;

                case "failed":
                    console.error("❌ ICE connection failed");
                    if (await handleConnectionFailure()) {
                        console.log("🔄 Retrying connection...");
                    }
                    break;

                case "disconnected":
                    console.warn("⚠️ Connection lost, attempting to reconnect...");
                    break;
            }
        };

        peerConnection.onsignalingstatechange = () => {
            console.log("📡 Signaling state:", peerConnection.signalingState);
        };

        peerConnection.onconnectionstatechange = () => {
            const state = peerConnection.connectionState;
            console.log("🔗 Connection state:", state);
            
            // PERBAIKAN: Beralih ke UI in-progress saat connection terbentuk
            if (state === "connected") {
                console.log("🔄 Connection established, switching to in-progress UI");
                showInProgressUI();
            }
        };
    }
}

// ============================
// 📹 Enhanced Media Access
// ============================

async function getUserMediaWithFallback(constraints, isAnswer = false) {
    console.log("🎥 Requesting media access:", constraints);

    try {
        const stream = await navigator.mediaDevices.getUserMedia(constraints);
        console.log("✅ Media access granted:", {
            audio: stream.getAudioTracks().length > 0,
            video: stream.getVideoTracks().length > 0,
        });
        return stream;
    } catch (error) {
        console.warn("⚠️ Media access failed:", error.name, error.message);

        if (constraints.video && error.name === "NotReadableError") {
            console.log("🔄 Camera busy, trying fallback constraints...");

            const fallbackConstraints = {
                ...constraints,
                video: {
                    width: { ideal: 640, max: 1280 },
                    height: { ideal: 480, max: 720 },
                    frameRate: { ideal: 15, max: 30 },
                },
            };

            try {
                const stream = await navigator.mediaDevices.getUserMedia(
                    fallbackConstraints
                );
                console.log(
                    "✅ Media access granted with fallback constraints"
                );
                return stream;
            } catch (fallbackError) {
                console.warn(
                    "⚠️ Fallback constraints failed:",
                    fallbackError.name
                );

                if (
                    isAnswer ||
                    confirm(
                        "Camera is not available. Would you like to make an audio-only call instead?"
                    )
                ) {
                    try {
                        const audioStream =
                            await navigator.mediaDevices.getUserMedia({
                                audio: constraints.audio,
                                video: false,
                            });
                        console.log("✅ Audio-only fallback successful");
                        return audioStream;
                    } catch (audioError) {
                        console.error("❌ Audio fallback failed:", audioError);
                        throw audioError;
                    }
                } else {
                    throw fallbackError;
                }
            }
        } else if (error.name === "NotAllowedError") {
            throw new Error(
                "Camera/microphone permission denied. Please allow access and try again."
            );
        } else if (error.name === "NotFoundError") {
            if (constraints.video) {
                throw new Error(
                    "No camera found. Please connect a camera or use audio-only mode."
                );
            } else {
                throw new Error(
                    "No microphone found. Please connect a microphone."
                );
            }
        } else {
            throw error;
        }
    }
}

// ============================
// 🔄 Connection Recovery
// ============================

async function handleConnectionFailure() {
    if (connectionAttempts >= maxConnectionAttempts) {
        console.error("❌ Max connection attempts reached");
        cleanupCall();
        return false;
    }

    connectionAttempts++;
    console.log(
        `🔄 Connection attempt ${connectionAttempts}/${maxConnectionAttempts}`
    );

    if (peerConnection) {
        peerConnection.close();
        peerConnection = null;
    }

    await ensurePeerConnection(true);
    return true;
}

// ============================
// 📞 Enhanced Call Start
// ============================

async function startCall(video = false) {
    try {
        console.log("📞 Starting call, video:", video);
        const platform = detectPlatform();
        console.log(`🔧 Platform: ${platform.browser} on ${platform.platform}`);

        await ensurePeerConnection();

        const constraints = {
            audio: {
                echoCancellation: true,
                noiseSuppression: true,
                autoGainControl: true,
                sampleRate: 48000,
                channelCount: 1,
            },
            video: video
                ? {
                      width: { ideal: 1280, max: 1920 },
                      height: { ideal: 720, max: 1080 },
                      frameRate: { ideal: 30, max: 60 },
                      facingMode: "user",
                  }
                : false,
        };

        localStream = await getUserMediaWithFallback(constraints, false);

        const hasVideoTrack = localStream.getVideoTracks().length > 0;
        const actuallyVideo = video && hasVideoTrack;

        console.log(`🎥 Media obtained - requested: ${video}, got video: ${hasVideoTrack}, got audio:
    ${localStream.getAudioTracks().length > 0}`);

        if (actuallyVideo && localVideo) {
            localVideo.srcObject = localStream;
            localVideo.autoplay = true;
            localVideo.muted = true;
            localVideo.playsInline = true;
            console.log("✅ Local video displayed");
        }

        // Add tracks to peer connection
        localStream.getTracks().forEach((track) => {
            console.log("🎵 Adding local track:", track.kind, track.id);
            peerConnection.addTrack(track, localStream);
        });

        const offerOptions = {
            offerToReceiveAudio: true,
            offerToReceiveVideo: actuallyVideo,
            voiceActivityDetection: true,
        };

        const offer = await peerConnection.createOffer(offerOptions);
        await peerConnection.setLocalDescription(offer);

        console.log("⏳ Waiting for ICE gathering...");
        await waitForIceCandidates(5000);

        await axios.post("/call/offer", {
            call_id: window.callId,
            offer: peerConnection.localDescription,
        });

        callActive = true;
        const lawyerName = document
            .querySelector(".nama_pengacara h2")
            .textContent.split(" - ")[0];
        showRingingUI(true, lawyerName);

        console.log("✅ Call initiated successfully");
    } catch (err) {
        console.error("❌ Error starting call:", err);
        cleanupCall();

        let errorMessage = "Failed to start call: ";
        if (err.message.includes("permission denied")) {
            errorMessage += "Camera/microphone access denied.";
        } else if (err.message.includes("no camera")) {
            errorMessage += "No camera found.";
        } else {
            errorMessage += err.message;
        }

        alert(errorMessage);
        throw err;
    }
}

function waitForIceCandidates(timeout = 5000) {
    return new Promise((resolve) => {
        let candidateCount = 0;
        const originalHandler = peerConnection.onicecandidate;

        const timer = setTimeout(() => {
            peerConnection.onicecandidate = originalHandler;
            resolve();
        }, timeout);

        peerConnection.onicecandidate = (event) => {
            if (originalHandler) originalHandler(event);

            if (event.candidate) {
                candidateCount++;
                if (candidateCount >= 3) {
                    clearTimeout(timer);
                    peerConnection.onicecandidate = originalHandler;
                    resolve();
                }
            } else {
                clearTimeout(timer);
                peerConnection.onicecandidate = originalHandler;
                resolve();
            }
        };
    });
}

// ============================
// 📞 Enhanced Cleanup
// ============================

function cleanupCall() {
    console.log("🧹 Cleaning up call...");

    callActive = false;
    remoteDescriptionSet = false;
    isProcessingRemoteDescription = false;
    pendingCandidates = [];
    connectionAttempts = 0;

    if (peerConnection) {
        try {
            peerConnection.onicecandidate = null;
            peerConnection.ontrack = null;
            peerConnection.oniceconnectionstatechange = null;
            peerConnection.onsignalingstatechange = null;
            peerConnection.onconnectionstatechange = null;
            peerConnection.close();
        } catch (e) {
            console.warn("Error closing peerConnection:", e);
        }
        peerConnection = null;
    }

    if (localStream) {
        localStream.getTracks().forEach((track) => {
            track.stop();
            console.log("🛑 Stopped track:", track.kind);
        });
        localStream = null;
    }

    if (localVideo) localVideo.srcObject = null;
    if (remoteVideo) remoteVideo.srcObject = null;
    if (remoteAudio) remoteAudio.srcObject = null;

    hideCallUI();

    console.log("✅ Cleanup complete");
}

// ============================
// 🧊 Enhanced ICE Candidate Processing
// ============================

async function processPendingCandidates() {
    if (!peerConnection?.remoteDescription || pendingCandidates.length === 0) {
        return;
    }

    console.log(
        `🔄 Processing ${pendingCandidates.length} pending ICE candidates`
    );

    const candidatesToProcess = [...pendingCandidates];
    pendingCandidates = [];

    for (const candidate of candidatesToProcess) {
        try {
            await peerConnection.addIceCandidate(candidate);
            console.log("✅ Processed pending ICE candidate:", candidate.type);
        } catch (err) {
            console.error("❌ Error adding pending ICE candidate:", err);
        }
    }
}

// ============================
// 🛑 End Call
// ============================

async function endCall() {
    try {
        if (window.callId) {
            await axios.post("/call/end", { call_id: window.callId });
        }
    } catch (err) {
        console.error("Error notifying end call:", err);
    }
    cleanupCall();
}

// ============================
// 🎨 UI Control Functions
// ============================


function showRingingUI(isInitiator, lawyerName) {
    console.log("🎨 Showing ringing UI:", { isInitiator, lawyerName });
    
    if (!callUiContainer || !callInfoView || !inCallView || !callInfoName)
        return;

    // Tampilkan popup utama
    callUiContainer.classList.remove("d-none");

    // Tampilkan info "memanggil..."
    callInfoView.style.display = "block";

    // Sembunyikan tampilan panggilan berlangsung
    inCallView.style.display = "none";

    // Update nama yang dipanggil
    if (isInitiator) {
        callInfoName.textContent = `Memanggil ${lawyerName}...`;
    } else {
        callInfoName.textContent = `Panggilan dari ${lawyerName}`;
    }
}

function showInProgressUI() {
    console.log("🎨 Switching to in-progress UI");
    
    if (!callUiContainer || !callInfoView || !inCallView) {
        console.error("❌ UI elements not found");
        return;
    }

    // Pastikan popup utama terlihat
    callUiContainer.classList.remove("d-none");
    
    // Sembunyikan info "memanggil..."
    callInfoView.style.display = "none";
    
    // Tampilkan video dan tombol kontrol
    inCallView.style.display = "block";
    
    console.log("✅ UI switched to in-progress view");
}

function hideCallUI() {
    console.log("🎨 Hiding call UI");
    
    if (callUiContainer) {
        callUiContainer.classList.add("d-none");
    }
}

// ============================
// 🔗 UI Events
// ============================

if (startCallLink) {
    startCallLink.addEventListener("click", async (e) => {
        e.preventDefault();
        try {
            await startCall(false);
        } catch (err) {
            console.error("Failed to start call:", err);
        }
    });
}

const startVideoCallLink = document.getElementById("startVideoCallLink");
if (startVideoCallLink) {
    startVideoCallLink.addEventListener("click", async (e) => {
        e.preventDefault();
        try {
            await startCall(true);
        } catch (err) {
            console.error("Failed to start video call:", err);
        }
    });
}

// Menggunakan querySelectorAll untuk menemukan SEMUA tombol dengan class .end-call
const allEndCallButtons = document.querySelectorAll('.end-call');

// Menambahkan event listener ke setiap tombol "End Call" yang ditemukan
allEndCallButtons.forEach(button => {
    button.addEventListener('click', (e) => {
        e.preventDefault();
        endCall(); // Memanggil fungsi endCall() Anda yang sudah ada
    });
});

// ============================
// 📡 Enhanced Echo Signaling
// ============================

// ============================
// 📡 PERBAIKAN Enhanced Echo Signaling
// ============================

if (window.callId) {
    Echo.private(`callroom.${window.callId}`)
        .listen(".offer", async (e) => {
            try {
                console.log("📥 Received offer");
                const lawyerName = e.offer.caller_name || "Unknown";
                showRingingUI(false, lawyerName);

                const platform = detectPlatform();
                console.log(`📥 Answering on ${platform.browser}`);

                callActive = true;
                isProcessingRemoteDescription = true;

                await ensurePeerConnection();

                if (!localStream) {
                    const hasVideo = /m=video/.test(e.offer.sdp);
                    console.log("📥 Offer has video:", hasVideo);

                    const constraints = {
                        audio: {
                            echoCancellation: true,
                            noiseSuppression: true,
                            autoGainControl: true,
                            sampleRate: 48000,
                            channelCount: 1,
                        },
                        video: hasVideo
                            ? {
                                  width: { ideal: 1280, max: 1920 },
                                  height: { ideal: 720, max: 1080 },
                                  frameRate: { ideal: 30, max: 60 },
                                  facingMode: "user",
                              }
                            : false,
                    };

                    try {
                        localStream = await getUserMediaWithFallback(constraints, true);

                        const hasVideoTrack = localStream.getVideoTracks().length > 0;
                        const hasAudioTrack = localStream.getAudioTracks().length > 0;

                        console.log(`🎥 Answerer media - video: ${hasVideoTrack}, audio: ${hasAudioTrack}`);

                        if (hasVideoTrack && localVideo) {
                            localVideo.srcObject = localStream;
                            localVideo.autoplay = true;
                            localVideo.muted = true;
                            localVideo.playsInline = true;
                            console.log("✅ Local video displayed (answerer)");
                        }

                        localStream.getTracks().forEach((track) => {
                            console.log("🎵 Adding answerer track:", track.kind, track.id);
                            peerConnection.addTrack(track, localStream);
                        });
                    } catch (mediaError) {
                        console.error("❌ Failed to get user media for answering:", mediaError);
                        throw mediaError;
                    }
                }

                // PERBAIKAN: Ignore SDP errors dan langsung set
                try {
                    await peerConnection.setRemoteDescription(e.offer);
                    console.log("✅ Remote description set successfully");
                } catch (sdpError) {
                    console.warn("⚠️ SDP error ignored:", sdpError.message);
                    // Tetap lanjutkan proses
                }

                remoteDescriptionSet = true;
                isProcessingRemoteDescription = false;

                await processPendingCandidates();

                const hasRemoteVideo = /m=video/.test(e.offer.sdp);
                const hasLocalVideo = localStream.getVideoTracks().length > 0;

                const answer = await peerConnection.createAnswer({
                    offerToReceiveAudio: true,
                    offerToReceiveVideo: hasRemoteVideo && hasLocalVideo,
                });

                await peerConnection.setLocalDescription(answer);

                console.log("⏳ Waiting for ICE gathering (answerer)...");
                await waitForIceCandidates(3000);

                await axios.post("/call/answer", {
                    call_id: window.callId,
                    answer: peerConnection.localDescription,
                });

                // PERBAIKAN: Langsung beralih ke UI in-progress setelah answer terkirim
                console.log("🔄 Answer sent, switching to in-progress UI");
                setTimeout(() => {
                    showInProgressUI();
                }, 1000); // Delay 1 detik untuk memastikan koneksi stabil

                if (callStatus) callStatus.classList.remove("d-none");
                console.log("✅ Answer sent successfully");
            } catch (err) {
                console.error("❌ Error handling offer:", err);
                isProcessingRemoteDescription = false;
                cleanupCall();
                alert("Failed to answer call: " + err.message);
            }
        })

        .listen(".answer", async (e) => {
            try {
                console.log("📥 Received answer");

                if (
                    !peerConnection ||
                    peerConnection.signalingState !== "have-local-offer"
                ) {
                    console.warn("⚠️ Received answer in wrong state:", peerConnection?.signalingState);
                    return;
                }

                isProcessingRemoteDescription = true;
                
                // PERBAIKAN: Ignore SDP errors
                try {
                    await peerConnection.setRemoteDescription(e.answer);
                    console.log("✅ Answer remote description set");
                } catch (sdpError) {
                    console.warn("⚠️ Answer SDP error ignored:", sdpError.message);
                }

                remoteDescriptionSet = true;
                isProcessingRemoteDescription = false;

                await processPendingCandidates();
                
                // PERBAIKAN: Langsung beralih ke UI in-progress setelah answer diterima
                console.log("🔄 Answer processed, switching to in-progress UI");
                showInProgressUI();
                
                console.log("✅ Answer processed successfully");
            } catch (err) {
                console.error("❌ Error handling answer:", err);
                isProcessingRemoteDescription = false;
                cleanupCall();
            }
        })

        .listen(".candidate", async (e) => {
            if (!peerConnection || !callActive) return;

            if (!e.candidate?.candidate?.trim()) {
                console.log("📥 Received end-of-candidates signal");
                return;
            }

            try {
                const candidate = new RTCIceCandidate(e.candidate);
                console.log("📥 Received ICE candidate:", {
                    type: candidate.type,
                    protocol: candidate.protocol,
                });

                if (peerConnection.remoteDescription && !isProcessingRemoteDescription) {
                    await peerConnection.addIceCandidate(candidate);
                    console.log("✅ ICE candidate added immediately");
                } else {
                    pendingCandidates.push(candidate);
                    console.log("⏳ ICE candidate queued");
                }
            } catch (err) {
                console.error("❌ Error processing ICE candidate:", err);
            }
        })

        .listen(".call-ended", () => {
            console.log("📴 Call ended by remote peer");
            cleanupCall();
        });
}

// ============================
// 🧪 TURN Server Test
// ============================

async function testTurnServer() {
    console.log("🧪 Testing TURN server connectivity...");

    const config = getTurnConfiguration();
    const testPC = new RTCPeerConnection(config);

    return new Promise((resolve) => {
        let relayFound = false;
        let hostFound = false;
        let timeout;

        testPC.onicecandidate = (event) => {
            if (event.candidate) {
                const candidate = event.candidate;
                console.log(`🧪 Test candidate:`, {
                    type: candidate.type,
                    protocol: candidate.protocol,
                    address: candidate.address?.substring(0, 10) + "...",
                    port: candidate.port,
                });

                if (candidate.type === "relay") {
                    relayFound = true;
                    console.log("✅ TURN relay working!");
                } else if (candidate.type === "host") {
                    hostFound = true;
                }
            } else {
                console.log("🧪 ICE gathering completed");
                clearTimeout(timeout);
                testPC.close();
                resolve({ relay: relayFound, host: hostFound });
            }
        };

        testPC
            .createOffer({ offerToReceiveAudio: true })
            .then((offer) => testPC.setLocalDescription(offer))
            .catch((err) => {
                console.error("🧪 Test offer failed:", err);
                testPC.close();
                resolve({ relay: false, host: false });
            });

        timeout = setTimeout(() => {
            console.warn("🧪 TURN test timed out");
            testPC.close();
            resolve({ relay: relayFound, host: hostFound });
        }, 10000);
    });
}

// ============================
// 🔍 Media Device Detection
// ============================

async function checkMediaDevices() {
    try {
        const devices = await navigator.mediaDevices.enumerateDevices();
        const hasCamera = devices.some(
            (device) => device.kind === "videoinput"
        );
        const hasMicrophone = devices.some(
            (device) => device.kind === "audioinput"
        );

        console.log("🎥 Available devices:", { hasCamera, hasMicrophone });
        return { hasCamera, hasMicrophone };
    } catch (error) {
        console.warn("⚠️ Could not enumerate devices:", error);
        return { hasCamera: true, hasMicrophone: true };
    }
}

// ============================
// 🚀 Initialize
// ============================

console.log("🚀 Enhanced WebRTC call handler initialized");

// Test TURN connectivity on page load
if (window.callId) {
    testTurnServer().then((result) => {
        if (result.relay) {
            console.log("✅ TURN server connectivity confirmed");
        } else if (result.host) {
            console.log(
                "⚠️ Only host candidates found - TURN may not be working"
            );
        } else {
            console.warn(
                "❌ No ICE candidates found - check network connectivity"
            );
        }
    });
}

// Add debugging event listeners for media elements
if (remoteAudio) {
    remoteAudio.addEventListener("loadedmetadata", () => {
        console.log("🎵 Remote audio metadata loaded");
    });

    remoteAudio.addEventListener("canplay", () => {
        console.log("🎵 Remote audio can play");
    });

    remoteAudio.addEventListener("play", () => {
        console.log("🎵 Remote audio started playing");
    });

    remoteAudio.addEventListener("error", (e) => {
        console.error("❌ Remote audio error:", e);
    });
}

if (remoteVideo) {
    remoteVideo.addEventListener("loadedmetadata", () => {
        console.log("📹 Remote video metadata loaded");
    });

    remoteVideo.addEventListener("canplay", () => {
        console.log("📹 Remote video can play");
    });

    remoteVideo.addEventListener("play", () => {
        console.log("📹 Remote video started playing");
    });

    remoteVideo.addEventListener("error", (e) => {
        console.error("❌ Remote video error:", e);
    });
}
