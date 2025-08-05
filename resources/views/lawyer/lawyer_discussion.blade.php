@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/discussion.css') }}">
@endpush

<x-layout_lawyer :title="'Ruang Konsultasi'">
    <main class="d-flex flex-column konsultasi_wrapper">

        {{-- header: No changes needed here --}}
        <header class="heading d-flex flex-row align-items-center justify-content-between">
            <div class="d-flex flex-row align-items-center gap-4 first-half w-50">
                <a href="{{ route('lawyer.konsultasi.berlangsung') }}" class="mx-5" aria-label="Kembali">
                    <img src="{{ asset('assets/images/weui_arrow-filled.png') }}" alt="">
                </a>
                <div class="nama_pengguna d-flex flex-row">
                    <h2 class="h2 mb-0">{{ $riwayat->pengguna->nama_pengguna }}</h2>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-evenly second-half w-50">
                <div class="sisa_waktu d-flex flex-row">
                    {{-- PERUBAHAN: Placeholder dihapus, akan diisi oleh JavaScript --}}
                    <p class="h2 mb-0">Sisa Waktu : <span id="countdown-timer"></span></p>
                </div>

                {{-- <button type="button" id="startCallLink" aria-label="Mulai Panggilan Suara">
                    <img src="{{ asset('assets/images/material-symbols_call.png') }}" alt="">
                </button>
                <button type="button" id="startVideoCallLink" aria-label="Mulai Panggilan Video">
                    <img src="{{ asset('assets/images/weui_video-call-filled.png') }}" alt="">
                </button> --}}
            </div>
        </header>

        {{-- Call UI: No changes needed here --}}
        <div id="call-modal-overlay" class="call-modal-overlay d-none" role="dialog" aria-modal="true"
            aria-labelledby="call-heading">
            <div id="call-ui-container" class="d-none">
                <div class="call-info">
                    @if ($riwayat->pengguna->foto_pengguna)
                        <img src="{{ asset('storage/' . $riwayat->pengguna->foto_pengguna) }}" alt="foto_pengacara"
                            class="call-avatar">
                    @else
                        <img src="{{ asset('assets/images/foto-profil-default.jpg') }}" alt="foto_pengacara"
                            class="call-avatar">
                    @endif
                    <h3 id="call-info-name" class="call-name">Memanggil...</h3>
                    <p id="call-info-status" class="call-status">Berdering</p>
                    <button class="control-btn end-call mt-4" aria-label="Batalkan Panggilan">
                        <i class="bi bi-telephone-fill"></i>
                    </button>
                </div>

                <div id="incoming-call-prompt" class="d-none"> {{-- Hidden by default --}}
                    @if ($riwayat->pengguna->foto_pengguna)
                        <img src="{{ asset('storage/' . $riwayat->pengguna->foto_pengguna) }}" alt="foto pengguna"
                            class="call-avatar">
                    @else
                        <img src="{{ asset('assets/images/foto-profil-default.jpg') }}" alt="foto pengguna"
                            class="call-avatar">
                    @endif
                    <h3 id="incoming-caller-name" class="call-name"></h3>
                    <p class="call-status">Panggilan Masuk...</p>
                    <div class="incoming-call-actions mt-4">
                        <button id="rejectCallBtn" class="control-btn end-call" aria-label="Tolak Panggilan">
                            <i class="bi bi-telephone-fill"></i>
                        </button>
                        <button id="acceptCallBtn" class="control-btn accept-call" aria-label="Terima Panggilan">
                            <i class="bi bi-telephone-fill"></i>
                        </button>
                    </div>
                </div>

                <div class="video-call-view">
                    <video id="remoteVideo" autoplay playsinline></video>
                    <video id="localVideo" autoplay muted playsinline></video>
                </div>

                <div class="audio-call-view">
                    @if ($riwayat->pengguna->foto_pengguna)
                        <img src="{{ asset('storage/' . $riwayat->pengguna->foto_pengguna) }}" alt="foto pengguna"
                            class="call-avatar-large">
                    @else
                        <img src="{{ asset('assets/images/foto-profil-default.jpg') }}" alt="foto pengguna"
                            class="call-avatar-large">
                    @endif
                    {{-- <img src"{{ }}" alt="Foto Profil Lawan Bicara" class="call-avatar-large"> --}}
                    <h3 id="audio-call-name" class="call-name">{{ $riwayat->pengguna->nama_pengguna }}</h3>
                    <p id="audio-call-timer" class="call-status">00:00</p>
                </div>

                <div class="in-call-controls">
                    <button class="control-btn" id="muteBtn" aria-label="Bisukan Mikrofon">
                        <i class="bi bi-mic-fill"></i>
                    </button>
                    <button class="control-btn" id="videoBtn" aria-label="Matikan Video">
                        <i class="bi bi-camera-video-fill"></i>
                    </button>
                    <button class="control-btn end-call" id="endCallBtn" aria-label="Akhiri Panggilan">
                        <i class="bi bi-telephone-fill"></i>
                    </button>
                </div>

                <audio id="remoteAudio" autoplay playsinline hidden></audio>
            </div>
        </div>

        {{-- Chat Wrapper: No changes needed here --}}
        <ul class="d-flex flex-column chat_wrapper">
            @foreach ($pesan as $pesan_item)
                <li class="chat d-flex flex-row p-2 w-100 {{ $riwayat->pengacara->nik_pengacara == $pesan_item->nik ? 'justify-content-end' : 'justify-content-start' }}"
                    tabindex="0"
                    aria-label="{{ $riwayat->pengacara->nik_pengacara == $pesan_item->nik ? 'Anda mengatakan' . $pesan_item->teks : $riwayat->pengguna->nama_pengguna . 'mengatakan' . $pesan_item->teks }}">
                    <div class="chat_details d-flex flex-column">
                        @if ($riwayat->pengacara->nik_pengacara != $pesan_item->nik)
                            <h3>{{ $riwayat->pengguna->nama_pengguna }}
                        @endif
                        </h3>
                        <div class="chat_text_time d-flex flex-row">
                            <p class="chat-message">
                                {{ $pesan_item->teks }}
                            </p>
                            <div class="chat_time">
                                <time
                                    datetime="{{ $pesan_item->created_at->toIso8601String() }}">{{ $pesan_item->created_at->format('g:i A') }}</time>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>

        {{-- Discussion Input Form: No changes needed here --}}
        <section class="d-flex flex-row discussion-input w-100 p-4 mt-4" aria-label="Area kirim pesan">
            <form action="{{ route('consultation.lawyer.send', ['id' => $riwayat->id]) }}" method="POST"
                id="form_masuk" class="d-flex flex-row w-100 gap-4 form_kirim_chat"
                data-riwayat-id="{{ $riwayat->id }}">
                @csrf
                <label for="input-chat" class="visually-hidden">Ketik pesan Anda</label>
                <input type="text" name="teks" class="form-control input-chat" id="input-chat">

                <button type="submit" aria-label="Kirim pesan">
                    <img src="{{ asset('assets/images/mingcute_send-line.png') }}" alt="">
                </button>
            </form>
        </section>
    </main>
    {{-- ========================================================================= --}}
    {{-- PERUBAHAN UTAMA: Script timer ditambahkan di sini --}}
    {{-- ========================================================================= --}}
    @push('scripts')
        <script>
            // ... variabel global Anda yang lain
            window.callId = "{{ $riwayat->id }}";

            document.addEventListener('DOMContentLoaded', function() {
                // --- Logic untuk Auto-scroll Chat ---
                const chatWrapper = document.querySelector('.chat_wrapper');

                function scrollToBottom() {
                    if (chatWrapper) {
                        chatWrapper.scrollTop = chatWrapper.scrollHeight;
                    }
                }
                scrollToBottom();

                // --- ⏱️ Logic untuk Countdown Timer ---
                const timerElement = document.getElementById('countdown-timer');

                // Ambil waktu mulai dari variabel Blade ($riwayat->updated_at).
                // toIso8601String() memastikan formatnya kompatibel dengan JavaScript.
                const startTimeFromServer = '{{ $riwayat->updated_at->toIso8601String() }}';

                const startTime = new Date(startTimeFromServer);
                const endTime = new Date(startTime.getTime() + 60 * 60 *
                    1000); // Set akhir waktu 1 jam dari waktu mulai

                const countdownInterval = setInterval(() => {
                    const now = new Date();
                    const remainingTime = endTime - now;

                    // Jika waktu habis
                    if (remainingTime <= 0) {
                        clearInterval(countdownInterval);
                        timerElement.textContent = "00:00:00";
                        // Anda bisa menonaktifkan tombol call/chat di sini jika perlu
                        // document.getElementById('startCallLink').disabled = true;
                        // document.getElementById('startVideoCallLink').disabled = true;
                        document.getElementById('input-chat').disabled = true;
                        return;
                    }

                    // Ubah sisa waktu ke format HH:MM:SS
                    const totalSeconds = Math.floor(remainingTime / 1000);
                    const hours = Math.floor(totalSeconds / 3600);
                    const minutes = Math.floor((totalSeconds % 3600) / 60);
                    const seconds = totalSeconds % 60;

                    // Tambahkan nol di depan jika angka < 10
                    const formattedHours = String(hours).padStart(2, '0');
                    const formattedMinutes = String(minutes).padStart(2, '0');
                    const formattedSeconds = String(seconds).padStart(2, '0');

                    // Tampilkan di halaman
                    timerElement.textContent = `${formattedHours}:${formattedMinutes}:${formattedSeconds}`;
                }, 1000);
                const callModalOverlay = document.getElementById('call-modal-overlay');
                const startCallBtn = document.getElementById('startCallLink');
                const startVideoCallBtn = document.getElementById('startVideoCallLink');
                const endCallBtns = document.querySelectorAll('.end-call');
                let lastFocusedElement; // Variabel untuk menyimpan fokus terakhir

                function openCallModal() {
                    if (!callModalOverlay) return;

                    // 1. Simpan elemen yang sedang fokus saat ini (tombol call)
                    lastFocusedElement = document.activeElement;

                    // 2. Tampilkan modal
                    callModalOverlay.classList.remove('d-none');

                    // 3. Pasang event listener untuk menjebak fokus
                    callModalOverlay.addEventListener('keydown', trapFocus);

                    // 4. Fokuskan pada elemen pertama yang bisa difokus di dalam modal
                    // Trik: setTimeout memastikan browser sudah selesai menampilkan modal
                    // sebelum kita mencoba memberi fokus.
                    setTimeout(() => {
                        const firstFocusableElement = callModalOverlay.querySelector(
                            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
                        if (firstFocusableElement) {
                            firstFocusableElement.focus();
                        }
                    }, 50); // Penundaan kecil sudah cukup
                }

                function closeCallModal() {
                    if (!callModalOverlay) return;

                    // 1. Sembunyikan modal
                    callModalOverlay.classList.add('d-none');

                    // 2. Hapus event listener agar tidak berjalan saat modal tertutup
                    callModalOverlay.removeEventListener('keydown', trapFocus);

                    // 3. Kembalikan fokus ke elemen terakhir yang aktif
                    if (lastFocusedElement) {
                        lastFocusedElement.focus();
                    }
                }

                // Fungsi utama untuk menjebak Tab
                function trapFocus(e) {
                    if (e.key !== 'Tab') return;

                    const focusableElements = Array.from(callModalOverlay.querySelectorAll(
                        'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])')).filter(el => el
                        .offsetParent !== null);

                    if (focusableElements.length === 0) return;

                    const firstElement = focusableElements[0];
                    const lastElement = focusableElements[focusableElements.length - 1];

                    // Jika Shift + Tab ditekan pada elemen pertama, pindah ke elemen terakhir
                    if (e.shiftKey && document.activeElement === firstElement) {
                        lastElement.focus();
                        e.preventDefault();
                    }
                    // Jika Tab ditekan pada elemen terakhir, pindah ke elemen pertama
                    else if (!e.shiftKey && document.activeElement === lastElement) {
                        firstElement.focus();
                        e.preventDefault();
                    }
                }

                // Event listeners untuk membuka modal
                startCallBtn.addEventListener('click', openCallModal);
                startVideoCallBtn.addEventListener('click', openCallModal);

                // Event listener untuk semua tombol "end call" untuk menutup modal
                endCallBtns.forEach(btn => {
                    btn.addEventListener('click', closeCallModal);
                });
                const kamusPanel = document.getElementById('kamus-panel');
                const kamusToggleBtn = document.getElementById('kamus-toggle-btn');

                if (kamusPanel && kamusToggleBtn) {
                    kamusToggleBtn.addEventListener('click', () => {
                        kamusPanel.classList.toggle('is-open');
                    });
                }
            });
        </script>
        {{-- Jangan lupa untuk menyertakan file JavaScript WebRTC Anda --}}
        {{-- <script src="{{ asset('js/your-webrtc-handler.js') }}"></script> --}}
    @endpush
</x-layout_lawyer>
