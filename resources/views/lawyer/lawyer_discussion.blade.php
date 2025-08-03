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

        {{-- Chat Wrapper: No changes needed here --}}
        <ul class="d-flex flex-column chat_wrapper">
            @foreach ($pesan as $pesan_item)
                <li
                    class="chat d-flex flex-row p-2 w-100 {{ $riwayat->pengacara->nik_pengacara == $pesan_item->nik ? 'justify-content-end' : 'justify-content-start' }}" tabindex="0"  aria-label="{{$riwayat->pengacara->nik_pengacara == $pesan_item->nik ? 'Anda mengatakan'. $pesan_item->teks : $riwayat->pengguna->nama_pengguna. 'mengatakan'. $pesan_item->teks}}">
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

    {{-- Call UI: No changes needed here --}}
    <div id="call-ui-container" class="d-none">
        <video id="remoteVideo" autoplay playsinline></video>
        <audio id="remoteAudio" autoplay playsinline hidden></audio>
        <div class="call-info">
            <img src="{{ asset('assets/images/foto-profil-default.jpg') }}" alt="Foto Profil" class="call-avatar">
            <h3 id="call-info-name" class="call-name">Memanggil {{ $riwayat->pengguna->nama_pengguna }}...</h3>
            <p id="call-info-status" class="call-status">Berdering</p>
            <button class="control-btn end-call mt-4" aria-label="Batalkan Panggilan">
                <i class="bi bi-telephone-fill"></i>
            </button>
        </div>
        <div class="in-call-view">
            <video id="localVideo" autoplay muted playsinline></video>
            <div class="call-controls">
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
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{-- PERUBAHAN UTAMA: Script timer ditambahkan di sini --}}
    {{-- ========================================================================= --}}
    @push('scripts')
        <script>
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
                const endTime = new Date(startTime.getTime() + 60 * 60 * 1000); // Set akhir waktu 1 jam dari waktu mulai

                const countdownInterval = setInterval(() => {
                    const now = new Date();
                    const remainingTime = endTime - now;

                    // Jika waktu habis
                    if (remainingTime <= 0) {
                        clearInterval(countdownInterval);
                        timerElement.textContent = "00:00:00";
                        // Anda bisa menonaktifkan tombol call/chat di sini jika perlu
                        document.getElementById('startCallLink').disabled = true;
                        document.getElementById('startVideoCallLink').disabled = true;
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
            });
        </script>
        {{-- Jangan lupa untuk menyertakan file JavaScript WebRTC Anda --}}
        {{-- <script src="{{ asset('js/your-webrtc-handler.js') }}"></script> --}}
    @endpush
</x-layout_lawyer>