@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/discussion.css') }}">
@endpush
<x-layout_user :title="'Ruang Konsultasi'">
    <main class="d-flex flex-column konsultasi_wrapper">
        <section class="d-flex flex-row align-items-center justify-content-between py-4 heading">
            <div class="d-flex flex-row align-items-center gap-4 first-half w-50">
                <a href="#" class="mx-5">
                    <img src="{{ asset('assets/images/weui_arrow-filled.png') }}">
                </a>
                <div class="nama_pengacara d-flex flex-row">
                    <h2>{{ $riwayat->pengacara->nama_pengacara }}</h2>
                    <h2> - </h2>
                    <h2>Offline</h2>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-evenly second-half w-50">
                <div class="sisa_waktu d-flex flex-row">
                    <h2>Sisa Waktu</h2>
                    <h2> : </h2>
                    <h2>01:35:47</h2>
                </div>
                <a href="#" id="startCallLink">
                    <img src="{{ asset('assets/images/material-symbols_call.png') }}">
                </a>
                <a href="#" id="startVideoCallLink">
                    <img src="{{ asset('assets/images/weui_video-call-filled.png') }}">
                </a>
                <video id="localVideo" autoplay muted playsinline></video>   <!-- NEW -->
                <video id="remoteVideo" autoplay playsinline></video> 
                <audio id="remoteAudio" autoplay playsinline  hidden></audio>
            </div>
            <div id="callStatus" class="position-fixed bottom-0 end-0 m-3 p-3 bg-dark text-white rounded shadow d-none"
                style="z-index:1050; min-width:200px;">

                <p class="mb-2">🔔 Calling…</p>
                <button id="endCallBtn" class="btn btn-danger btn-sm">
                    End Call
                </button>
            </div>


            </div>

        </section>
        <section class="d-flex flex-column chat_wrapper my-4">
            @foreach ($pesan as $pesan_item)
                @if ($riwayat->pengguna->nik_pengguna == $pesan_item->nik)
                    <div class="chat d-flex flex-row p-2 w-100 justify-content-end">
                        <div class="chat_details d-flex flex-column w-25">
                            {{-- <h3>{{ $riwayat->pengguna->nama_pengguna }}</h3> --}}
                            <p class="chat-message">
                                {{ $pesan_item->teks }}
                            </p>
                        </div>
                        <div class="d-flex flex-column justify-content-end chat_time">
                            <p>{{ $pesan_item->created_at }}</p>
                        </div>
                    </div>
                @elseif ($riwayat->pengacara->nik_pengacara == $pesan_item->nik)
                    <div class="chat d-flex flex-row p-2 w-100 justify-content-start">
                        <div class="chat_details d-flex flex-column w-25">
                            <h3>{{ $riwayat->pengacara->nama_pengacara }}</h3>
                            <p class="chat-message">
                                {{ $pesan_item->teks }}
                            </p>
                        </div>
                        <div class="d-flex flex-column justify-content-start chat_time me-5 pe-5">
                            <p>{{ $pesan_item->created_at }}</p>
                        </div>
                    </div>
                @endif
            @endforeach
        </section>
        <section class="d-flex flex-row discussion-input w-100 p-4 mt-4">
            <form action="{{ route('consultation.client.send', ['id' => $riwayat->id]) }}" method="POST"
                id="form_masuk" class="d-flex flex-row w-100 gap-4 form_kirim_chat"
                data-riwayat-id="{{ $riwayat->id }}">
                @csrf
                <a href="#">
                    <img src="{{ asset('assets/images/ant-design_paper-clip-outlined(1).png') }}">
                </a>
                <input type="text" name="teks" class="form-control input-chat" id="input-chat">
                <a href="#">
                    <img src="{{ asset('assets/images/mingcute_send-line.png') }}">
                </a>
            </form>
        </section>
    </main>
    @push('scripts')
        <script>
            // Pass the riwayat ID to JS
            window.callId = "{{ $riwayat->id }}";
            // window.isClient = {{ auth()->user()->is_client ? 'true' : 'false' }};
        </script>
    @endpush
</x-layout_user>
