@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/discussion.css') }}">
@endpush

<x-layout_lawyer :title="'Ruang Konsultasi'">
    <main class="d-flex flex-column konsultasi_wrapper">

        {{-- Tag <section> diubah menjadi <header> (lebih semantik), semua class tetap sama --}}
        <header class="heading d-flex flex-row align-items-center justify-content-between">
            <div class="d-flex flex-row align-items-center gap-4 first-half w-50">
                {{-- Menambahkan aria-label yang jelas untuk link ikon kembali --}}
                <a href="{{ url()->previous() }}" class="mx-5" aria-label="Kembali">
                    <img src="{{ asset('assets/images/weui_arrow-filled.png') }}" alt="">
                </a>
                {{-- Menggabungkan beberapa <h2> menjadi satu blok teks yang logis di dalam div asli --}}
                <div class="nama_pengacara d-flex flex-row">
                    <h2 class="h5 mb-0">{{ $riwayat->pengacara->nama_pengacara }}</h2>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-evenly second-half w-50">
                <div class="sisa_waktu d-flex flex-row">
                    {{-- Menggunakan <p> untuk teks dan <span> untuk nilai dinamis agar lebih tepat --}}
                    <p class="h2 mb-0">Sisa Waktu : <span id="countdown-timer" aria-live="polite">01:35:47</span></p>
                </div>
                {{-- <a href="#">
                    <img src="{{ asset('assets/images/material-symbols_call.png') }}">
                </a>
                <a href="#">
                    <img src="{{ asset('assets/images/weui_video-call-filled.png') }}">
                </a> --}}
                <audio id="remoteAudio" autoplay playsinline  hidden></audio>
            </div>
            <div id="callStatus" class="position-fixed bottom-0 end-0 m-3 p-3 bg-dark text-white rounded shadow d-none"
                style="z-index:1050; min-width:200px;">

                <p class="mb-2">🔔 Calling…</p>
                <button id="endCallBtn" class="btn btn-danger btn-sm">
                    End Call
                </button>
                <button type="button" id="startVideoCallLink" aria-label="Mulai Panggilan Video">
                    <img src="{{ asset('assets/images/weui_video-call-filled.png') }}" alt="">
                </button> --}}
            </div>
        </header>

        {{-- Menggunakan <ul> untuk daftar chat. Class asli tetap dipertahankan. --}}
        <ul class="d-flex flex-column chat_wrapper my-4">
            @foreach ($pesan as $pesan_item)
                {{-- Setiap bubble chat adalah sebuah <li>. Class asli tetap dipertahankan. --}}
                {{-- Ganti seluruh isi <li> Anda dengan ini --}}
                <li
                    class="chat d-flex flex-row p-2 w-100 {{ $riwayat->pengguna->nik_pengguna == $pesan_item->nik ? 'justify-content-end' : 'justify-content-start' }}">

                    {{-- Profil picture diabaikan untuk sekarang --}}

                    {{-- PERBAIKAN UTAMA: .chat_time sekarang ada di dalam .chat_details --}}
                    <div class="chat_details d-flex flex-column">
                        @if ($riwayat->pengguna->nik_pengguna != $pesan_item->nik)
                            <h3>{{ $pesan_item->teks }}
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

        <section class="d-flex flex-row discussion-input w-100 p-4 mt-4" aria-label="Area kirim pesan">
            <form action="{{ route('consultation.client.send', ['id' => $riwayat->id]) }}" method="POST"
                id="form_masuk" class="d-flex flex-row w-100 gap-4 form_kirim_chat"
                data-riwayat-id="{{ $riwayat->id }}">
                @csrf

                {{-- Mengubah <a> menjadi <button> untuk aksi. --}}
                <button type="button" aria-label="Lampirkan file">
                    <img src="{{ asset('assets/images/ant-design_paper-clip-outlined(1).png') }}" alt="">
                </button>

                {{-- Menambahkan <label> yang diperlukan untuk aksesibilitas input chat --}}
                <label for="input-chat" class="visually-hidden">Ketik pesan Anda</label>
                <input type="text" name="teks" class="form-control input-chat" id="input-chat">

                {{-- Mengubah <a> menjadi <button type="submit"> --}}
                <button type="submit" aria-label="Kirim pesan">
                    <img src="{{ asset('assets/images/mingcute_send-line.png') }}" alt="">
                </button>
            </form>
        </section>
        <div id="call-ui-container" class="d-none">

            {{-- Video dari lawan bicara (menjadi latar belakang) --}}
            <video id="remoteVideo" autoplay playsinline></video>
            {{-- Audio dari lawan bicara --}}
            <audio id="remoteAudio" autoplay playsinline hidden></audio>

            {{-- Tampilan saat memanggil (ringing state) --}}
            <div class="call-info">
                <img src="{{ asset('assets/images/foto-profil-default.jpg') }}" alt="Foto Profil" class="call-avatar">
                <h3 id="call-info-name" class="call-name">Memanggil {{ $riwayat->pengacara->nama_pengacara }}...</h3>
                <p id="call-info-status" class="call-status">Berdering</p>

                <button class="control-btn end-call mt-4" aria-label="Batalkan Panggilan">
                    <i class="bi bi-telephone-fill"></i>
                </button>
            </div>

            {{-- Tampilan saat panggilan berlangsung --}}
            <div class="in-call-view">
                {{-- Video dari Anda (tampilan kecil di pojok) --}}
                <video id="localVideo" autoplay muted playsinline></video>

                {{-- Panel tombol kontrol di bawah --}}
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
    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // 1. Pilih elemen area chat yang bisa di-scroll
                const chatWrapper = document.querySelector('.chat_wrapper');

                // 2. Buat fungsi untuk melakukan scroll ke paling bawah
                function scrollToBottom() {
                    if (chatWrapper) {
                        chatWrapper.scrollTop = chatWrapper.scrollHeight;
                    }
                }

                // 3. Panggil fungsi saat halaman pertama kali dimuat
                scrollToBottom();

                // 4. (PENTING) Panggil fungsi ini setiap kali ada pesan baru
                // Anda perlu mengintegrasikan ini dengan logika pengiriman/penerimaan pesan Anda.
                // Contoh:
                // Jika Anda menambahkan pesan baru secara dinamis, panggil scrollToBottom() setelahnya.
                // window.addEventListener('newMessage', scrollToBottom); // Ini hanya contoh event
            });
            window.callId = "{{ $riwayat->id }}";
        </script>
    @endpush
</x-layout_lawyer>
