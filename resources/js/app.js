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

// Helper function untuk memformat waktu
function formatTime(dateString) {
    const date = new Date(dateString);
    // Menggunakan toLocaleTimeString untuk format AM/PM yang lebih mudah
    return date.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
}

if (riwayatId) {
    Echo.private(`chatroom.${riwayatId}`).listen("MessageSent", (e) => {
        console.log("Pesan baru diterima:", e);

        const chatWindow = document.querySelector(".chat_wrapper");
        if (!chatWindow) return;

        const pesan = e.pesan;
        const isFromCurrentUser = pesan.nik == userNik;
        const pesanFrom = 'Anda mengatakan'.concat(pesan.teks);
        // 1. Buat elemen <li>
        // 2. Tentukan nama pengirim (hanya untuk pengacara)
        console.log(e.pengacara);
        const senderName =
            e.pesan.nik === e.pesan.nik_pengacara
                ? e.pesan.pengacara_name
                : e.pesan.pengguna_name;
        const senderNameHtml = !isFromCurrentUser ? `<h3>${senderName}</h3>` : '';
        const pesanDari = senderName.concat('mengatakan').concat(pesan.teks);
        const li = document.createElement("li");
        li.tabIndex = '0';
        li.className = `chat d-flex flex-row p-2 w-100 ${isFromCurrentUser ? 'justify-content-end' : 'justify-content-start'}`;
        li.ariaLabel = `${isFromCurrentUser ? pesanFrom : pesanDari }`

        // 3. Buat innerHTML agar sama persis dengan struktur Blade yang Anda berikan
        li.innerHTML = `
            <div class="chat_details d-flex flex-column">
                ${senderNameHtml}
                <div class="chat_text_time d-flex flex-row">
                    <p class="chat-message">
                        ${pesan.teks}
                    </p>
                    <div class="chat_time">
                        <time datetime="${pesan.created_at}">
                            ${formatTime(pesan.created_at)}
                        </time>
                    </div>
                </div>
            </div>
        `;

        // 4. Tambahkan bubble chat baru dan scroll ke bawah
        chatWindow.appendChild(li);
        chatWindow.scrollTop = chatWindow.scrollHeight;
        li.focus();
    });
}