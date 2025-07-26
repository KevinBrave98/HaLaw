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

// ============================
// 🔑 Enhanced TURN Configuration
// ============================

function getTurnConfiguration() {
    // Simplified, proven TURN configuration
    return {
        iceServers: [
            // Google's public STUN servers for basic connectivity
            { urls: "stun:stun.l.google.com:19302" },
            { urls: "stun:stun1.l.google.com:19302" },
            
            // Your TURN server - simplified to most reliable configuration
            {
                urls: [
                    "turn:34.101.170.104:3478?transport=udp",
                    "turn:34.101.170.104:3478?transport=tcp"
                ],
                username: "halaw",
                credential: "halawAhKnR123"
            }
        ],
        // Use 'all' for maximum compatibility, 'relay' only for testing
        iceTransportPolicy: "all",
        bundlePolicy: "max-bundle",
        rtcpMuxPolicy: "require",
        // Add these for better connectivity
        iceCandidatePoolSize: 10
    };
}

// ============================
// 🧪 Enhanced TURN Server Test
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
                    address: candidate.address,
                    port: candidate.port
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
        
        // Create offer to start ICE gathering
        testPC.createOffer({ offerToReceiveAudio: true })
            .then(offer => testPC.setLocalDescription(offer))
            .catch(err => {
                console.error("🧪 Test offer failed:", err);
                testPC.close();
                resolve({ relay: false, host: false });
            });
        
        // Timeout after 10 seconds
        timeout = setTimeout(() => {
            console.warn("🧪 TURN test timed out");
            testPC.close();
            resolve({ relay: relayFound, host: hostFound });
        }, 10000);
    });
}

// ============================
// 🛠 Platform Detection & SDP Processing 
// ============================

function detectPlatform() {
    const userAgent = navigator.userAgent;
    const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(userAgent);
    const isChrome = /Chrome/.test(userAgent) && !/Edge|Edg/.test(userAgent);
    const isFirefox = /Firefox/.test(userAgent);
    
    return {
        isMobile,
        isDesktop: !isMobile,
        isChrome,
        isFirefox,
        platform: isMobile ? 'mobile' : 'desktop',
        browser: isChrome ? 'chrome' : isFirefox ? 'firefox' : 'other'
    };
}

// DESKTOP Chrome SDP fixes (your original working code)
function sanitizeSSRCDesktop(sdp) {
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

function fixTelephoneEventDesktop(sdp) {
    if (!sdp || typeof sdp !== "string") return sdp;

    console.log("🔧 Desktop: Checking for telephone-event issues");

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
                    console.warn("⚠️ Removing duplicate telephone-event rtpmap:", line);
                    return false;
                }
                seenTelephoneEventRtpmap.add(payloadType);

                // Ensure proper format for desktop
                if (!line.includes("/8000/1") && line.includes("telephone-event/8000")) {
                    console.warn("⚠️ Fixing telephone-event format:", line);
                    return false; // Remove malformed line, proper one will be added above
                }
            }
        }
        return true;
    });

    return lines.join("\r\n");
}

function cleanAudioOnlySDPDesktop(sdp) {
    console.log("🗑️ Desktop: Audio-only call - cleaning SDP");
    
    // First fix telephone-event issues
    sdp = fixTelephoneEventDesktop(sdp);
    
    // Then remove SSRC lines for desktop
    return sdp.replace(/^a=ssrc:[^\r\n]*\r?\n?/gm, "");
}

// MOBILE SDP processing - minimal/no changes
function cleanSDPMobile(sdp, isVideoCall = false) {
    console.log("📱 Mobile: Minimal SDP processing, video:", isVideoCall);
    
    // For mobile, just clean up excessive line breaks
    let cleanedSdp = sdp.replace(/(\r\n){3,}/g, "\r\n\r\n");
    
    console.log("📱 Mobile SDP processed, length:", cleanedSdp.length);
    return cleanedSdp;
}

// DESKTOP SDP processing - your original aggressive cleaning
function cleanSDPDesktop(sdp, isVideoCall = false) {
    console.log("🖥️ Desktop: Full SDP cleaning, video:", isVideoCall);
    
    let cleanedSdp = sanitizeSSRCDesktop(sdp);
    
    if (!isVideoCall) {
        cleanedSdp = cleanAudioOnlySDPDesktop(cleanedSdp);
    } else {
        cleanedSdp = fixTelephoneEventDesktop(cleanedSdp);
    }
    
    // Clean up excessive line breaks
    cleanedSdp = cleanedSdp.replace(/(\r\n){3,}/g, "\r\n\r\n");
    
    console.log("🖥️ Desktop SDP cleaned, length:", cleanedSdp.length);
    return cleanedSdp;
}

// Main SDP cleaning function - routes to platform-specific handler
function cleanSDP(sdp, isVideoCall = false) {
    const platform = detectPlatform();
    
    console.log(`🔧 Platform detected: ${platform.platform} ${platform.browser}`);
    
    if (platform.isMobile) {
        return cleanSDPMobile(sdp, isVideoCall);
    } else {
        return cleanSDPDesktop(sdp, isVideoCall);
    }
}

// ============================
// 🔒 Safe Remote Description Setter
// ============================

async function setRemoteDescriptionSafely(peerConnection, sessionDescription) {
    try {
        console.log("🔍 Setting remote description, type:", sessionDescription.type);
        
        const isVideoCall = /m=video/.test(sessionDescription.sdp);
        const cleanedSdp = cleanSDP(sessionDescription.sdp, isVideoCall);
        
        const cleanedSessionDesc = new RTCSessionDescription({
            type: sessionDescription.type,
            sdp: cleanedSdp
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
// 🔄 Connection Recovery
// ============================

async function handleConnectionFailure() {
    if (connectionAttempts >= maxConnectionAttempts) {
        console.error("❌ Max connection attempts reached");
        cleanupCall();
        return false;
    }
    
    connectionAttempts++;
    console.log(`🔄 Connection attempt ${connectionAttempts}/${maxConnectionAttempts}`);
    
    // Force TURN relay on retry
    if (peerConnection) {
        peerConnection.close();
        peerConnection = null;
    }
    
    await ensurePeerConnection(true); // Force relay mode
    return true;
}

// ============================
// 📞 Enhanced PeerConnection Setup
// ============================

async function ensurePeerConnection(forceRelay = false) {
    if (!peerConnection) {
        console.log("🔧 Creating PeerConnection...");
        
        const config = getTurnConfiguration();
        
        // Force relay mode for difficult connections
        if (forceRelay || connectionAttempts > 0) {
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
                    address: event.candidate.address?.substring(0, 10) + "...", // Privacy
                    port: event.candidate.port
                });
                
                try {
                    await axios.post("/call/ice", {
                        call_id: window.callId,
                        candidate: event.candidate
                    });
                } catch (err) {
                    console.error("❌ Failed to send ICE:", err);
                }
            } else {
                console.log("✅ ICE gathering complete");
            }
        };
        
        peerConnection.ontrack = (event) => {
            console.log("🎧 Remote track received");
            if (remoteAudio && event.streams?.[0]) {
                remoteAudio.srcObject = event.streams[0];
                remoteAudio.autoplay = true;
                remoteAudio.muted = false;
                console.log("✅ Remote audio connected");
            }
        };
        
        // Enhanced connection state monitoring
        peerConnection.oniceconnectionstatechange = async () => {
            const state = peerConnection.iceConnectionState;
            console.log("🌐 ICE connection state:", state);
            
            switch (state) {
                case "connected":
                case "completed":
                    console.log("✅ Connection established successfully!");
                    connectionAttempts = 0; // Reset on success
                    break;
                    
                case "failed":
                    console.error("❌ ICE connection failed");
                    if (await handleConnectionFailure()) {
                        // Retry logic would go here
                        console.log("🔄 Retrying connection...");
                    }
                    break;
                    
                case "disconnected":
                    console.warn("⚠️ Connection lost, attempting to reconnect...");
                    // Could implement reconnection logic here
                    break;
            }
        };
        
        // Add signaling state monitoring
        peerConnection.onsignalingstatechange = () => {
            console.log("📡 Signaling state:", peerConnection.signalingState);
        };
    }
}

// ============================
// 📞 Enhanced Call Start
// ============================

async function startCall(video = false) {
    try {
        console.log("📞 Starting call, video:", video);
        
        // Test TURN server first
        const turnTest = await testTurnServer();
        if (!turnTest.relay && !turnTest.host) {
            console.warn("⚠️ No ICE candidates found, but continuing...");
        }
        
        await ensurePeerConnection();
        
        const constraints = {
            audio: {
                echoCancellation: true,
                noiseSuppression: true,
                autoGainControl: true,
                // Add sample rate for better compatibility
                sampleRate: 48000,
                channelCount: 1
            },
            video: video
        };
        
        localStream = await navigator.mediaDevices.getUserMedia(constraints);
        
        // Add tracks to peer connection
        localStream.getTracks().forEach(track => {
            console.log("🎵 Adding local track:", track.kind);
            peerConnection.addTrack(track, localStream);
        });
        
        // Create offer with specific constraints
        const offerOptions = {
            offerToReceiveAudio: true,
            offerToReceiveVideo: video,
            voiceActivityDetection: true
        };
        
        const offer = await peerConnection.createOffer(offerOptions);
        await peerConnection.setLocalDescription(offer);
        
        // Wait for ICE gathering to collect some candidates
        console.log("⏳ Gathering ICE candidates...");
        await waitForIceCandidates(5000); // Wait up to 5 seconds
        
        await axios.post("/call/offer", { 
            call_id: window.callId, 
            offer: peerConnection.localDescription 
        });
        
        callActive = true;
        if (callStatus) callStatus.classList.remove("d-none");
        
        console.log("✅ Call initiated successfully");
        
    } catch (err) {
        console.error("❌ Error starting call:", err);
        cleanupCall();
        throw err;
    }
}

// Helper function to wait for ICE candidates
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
                if (candidateCount >= 3) { // Got enough candidates
                    clearTimeout(timer);
                    peerConnection.onicecandidate = originalHandler;
                    resolve();
                }
            } else {
                // ICE gathering complete
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
            peerConnection.close();
        } catch (e) {
            console.warn("Error closing peerConnection:", e);
        }
        peerConnection = null;
    }
    
    if (localStream) {
        localStream.getTracks().forEach(track => {
            track.stop();
            console.log("🛑 Stopped track:", track.kind);
        });
        localStream = null;
    }
    
    if (remoteAudio) {
        remoteAudio.srcObject = null;
    }
    
    if (callStatus) callStatus.classList.add("d-none");
    
    console.log("✅ Cleanup complete");
}

// ============================
// 🧊 Enhanced ICE Candidate Processing
// ============================

async function processPendingCandidates() {
    if (!peerConnection?.remoteDescription || pendingCandidates.length === 0) {
        return;
    }
    
    console.log(`🔄 Processing ${pendingCandidates.length} pending ICE candidates`);
    
    const candidatesToProcess = [...pendingCandidates];
    pendingCandidates = [];
    
    for (const candidate of candidatesToProcess) {
        try {
            await peerConnection.addIceCandidate(candidate);
            console.log("✅ Processed pending ICE candidate:", candidate.type);
        } catch (err) {
            console.error("❌ Error adding pending ICE candidate:", err);
            // Don't fail the entire call for one bad candidate
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
// 🔗 UI Events
// ============================

if (startCallLink) {
    startCallLink.addEventListener("click", async (e) => {
        e.preventDefault();
        try {
            await startCall(false);
        } catch (err) {
            console.error("Failed to start call:", err);
            alert("Failed to start call. Please check your connection and try again.");
        }
    });
}

if (endCallBtn) {
    endCallBtn.addEventListener("click", (e) => {
        e.preventDefault();
        endCall();
    });
}

// ============================
// 📡 Enhanced Echo Signaling
// ============================

if (window.callId) {
    Echo.private(`callroom.${window.callId}`)
        .listen(".offer", async (e) => {
            try {
                console.log("📥 Received offer");
                
                callActive = true;
                isProcessingRemoteDescription = true;
                
                await ensurePeerConnection();
                
                // Get user media for answering
                if (!localStream) {
                    const constraints = {
                        audio: {
                            echoCancellation: true,
                            noiseSuppression: true,
                            autoGainControl: true,
                            sampleRate: 48000,
                            channelCount: 1
                        },
                        video: false
                    };
                    
                    localStream = await navigator.mediaDevices.getUserMedia(constraints);
                    localStream.getTracks().forEach(track => {
                        console.log("🎵 Adding answerer track:", track.kind);
                        peerConnection.addTrack(track, localStream);
                    });
                }
                
                await setRemoteDescriptionSafely(peerConnection, e.offer);
                remoteDescriptionSet = true;
                isProcessingRemoteDescription = false;
                
                await processPendingCandidates();
                
                const answer = await peerConnection.createAnswer({
                    offerToReceiveAudio: true,
                    offerToReceiveVideo: false
                });
                
                await peerConnection.setLocalDescription(answer);
                
                await axios.post("/call/answer", {
                    call_id: window.callId,
                    answer: peerConnection.localDescription
                });
                
                if (callStatus) callStatus.classList.remove("d-none");
                console.log("✅ Answer sent successfully");
                
            } catch (err) {
                console.error("❌ Error handling offer:", err);
                isProcessingRemoteDescription = false;
                cleanupCall();
            }
        })
        
        .listen(".answer", async (e) => {
            try {
                console.log("📥 Received answer");
                
                if (!peerConnection || peerConnection.signalingState !== "have-local-offer") {
                    console.warn("⚠️ Received answer in wrong state:", peerConnection?.signalingState);
                    return;
                }
                
                isProcessingRemoteDescription = true;
                await setRemoteDescriptionSafely(peerConnection, e.answer);
                remoteDescriptionSet = true;
                isProcessingRemoteDescription = false;
                
                await processPendingCandidates();
                console.log("✅ Answer processed successfully");
                
            } catch (err) {
                console.error("❌ Error handling answer:", err);
                isProcessingRemoteDescription = false;
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
                console.log("📥 Received ICE candidate:", candidate.type);
                
                if (peerConnection.remoteDescription && !isProcessingRemoteDescription) {
                    await peerConnection.addIceCandidate(candidate);
                    console.log("✅ ICE candidate added immediately");
                } else {
                    pendingCandidates.push(candidate);
                    console.log("⏳ ICE candidate queued");
                }
                
            } catch (err) {
                console.error("❌ Error processing ICE candidate:", err);
                // Don't fail the call for one bad candidate
            }
        })
        
        .listen(".call-ended", () => {
            console.log("📴 Call ended by remote peer");
            cleanupCall();
        });
}

// ============================
// 🚀 Initialize
// ============================

console.log("🚀 WebRTC call handler initialized");

// Test TURN connectivity on page load
if (window.callId) {
    testTurnServer().then(result => {
        if (result.relay) {
            console.log("✅ TURN server connectivity confirmed");
        } else if (result.host) {
            console.log("⚠️ Only host candidates found - TURN may not be working");
        } else {
            console.warn("❌ No ICE candidates found - check network connectivity");
        }
    });
}