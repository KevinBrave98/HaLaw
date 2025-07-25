import "./bootstrap";
import "bootstrap";
import './call';

// --- SENDING ---
document.querySelectorAll(".form_kirim_chat").forEach((form) => {
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const messageInput = form.querySelector(".input-chat");
        const riwayatId = form.dataset.riwayatId;
        const isLawyerRoute = window.location.pathname.includes("/lawyer/");
        const actionUrl = isLawyerRoute
            ? `/lawyer/chatroom/${riwayatId}/send`
            : `/chatroom/${riwayatId}/send`;

        fetch(actionUrl, {
            method: "POST",
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
            },
            body: JSON.stringify({ teks: messageInput.value }),
        })
            .then((res) => res.json())
            .then((data) => {
                console.log("Sent response:", data);
                if (data.status === "success") {
                    messageInput.value = "";
                }
            })
            .catch((err) => console.error("Send error:", err));
    });
});

// --- RECEIVING ---
const userNik = document
    .querySelector('meta[name="user-nik"]')
    ?.getAttribute("content");

const chatForm = document.querySelector('.form_kirim_chat');
const riwayatId = chatForm?.dataset.riwayatId;


if (riwayatId) {
    Echo.private(`chatroom.${riwayatId}`).listen("MessageSent", (e) => {
        console.log("New message received:", e);

        const chatWindow = document.querySelector(".chat_wrapper");
        if (!chatWindow) return;

        const pesan = e.pesan;

        // Determine alignment: if message sender is the current user (userNik), then it's on the RIGHT
        const isFromCurrentUser = pesan.nik == userNik;

        // Create wrapper div
        const div = document.createElement("div");
        div.classList.add("chat", "d-flex", "flex-row", "p-2", "w-100");

        const senderName =
            e.pesan.nik === e.pesan.nik_pengacara
                ? e.pesan.pengacara_name
                : e.pesan.pengguna_name;

        if (isFromCurrentUser) {
            // Current user sent this message -> align right
            div.classList.add("justify-content-end");
            div.innerHTML = `
                    <div class="chat_details d-flex flex-column w-25">
                        <p class="chat-message">${pesan.teks}</p>
                    </div>
                    <div class="d-flex flex-column justify-content-end chat_time">
                        <p>${pesan.created_at}</p>
                    </div>
                `;
        } else {
            // Someone else sent this message -> align left
            div.classList.add("justify-content-start");
            div.innerHTML = `
                    <div class="chat_details d-flex flex-column w-25">
                        <h3>${senderName ?? ""}</h3>
                        <p class="chat-message">${pesan.teks}</p>
                    </div>
                    <div class="d-flex flex-column justify-content-start chat_time me-5 pe-5">
                        <p>${pesan.created_at}</p>
                    </div>
                `;
        }

        chatWindow.appendChild(div);
        chatWindow.scrollTop = chatWindow.scrollHeight;
    });
}