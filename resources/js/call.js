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
// 🛠 SDP Helpers
// ============================

// 🚑 Fix malformed SSRC lines (Firefox bug)
function sanitizeSSRC(sdp) {
  if (!sdp || typeof sdp !== "string") return sdp;

  let lines = sdp.split(/\r\n|\n/);
  let fixed = lines.map((line) => {
    if (line.startsWith("a=ssrc:")) {
      // fix cname fields with curly braces
      if (line.includes("cname:{")) {
        console.warn("⚠️ Fixing malformed SSRC cname:", line);
        return line.replace(/\{|\}/g, "");
      }
    }
    return line;
  });
  return fixed.join("\r\n");
}

// 🎨 Clean SDP for audio-only calls (remove all SSRC lines)
function cleanAudioOnlySDP(sdp) {
  console.log("🗑️ Audio-only call - removing ALL SSRC lines");
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

    // Always sanitize malformed SSRC lines
    sdp = sanitizeSSRC(sdp);

    // For audio-only calls, remove all SSRC lines for compatibility
    if (!hasVideo) {
      sdp = cleanAudioOnlySDP(sdp);
    } else {
      console.log("✅ Video call - keeping SSRC lines (sanitized)");
    }

    // Collapse extra blank lines
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
  if (!peerConnection || !remoteDescriptionSet || pendingCandidates.length === 0) return;

  console.log(`🔄 Processing ${pendingCandidates.length} pending ICE candidates`);
  for (const candidate of pendingCandidates) {
    try {
      await peerConnection.addIceCandidate(candidate);
      console.log("✅ Queued ICE candidate added");
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
      iceTransportPolicy: "all",
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
        console.log("📤 Sending ICE candidate:", event.candidate);
        try {
          await axios.post("/call/ice", { call_id: window.callId, candidate: event.candidate });
        } catch (err) {
          console.error("Error sending ICE:", err);
        }
      } else {
        console.log("🔚 ICE gathering completed");
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
      console.log("🌐 ICE state:", peerConnection.iceConnectionState);
      if (peerConnection.iceConnectionState === "failed") {
        console.warn("❌ ICE connection failed");
      }
    };

    peerConnection.onsignalingstatechange = () => {
      console.log("📡 Signaling state:", peerConnection.signalingState);
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

    localStream = await navigator.mediaDevices.getUserMedia({
      audio: true,
      video: video,
    });

    localStream.getTracks().forEach((track) => peerConnection.addTrack(track, localStream));

    const offer = await peerConnection.createOffer({
      offerToReceiveAudio: true,
      offerToReceiveVideo: video,
    });

    await peerConnection.setLocalDescription(offer);

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
    // pass true for video, false for audio
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
            localStream = await navigator.mediaDevices.getUserMedia({ audio: true, video: false });
            localStream.getTracks().forEach((t) => peerConnection.addTrack(t, localStream));
          } catch (err) {
            console.error("❌ Error accessing local media:", err);
          }
        }

        await setRemoteDescriptionSafely(peerConnection, e.offer);
        remoteDescriptionSet = true;
        isProcessingRemoteDescription = false;
        console.log("✅ Offer set as remote description");

        await processPendingCandidates();

        const answer = await peerConnection.createAnswer();
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
        if (isProcessingRemoteDescription) {
          console.log("⏳ Waiting for remote description processing");
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
      }
    })
    .listen(".call-ended", () => {
      console.log("📴 Call ended by other side");
      cleanupCall();
    });
}
