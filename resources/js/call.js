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
// 🧪 TURN Server Diagnostic
// ============================
async function testTurnServer() {
  console.log("🧪 Testing TURN server connectivity...");
  
  const testConfig = {
    iceServers: [
      {
        urls: "turn:34.101.170.104:3478?transport=udp",
        username: "halaw",
        credential: "halawAhKnR123",
      }
    ],
    iceTransportPolicy: "relay"
  };
  
  const testPC = new RTCPeerConnection(testConfig);
  
  return new Promise((resolve) => {
    let relayFound = false;
    let testTimeout;
    
    testPC.onicecandidate = (event) => {
      if (event.candidate) {
        console.log("🧪 Test candidate:", {
          type: event.candidate.type,
          protocol: event.candidate.protocol,
          address: event.candidate.address,
          port: event.candidate.port
        });
        
        if (event.candidate.type === 'relay') {
          relayFound = true;
          console.log("✅ TURN server is working - relay candidate found!");
        }
      } else {
        console.log("🧪 Test ICE gathering completed");
        clearTimeout(testTimeout);
        testPC.close();
        resolve(relayFound);
      }
    };
    
    testPC.onicegatheringstatechange = () => {
      console.log("🧪 Test ICE gathering state:", testPC.iceGatheringState);
    };
    
    // Create a dummy offer to trigger ICE gathering
    testPC.createOffer({offerToReceiveAudio: true})
      .then(offer => testPC.setLocalDescription(offer))
      .catch(err => {
        console.error("🧪 Test offer failed:", err);
        testPC.close();
        resolve(false);
      });
    
    // Timeout after 10 seconds
    testTimeout = setTimeout(() => {
      console.warn("🧪 TURN test timed out");
      testPC.close();
      resolve(relayFound);
    }, 10000);
  });
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

function cleanAudioOnlySDP(sdp) {
  console.log("🗑️ Audio-only call - cleaning SDP");
  return sdp.replace(/^a=ssrc:[^\r\n]*\r?\n?/gm, "");
}

// ============================
// 🔒 Safe Remote Description Setter
// ============================
async function setRemoteDescriptionSafely(peerConnection, sessionDescription) {
  try {
    console.log("🔍 Setting remote description, type:", sessionDescription.type);

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
  if (!peerConnection || !peerConnection.remoteDescription || pendingCandidates.length === 0) return;

  console.log(`🔄 Processing ${pendingCandidates.length} pending ICE candidates`);
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

// ============================
// 📡 Enhanced PeerConnection Setup with Multiple TURN Strategies
// ============================
async function ensurePeerConnection() {
  if (!peerConnection) {
    const userAgent = navigator.userAgent;
    const isChrome = /Chrome/.test(userAgent);
    const isMobile = /Mobile|Android/.test(userAgent);
    const isChromeOnMobile = isChrome && isMobile;
    
    console.log("🔍 Browser detection:", {
      userAgent: userAgent,
      isChrome: isChrome,
      isMobile: isMobile,
      isChromeOnMobile: isChromeOnMobile
    });

    // Test TURN server first
    const turnWorking = await testTurnServer();
    console.log("🧪 TURN server test result:", turnWorking);

    // Multiple TURN server configurations to try
    const turnConfigs = [
      // Config 1: Your current setup
      {
        urls: "turn:34.101.170.104:3478?transport=udp",
        username: "halaw",
        credential: "halawAhKnR123",
      },
      // Config 2: Try with explicit credential type
      {
        urls: "turn:34.101.170.104:3478?transport=udp",
        username: "halaw",
        credential: "halawAhKnR123",
        credentialType: "password"
      },
      // Config 3: TURNS for secure connection
      {
        urls: "turns:34.101.170.104:5349?transport=tcp",
        username: "halaw",
        credential: "halawAhKnR123",
      }
    ];

    const pcConfig = {
      iceTransportPolicy: turnWorking ? "all" : "all", // Start with all, we'll force relay later if needed
      iceCandidatePoolSize: 0, // Disable pre-gathering for better debugging
      bundlePolicy: "max-bundle",
      rtcpMuxPolicy: "require",
      iceServers: [
        { urls: "stun:stun.l.google.com:19302" },
        { urls: "stun:stun1.l.google.com:19302" },
        ...turnConfigs // Try all TURN configurations
      ],
    };

    console.log("🔧 PeerConnection config:", pcConfig);
    peerConnection = new RTCPeerConnection(pcConfig);

    // Enhanced ICE candidate logging
    peerConnection.onicecandidate = async (event) => {
      if (!peerConnection || !callActive) return;
      if (event.candidate) {
        const candidate = event.candidate;
        console.log("📤 Generated ICE candidate:", {
          type: candidate.type,
          protocol: candidate.protocol,
          address: candidate.address,
          port: candidate.port,
          relatedAddress: candidate.relatedAddress,
          relatedPort: candidate.relatedPort,
          foundation: candidate.foundation,
          priority: candidate.priority,
          component: candidate.component,
          tcpType: candidate.tcpType
        });
        
        if (candidate.type === 'relay') {
          console.log("🎯 RELAY CANDIDATE FOUND! TURN server is working!");
        }
        
        try {
          await axios.post("/call/ice", { call_id: window.callId, candidate: event.candidate });
        } catch (err) {
          console.error("Error sending ICE:", err);
        }
      } else {
        console.log("🔚 ICE gathering completed");
        
        // Final statistics
        setTimeout(() => {
          peerConnection.getStats().then(stats => {
            let hostCount = 0, srflxCount = 0, relayCount = 0;
            stats.forEach(report => {
              if (report.type === 'local-candidate') {
                if (report.candidateType === 'host') hostCount++;
                else if (report.candidateType === 'srflx') srflxCount++;
                else if (report.candidateType === 'relay') relayCount++;
              }
            });
            console.log(`📊 FINAL CANDIDATE STATS: ${hostCount} host, ${srflxCount} srflx, ${relayCount} relay`);
            
            if (relayCount === 0) {
              console.error("🚨 NO RELAY CANDIDATES! TURN server authentication or connectivity issue!");
            }
          });
        }, 1000);
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

    // Enhanced connection state monitoring
    peerConnection.oniceconnectionstatechange = () => {
      const state = peerConnection.iceConnectionState;
      console.log("🌐 ICE connection state:", state);
      
      if (state === "checking") {
        console.log("🔍 ICE is checking connections...");
        // Log active candidate pairs
        setTimeout(() => {
          peerConnection.getStats().then(stats => {
            stats.forEach(report => {
              if (report.type === 'candidate-pair') {
                console.log("🔗 Candidate pair:", {
                  state: report.state,
                  localType: report.localCandidateId,
                  remoteType: report.remoteCandidateId,
                  nominated: report.nominated,
                  priority: report.priority
                });
              }
            });
          });
        }, 2000);
      }
      
      if (state === "disconnected") {
        console.warn("⚠️ ICE disconnected - this often indicates TURN server issues");
        
        // Log detailed connection info
        peerConnection.getStats().then(stats => {
          stats.forEach(report => {
            if (report.type === 'candidate-pair' && report.state === 'failed') {
              console.error("❌ Failed candidate pair details:", report);
            }
          });
        });
      }
      
      if (state === "failed") {
        console.error("❌ ICE connection failed - likely TURN server authentication issue");
      }
    };

    peerConnection.onsignalingstatechange = () => {
      console.log("📡 Signaling state:", peerConnection.signalingState);
    };

    peerConnection.onicegatheringstatechange = () => {
      console.log("🧊 ICE gathering state:", peerConnection.iceGatheringState);
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
    await new Promise(resolve => {
      let gathered = 0;
      const originalHandler = peerConnection.onicecandidate;
      
      peerConnection.onicecandidate = (event) => {
        if (originalHandler) originalHandler(event);
        
        if (event.candidate) {
          gathered++;
          if (gathered >= 3) { // Wait for at least 3 candidates
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
              video: false
            };
            localStream = await navigator.mediaDevices.getUserMedia(constraints);
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

        await axios.post("/call/answer", { call_id: window.callId, answer });
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
      if (!e.candidate || !e.candidate.candidate || e.candidate.candidate.trim() === "") return;
      
      try {
        const candidate = new RTCIceCandidate(e.candidate);
        console.log("📥 Received remote ICE candidate:", {
          type: candidate.type,
          protocol: candidate.protocol,
          address: candidate.address,
          port: candidate.port
        });
        
        const canAddImmediately = peerConnection.remoteDescription && 
                                  peerConnection.remoteDescription.sdp && 
                                  !isProcessingRemoteDescription;
        
        if (canAddImmediately) {
          try {
            await peerConnection.addIceCandidate(candidate);
            console.log("✅ Remote ICE candidate added immediately");
            return;
          } catch (err) {
            console.warn("⚠️ Failed to add remote candidate immediately:", err.message);
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