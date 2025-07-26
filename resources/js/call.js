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
                    "turn:34.101.170.104:3478?transport=tcp"
                ],
                username: "halaw",
                credential: "halawAhKnR123"
            }
        ],
        iceTransportPolicy: "all",
        bundlePolicy: "max-bundle",
        rtcpMuxPolicy: "require",
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
        
        testPC.createOffer({ offerToReceiveAudio: true })
            .then(offer => testPC.setLocalDescription(offer))
            .catch(err => {
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
// 🛠 Platform Detection & Enhanced SDP Processing 
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

// ============================
// 🛠 Platform Detection & Enhanced SDP Processing 
// ============================

// ... (keep your other functions like detectPlatform) ...

// CORRECTED - Replace your old fixSSRCGroupLines function with this
function fixSSRCGroupLines(sdp) {
    console.log("🔧 Fixing SSRC group consistency...");
    
    const lines = sdp.split(/\r\n|\n/);
    const ssrcIds = new Set();
    const ssrcLines = [];
    const filteredLines = [];
    let hasVideoMedia = false;
    
    // First pass: collect all valid SSRC IDs and detect video
    for (let line of lines) {
        if (line.startsWith("m=video")) {
            hasVideoMedia = true;
        }
        
        if (line.startsWith("a=ssrc:")) {
            // This logic is now handled by fixSSRCAttributes, so we just collect IDs here.
            const ssrcMatch = line.match(/^a=ssrc:(\d+)/);
            if (ssrcMatch) {
                ssrcIds.add(ssrcMatch[1]);
                ssrcLines.push({ id: ssrcMatch[1], line: line });
            }
        }
        filteredLines.push(line);
    }
    
    console.log(`🎥 Video media detected: ${hasVideoMedia}, SSRC count: ${ssrcIds.size}`);
    
    // Second pass: validate and fix ssrc-group lines
    const finalLines = [];
    
    for (let line of filteredLines) {
        if (line.startsWith('a=ssrc-group:')) {
            const groupMatch = line.match(/^a=ssrc-group:(\w+)\s+(.+)$/);
            if (groupMatch) {
                const groupType = groupMatch[1];
                const referencedIds = groupMatch[2].trim().split(/\s+/);
                
                // Check if all referenced SSRCs actually exist
                const validIds = referencedIds.filter(id => {
                    const exists = ssrcIds.has(id);
                    if (!exists) {
                        console.warn(`🗑️ SSRC ${id} referenced in group but not found in SDP`);
                    }
                    return exists;
                });
                
                if (hasVideoMedia) {
                     // For FID groups (used for video), require exactly 2 SSRCs
                    if (groupType === 'FID') {
                        if (validIds.length === 2) {
                            finalLines.push(`a=ssrc-group:${groupType} ${validIds.join(' ')}`);
                            console.log(`✅ Valid FID group: ${validIds.join(' ')}`);
                        } else {
                            console.warn(`🗑️ Removing malformed/incomplete FID group (${validIds.length} of ${referencedIds.length} valid SSRCs): ${line}`);
                        }
                    } else if (validIds.length > 0) { // For other groups (SIM, etc.)
                        finalLines.push(`a=ssrc-group:${groupType} ${validIds.join(' ')}`);
                        console.log(`✅ Valid ${groupType} group: ${validIds.join(' ')}`);
                    } else {
                        console.warn(`🗑️ Removing group with no valid SSRCs:`, line);
                    }
                } else {
                    // For audio-only calls, be more permissive
                    if (validIds.length > 0) {
                        finalLines.push(`a=ssrc-group:${groupType} ${validIds.join(' ')}`);
                    } else {
                        console.warn("🗑️ Removing group with no valid SSRCs:", line);
                    }
                }
            } else {
                console.warn("🗑️ Removing malformed ssrc-group line:", line);
            }
        } else {
            finalLines.push(line);
        }
    }
    
    const result = finalLines.join("\r\n");
    console.log(`🔧 SSRC processing complete. Original lines: ${lines.length}, Final lines: ${finalLines.length}`);
    
    return result;
}


// FIXED - Replace your fixSSRCAttributes function with this corrected version
function fixSSRCAttributes(sdp) {
    console.log("🔧 Fixing SSRC attribute formatting for compatibility...");

    const lines = sdp.split(/\r\n|\n/);
    const ssrcAttributes = new Map(); // Store attributes per SSRC
    const otherLines = []; // Store non-SSRC lines

    // First pass: Group all SSRC attributes by SSRC ID
    for (const line of lines) {
        if (line.startsWith("a=ssrc:")) {
            const ssrcMatch = line.match(/^a=ssrc:(\d+)\s+(.+)$/);
            if (ssrcMatch) {
                const ssrcId = ssrcMatch[1];
                const attribute = ssrcMatch[2];
                if (!ssrcAttributes.has(ssrcId)) {
                    ssrcAttributes.set(ssrcId, []);
                }
                ssrcAttributes.get(ssrcId).push(attribute);
            }
        } else {
            otherLines.push(line);
        }
    }

    const fixedSdpLines = [...otherLines];

    // Second pass: Process each SSRC group and rewrite the attributes
    for (const [ssrcId, attributes] of ssrcAttributes.entries()) {
        let msidAttribute = null;
        const validAttributes = [];

        for (const attr of attributes) {
            if (attr.startsWith("msid:")) {
                // Parse the msid attribute
                const msidMatch = attr.match(/^msid:([^\s]+)(?:\s+([^\s]+))?$/);
                if (msidMatch) {
                    const streamId = msidMatch[1];
                    const trackId = msidMatch[2];
                    
                    if (streamId && trackId) {
                        // Store for later processing
                        msidAttribute = { streamId, trackId };
                        console.log(`🔧 Found msid for SSRC ${ssrcId}: ${streamId} ${trackId}`);
                    } else {
                        // Invalid msid format, keep original
                        console.warn(`⚠️ Invalid msid format for SSRC ${ssrcId}: ${attr}`);
                        validAttributes.push(attr);
                    }
                } else {
                    // Malformed msid, keep original
                    console.warn(`⚠️ Malformed msid for SSRC ${ssrcId}: ${attr}`);
                    validAttributes.push(attr);
                }
            } else {
                // Keep all other attributes as-is
                validAttributes.push(attr);
            }
        }

        // Write back all non-msid attributes first
        for (const attr of validAttributes) {
            fixedSdpLines.push(`a=ssrc:${ssrcId} ${attr}`);
        }

        // Handle msid conversion if we found a valid one
        if (msidAttribute) {
            const { streamId, trackId } = msidAttribute;
            
            // Check if we already have mslabel/label attributes
            const hasMslabel = validAttributes.some(attr => attr.startsWith("mslabel:"));
            const hasLabel = validAttributes.some(attr => attr.startsWith("label:"));
            
            if (!hasMslabel && !hasLabel) {
                // Only add if we don't already have them
                fixedSdpLines.push(`a=ssrc:${ssrcId} mslabel:${streamId}`);
                fixedSdpLines.push(`a=ssrc:${ssrcId} label:${trackId}`);
                console.log(`✅ Converted msid to mslabel/label for SSRC ${ssrcId}`);
            } else {
                // Keep the original msid if we already have mslabel/label
                fixedSdpLines.push(`a=ssrc:${ssrcId} msid:${streamId} ${trackId}`);
                console.log(`✅ Kept original msid for SSRC ${ssrcId} (has existing mslabel/label)`);
            }
        }
    }
    
    const result = fixedSdpLines.join("\r\n");
    console.log("🔧 SSRC attribute fixing complete");
    return result;
}

// ADDITIONAL FIX - Enhanced SDP validation function
function validateSDPSyntax(sdp) {
    console.log("🔍 Validating SDP syntax...");
    
    const lines = sdp.split(/\r\n|\n/);
    const issues = [];
    
    for (let i = 0; i < lines.length; i++) {
        const line = lines[i];
        
        // Check for malformed SSRC lines
        if (line.startsWith("a=ssrc:")) {
            // Valid SSRC line format: a=ssrc:<id> <attribute>:<value>
            const ssrcMatch = line.match(/^a=ssrc:(\d+)\s+(.+)$/);
            if (!ssrcMatch) {
                issues.push(`Line ${i + 1}: Malformed SSRC line: ${line}`);
                continue;
            }
            
            const attribute = ssrcMatch[2];
            
            // Check specific attribute formats
            if (attribute.startsWith("msid:")) {
                // msid should have format: msid:<stream-id> <track-id>
                if (!/^msid:[^\s]+\s+[^\s]+$/.test(attribute)) {
                    issues.push(`Line ${i + 1}: Invalid msid format: ${attribute}`);
                }
            } else if (attribute.startsWith("label:") || attribute.startsWith("mslabel:")) {
                // label and mslabel should have format: label:<value>
                if (!/^(label|mslabel):[^\s]+$/.test(attribute)) {
                    issues.push(`Line ${i + 1}: Invalid label/mslabel format: ${attribute}`);
                }
            }
        }
        
        // Check for other common SDP issues
        if (line.includes("{") || line.includes("}")) {
            issues.push(`Line ${i + 1}: Invalid characters in SDP: ${line}`);
        }
    }
    
    if (issues.length > 0) {
        console.warn("⚠️ SDP validation issues found:");
        issues.forEach(issue => console.warn(`  ${issue}`));
        return false;
    }
    
    console.log("✅ SDP syntax validation passed");
    return true;
}


function validateSSRCIntegrity(sdp) {
    console.log("🔍 Validating SSRC integrity...");
    
    const lines = sdp.split(/\r\n|\n/);
    const ssrcMap = new Map();
    const groupReferences = [];
    
    // Build SSRC map and collect group references
    for (let line of lines) {
        if (line.startsWith("a=ssrc:")) {
            const match = line.match(/^a=ssrc:(\d+)\s+(.+)$/);
            if (match) {
                const ssrcId = match[1];
                const attribute = match[2];
                
                if (!ssrcMap.has(ssrcId)) {
                    ssrcMap.set(ssrcId, []);
                }
                ssrcMap.get(ssrcId).push(attribute);
            }
        } else if (line.startsWith("a=ssrc-group:")) {
            const groupMatch = line.match(/^a=ssrc-group:(\w+)\s+(.+)$/);
            if (groupMatch) {
                const groupType = groupMatch[1];
                const ssrcIds = groupMatch[2].trim().split(/\s+/);
                groupReferences.push({ type: groupType, ssrcs: ssrcIds, line });
            }
        }
    }
    
    // Validate each group reference
    let isValid = true;
    for (let group of groupReferences) {
        for (let ssrcId of group.ssrcs) {
            if (!ssrcMap.has(ssrcId)) {
                console.error(`❌ SSRC group ${group.type} references non-existent SSRC: ${ssrcId}`);
                isValid = false;
            }
        }
    }
    
    console.log(`🔍 SSRC integrity check: ${isValid ? 'PASSED' : 'FAILED'}`);
    return isValid;
}

function fixTelephoneEvent(sdp) {
    console.log("🔧 Fixing telephone-event format...");
    
    // Fix malformed rtpmap lines for telephone-event
    let fixedSdp = sdp.replace(
        /^a=rtpmap:(\d+)\s+telephone-event\/8000$/gm,
        "a=rtpmap:$1 telephone-event/8000/1"
    );
    
    // Remove any duplicate telephone-event lines
    const lines = fixedSdp.split(/\r\n|\n/);
    const seenTelephoneEventRtpmap = new Set();
    
    const filteredLines = lines.filter((line) => {
        if (line.match(/^a=rtpmap:\d+\s+telephone-event/)) {
            const match = line.match(/^a=rtpmap:(\d+)/);
            if (match) {
                const payloadType = match[1];
                if (seenTelephoneEventRtpmap.has(payloadType)) {
                    console.warn("⚠️ Removing duplicate telephone-event rtpmap:", line);
                    return false;
                }
                seenTelephoneEventRtpmap.add(payloadType);
                
                // Ensure proper format
                if (!line.includes("/8000/1") && line.includes("telephone-event/8000")) {
                    console.warn("⚠️ Removing malformed telephone-event format:", line);
                    return false;
                }
            }
        }
        return true;
    });
    
    return filteredLines.join("\r\n");
}

function cleanAudioOnlySDP(sdp) {
    console.log("🗑️ Audio-only call - aggressive SDP cleaning");
    
    // For audio-only calls, remove all video-related SSRC and group lines
    let cleanedSdp = sdp.replace(/^a=ssrc:[^\r\n]*\r?\n?/gm, "");
    cleanedSdp = cleanedSdp.replace(/^a=ssrc-group:[^\r\n]*\r?\n?/gm, "");
    cleanedSdp = cleanedSdp.replace(/^a=rtx-time:[^\r\n]*\r?\n?/gm, "");
    
    console.log("🗑️ Removed all SSRC-related lines for audio-only");
    return cleanedSdp;
}

// Mobile SDP processing - minimal changes
function cleanSDPMobile(sdp, isVideoCall = false) {
    console.log("📱 Mobile: Minimal SDP processing, video:", isVideoCall);
    
    // For mobile, just fix critical issues and clean line breaks
    let cleanedSdp = fixSSRCGroupLines(sdp);
    cleanedSdp = cleanedSdp.replace(/(\r\n){3,}/g, "\r\n\r\n");
    
    console.log("📱 Mobile SDP processed, length:", cleanedSdp.length);
    return cleanedSdp;
}

// Update your cleanSDPDesktop function to use the validation
function cleanSDPDesktop(sdp, isVideoCall = false) {
    console.log("🖥️ Desktop: Full SDP cleaning, video:", isVideoCall);
   
    let cleanedSdp = sdp;
   
    // if (!isVideoCall) {
        // For audio-only, do aggressive cleaning (keep your existing logic)
    cleanedSdp = cleanAudioOnlySDP(cleanedSdp);
    // } else {
    //     // For video calls, fix SSRC issues carefully with validation
    //     console.log("🎥 Processing video call SDP...");
        
    //     // Step 1: Fix SSRC attribute formatting (msid, cname, etc.)
    //     cleanedSdp = fixSSRCAttributes(cleanedSdp);
        
    //     // Step 2: Fix SSRC group references
    //     cleanedSdp = fixSSRCGroupLines(cleanedSdp);
        
    //     // Step 3: Validate the result
    //     if (!validateSSRCIntegrity(cleanedSdp)) {
    //         console.warn("⚠️ SSRC integrity check failed, applying fallback cleaning...");
            
    //         // Fallback 1: Try removing just the problematic SSRC groups
    //         cleanedSdp = cleanedSdp.replace(/^a=ssrc-group:[^\r\n]*\r?\n?/gm, "");
    //         console.log("🔄 Removed all SSRC groups as fallback");
            
    //         // Fallback 2: If still problematic, remove problematic SSRC attributes
    //         const lines = cleanedSdp.split(/\r\n|\n/);
    //         const safeSdp = lines.filter(line => {
    //             if (line.startsWith("a=ssrc:")) {
    //                 // Remove any SSRC line that might cause parsing issues
    //                 if (line.includes("msid")) {
    //                     // Only keep lines that match the exact Chrome-expected format
    //                     const isValidMsid = /^a=ssrc:\d+\s+msid\s+[0-9a-f-]+\s+[0-9a-f-]+(\s.*)?$/.test(line);
    //                     if (!isValidMsid) {
    //                         console.warn("🗑️ Removing problematic msid line:", line);
    //                         return false;
    //                     }
    //                 }
    //                 // Keep other SSRC attributes (cname, etc.)
    //                 return true;
    //             }
    //             return true;
    //         }).join("\r\n");
            
    //         cleanedSdp = safeSdp;
    //         console.log("🔄 Applied aggressive SSRC attribute cleaning");
    //     }
    // }
   
    // Always fix telephone-event issues (keep your existing logic)
    cleanedSdp = fixTelephoneEvent(cleanedSdp);
   
    // Clean up excessive line breaks
    cleanedSdp = cleanedSdp.replace(/(\r\n){3,}/g, "\r\n\r\n");
   
    console.log("🖥️ Desktop SDP cleaned, length:", cleanedSdp.length);
    return cleanedSdp;
}

// Main SDP cleaning function - routes to platform-specific handler
function cleanSDP(sdp, isVideoCall = false) {
    if (!sdp || typeof sdp !== "string") {
        console.error("❌ Invalid SDP provided");
        return sdp;
    }
    
    const platform = detectPlatform();
    console.log(`🔧 Platform detected: ${platform.platform} ${platform.browser}`);
    
    try {
        if (platform.isMobile) {
            return cleanSDPMobile(sdp, isVideoCall);
        } else {
            return cleanSDPDesktop(sdp, isVideoCall);
        }
    } catch (error) {
        console.error("❌ Error cleaning SDP:", error);
        console.log("🔄 Falling back to original SDP");
        return sdp; // Return original if cleaning fails
    }
}

// ============================
// 🔒 Safe Remote Description Setter
// ============================

// UPDATED - Enhanced setRemoteDescriptionSafely with better error handling
async function setRemoteDescriptionSafely(peerConnection, sessionDescription) {
    if (!peerConnection || !sessionDescription) {
        throw new Error("Invalid peerConnection or sessionDescription");
    }
    
    try {
        console.log("🔍 Setting remote description, type:", sessionDescription.type);
        
        const isVideoCall = /m=video/.test(sessionDescription.sdp);
        console.log("📹 Video detected in SDP:", isVideoCall);
        
        // First attempt with full cleaning
        let cleanedSdp = cleanSDP(sessionDescription.sdp, isVideoCall);
        
        // Validate the cleaned SDP
        if (!cleanedSdp || cleanedSdp.length < 100) {
            throw new Error("SDP cleaning resulted in invalid content");
        }
        
        // Validate SDP syntax
        if (!validateSDPSyntax(cleanedSdp)) {
            console.warn("⚠️ SDP validation failed, attempting minimal cleaning...");
            
            // Try with minimal cleaning
            cleanedSdp = sessionDescription.sdp
                .replace(/\{|\}/g, "") // Remove invalid characters
                .replace(/(\r\n){3,}/g, "\r\n\r\n"); // Clean up line breaks
        }
        
        const cleanedSessionDesc = new RTCSessionDescription({
            type: sessionDescription.type,
            sdp: cleanedSdp
        });
        
        await peerConnection.setRemoteDescription(cleanedSessionDesc);
        console.log("✅ Remote description set successfully");
        return true;
        
    } catch (error) {
        console.error("❌ Error setting remote description:", error);
        
        // Enhanced error handling for specific SDP parsing errors
        if (error.message.includes("Failed to parse SessionDescription")) {
            console.log("🔄 SDP parsing failed, trying aggressive cleanup...");
            
            try {
                // Remove all problematic SSRC attributes and try again
                let safeSdp = sessionDescription.sdp
                    .replace(/^a=ssrc:[^\r\n]*msid:[^\r\n]*\r?\n?/gm, "") // Remove msid lines
                    .replace(/^a=ssrc:[^\r\n]*label:[^\r\n]*\r?\n?/gm, "") // Remove label lines  
                    .replace(/^a=ssrc:[^\r\n]*mslabel:[^\r\n]*\r?\n?/gm, "") // Remove mslabel lines
                    .replace(/^a=ssrc-group:[^\r\n]*\r?\n?/gm, "") // Remove SSRC groups
                    .replace(/\{|\}/g, "") // Remove invalid characters
                    .replace(/(\r\n){3,}/g, "\r\n\r\n"); // Clean up line breaks
                
                const safeSdpDescription = new RTCSessionDescription({
                    type: sessionDescription.type,
                    sdp: safeSdp
                });
                
                await peerConnection.setRemoteDescription(safeSdpDescription);
                console.log("✅ Remote description set with aggressive cleanup");
                return true;
                
            } catch (retryError) {
                console.error("❌ Aggressive cleanup also failed:", retryError);
                
                // Final fallback - try with original SDP
                try {
                    await peerConnection.setRemoteDescription(sessionDescription);
                    console.log("✅ Original SDP worked as fallback");
                    return true;
                } catch (originalError) {
                    console.error("❌ Even original SDP failed:", originalError);
                    throw originalError;
                }
            }
        }
        
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
                    address: event.candidate.address?.substring(0, 10) + "...",
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
            console.log("🎧 Remote track received:", event.track.kind);
            
            if (event.streams && event.streams[0]) {
                const remoteStream = event.streams[0];
                
                if (event.track.kind === 'audio') {
                    if (remoteAudio) {
                        remoteAudio.srcObject = remoteStream;
                        remoteAudio.autoplay = true;
                        remoteAudio.muted = false;
                        console.log("✅ Remote audio connected");
                    }
                } else if (event.track.kind === 'video') {
                    if (remoteVideo) {
                        remoteVideo.srcObject = remoteStream;
                        remoteVideo.autoplay = true;
                        remoteVideo.muted = true;
                        remoteVideo.playsInline = true;
                        console.log("✅ Remote video connected");
                    }
                }
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
                    connectionAttempts = 0;
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
        
        // Add connection state change handler
        peerConnection.onconnectionstatechange = () => {
            console.log("🔗 Connection state:", peerConnection.connectionState);
        };
    }
}

// ============================
// 📹 Enhanced Media Access with Fallbacks
// ============================

async function getUserMediaWithFallback(constraints, isAnswer = false) {
    console.log("🎥 Requesting media access:", constraints);
    
    try {
        const stream = await navigator.mediaDevices.getUserMedia(constraints);
        console.log("✅ Media access granted with full constraints");
        return stream;
        
    } catch (error) {
        console.warn("⚠️ Media access failed with full constraints:", error.name, error.message);
        
        if (constraints.video && error.name === "NotReadableError") {
            console.log("🔄 Camera busy/unavailable, trying different video constraints...");
            
            const fallbackConstraints = {
                ...constraints,
                video: {
                    width: { ideal: 640, max: 1280 },
                    height: { ideal: 480, max: 720 },
                    frameRate: { ideal: 15, max: 30 }
                }
            };
            
            try {
                const stream = await navigator.mediaDevices.getUserMedia(fallbackConstraints);
                console.log("✅ Media access granted with fallback video constraints");
                return stream;
            } catch (fallbackError) {
                console.warn("⚠️ Fallback video constraints failed:", fallbackError.name);
                
                if (isAnswer) {
                    console.log("🔄 Video failed for answerer, falling back to audio-only");
                    try {
                        const audioStream = await navigator.mediaDevices.getUserMedia({
                            audio: constraints.audio,
                            video: false
                        });
                        console.log("✅ Audio-only fallback successful for answerer");
                        return audioStream;
                    } catch (audioError) {
                        console.error("❌ Audio fallback also failed:", audioError);
                        throw audioError;
                    }
                } else {
                    const useAudioOnly = confirm(
                        "Camera is not available (may be in use by another app). " +
                        "Would you like to make an audio-only call instead?"
                    );
                    
                    if (useAudioOnly) {
                        const audioStream = await navigator.mediaDevices.getUserMedia({
                            audio: constraints.audio,
                            video: false
                        });
                        console.log("✅ User chose audio-only fallback");
                        return audioStream;
                    } else {
                        throw fallbackError;
                    }
                }
            }
        } else if (error.name === "NotAllowedError") {
            throw new Error("Camera/microphone permission denied. Please allow access and try again.");
        } else if (error.name === "NotFoundError") {
            if (constraints.video) {
                throw new Error("No camera found. Please connect a camera or use audio-only mode.");
            } else {
                throw new Error("No microphone found. Please connect a microphone.");
            }
        } else {
            throw error;
        }
    }
}

// ============================
// 🔍 Media Device Detection
// ============================

async function checkMediaDevices() {
    try {
        const devices = await navigator.mediaDevices.enumerateDevices();
        const hasCamera = devices.some(device => device.kind === 'videoinput');
        const hasMicrophone = devices.some(device => device.kind === 'audioinput');
        
        console.log("🎥 Available devices:", { hasCamera, hasMicrophone });
        return { hasCamera, hasMicrophone };
    } catch (error) {
        console.warn("⚠️ Could not enumerate devices:", error);
        return { hasCamera: true, hasMicrophone: true };
    }
}

// ============================
// 📞 Enhanced Call Start
// ============================

async function startCall(video = false) {
    try {
        console.log("📞 Starting call, video:", video);
        
        if (video) {
            const devices = await checkMediaDevices();
            if (!devices.hasCamera) {
                const useAudioOnly = confirm(
                    "No camera detected. Would you like to make an audio-only call instead?"
                );
                if (useAudioOnly) {
                    video = false;
                } else {
                    throw new Error("Video call cancelled - no camera available");
                }
            }
        }
        
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
                sampleRate: 48000,
                channelCount: 1
            },
            video: video ? {
                width: { ideal: 1280, max: 1920 },
                height: { ideal: 720, max: 1080 },
                frameRate: { ideal: 30, max: 60 },
                facingMode: "user"
            } : false
        };
        
        localStream = await getUserMediaWithFallback(constraints, false);
        
        const hasVideoTrack = localStream.getVideoTracks().length > 0;
        const actuallyVideo = video && hasVideoTrack;
        
        console.log(`🎥 Media obtained - requested video: ${video}, got video: ${hasVideoTrack}`);
        
        if (actuallyVideo && localVideo) {
            localVideo.srcObject = localStream;
            localVideo.autoplay = true;
            localVideo.muted = true;
            localVideo.playsInline = true;
            console.log("✅ Local video displayed");
        }
        
        localStream.getTracks().forEach(track => {
            console.log("🎵 Adding local track:", track.kind);
            peerConnection.addTrack(track, localStream);
        });
        
        const offerOptions = {
            offerToReceiveAudio: true,
            offerToReceiveVideo: actuallyVideo,
            voiceActivityDetection: true
        };
        
        const offer = await peerConnection.createOffer(offerOptions);
        await peerConnection.setLocalDescription(offer);
        
        console.log("⏳ Gathering ICE candidates...");
        await waitForIceCandidates(5000);
        
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
        
        if (err.message.includes("permission denied")) {
            alert("Camera/microphone access denied. Please allow permissions and try again.");
        } else if (err.message.includes("no camera")) {
            alert("No camera found. Please connect a camera for video calls.");
        } else if (err.message.includes("Camera is not available")) {
            alert("Camera is busy or unavailable. Please close other apps using the camera and try again.");
        } else {
            alert(`Failed to start call: ${err.message}`);
        }
        
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
        localStream.getTracks().forEach(track => {
            track.stop();
            console.log("🛑 Stopped track:", track.kind);
        });
        localStream = null;
    }
    
    if (localVideo) localVideo.srcObject = null;
    if (remoteVideo) remoteVideo.srcObject = null;
    if (remoteAudio) remoteAudio.srcObject = null;
    
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

const startVideoCallLink = document.getElementById("startVideoCallLink");
if (startVideoCallLink) {
    startVideoCallLink.addEventListener("click", async (e) => {
        e.preventDefault();
        try {
            await startCall(true);
        } catch (err) {
            console.error("Failed to start video call:", err);
            alert("Failed to start video call. Please check your camera/microphone permissions and try again.");
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
                
                if (!localStream) {
                    const hasVideo = /m=video/.test(e.offer.sdp);
                    console.log("📥 Offer has video:", hasVideo);
                    
                    const constraints = {
                        audio: {
                            echoCancellation: true,
                            noiseSuppression: true,
                            autoGainControl: true,
                            sampleRate: 48000,
                            channelCount: 1
                        },
                        video: hasVideo ? {
                            width: { ideal: 1280, max: 1920 },
                            height: { ideal: 720, max: 1080 },
                            frameRate: { ideal: 30, max: 60 },
                            facingMode: "user"
                        } : false
                    };
                    
                    try {
                        localStream = await getUserMediaWithFallback(constraints, true);
                        
                        const hasVideoTrack = localStream.getVideoTracks().length > 0;
                        const actuallyVideo = hasVideo && hasVideoTrack;
                        
                        console.log(`🎥 Answerer media - requested: ${hasVideo}, got: ${hasVideoTrack}`);
                        
                        if (actuallyVideo && localVideo) {
                            localVideo.srcObject = localStream;
                            localVideo.autoplay = true;
                            localVideo.muted = true;
                            localVideo.playsInline = true;
                            console.log("✅ Local video displayed (answerer)");
                        }
                        
                        localStream.getTracks().forEach(track => {
                            console.log("🎵 Adding answerer track:", track.kind);
                            peerConnection.addTrack(track, localStream);
                        });
                        
                    } catch (mediaError) {
                        console.error("❌ Failed to get user media for answering:", mediaError);
                        
                        if (hasVideo) {
                            console.log("🔄 Video failed, attempting audio-only answer...");
                            try {
                                const audioOnlyConstraints = {
                                    audio: constraints.audio,
                                    video: false
                                };
                                localStream = await navigator.mediaDevices.getUserMedia(audioOnlyConstraints);
                                
                                localStream.getTracks().forEach(track => {
                                    console.log("🎵 Adding audio-only answerer track:", track.kind);
                                    peerConnection.addTrack(track, localStream);
                                });
                                
                                console.log("✅ Audio-only answer fallback successful");
                            } catch (audioError) {
                                console.error("❌ Audio-only fallback also failed:", audioError);
                                throw audioError;
                            }
                        } else {
                            throw mediaError;
                        }
                    }
                }
                
                await setRemoteDescriptionSafely(peerConnection, e.offer);
                remoteDescriptionSet = true;
                isProcessingRemoteDescription = false;
                
                await processPendingCandidates();
                
                const answer = await peerConnection.createAnswer({
                    offerToReceiveAudio: true,
                    offerToReceiveVideo: /m=video/.test(e.offer.sdp) && localStream.getVideoTracks().length > 0
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

