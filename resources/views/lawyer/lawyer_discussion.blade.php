@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/discussion.css') }}">
@endpush
<x-layout_lawyer :title="'Ruang Konsultasi'">
    <main class="d-flex flex-column konsultasi_wrapper">
        @if ($riwayat->status !== 'sedang berlangsung')
            <div class="alert alert-danger text-center p-3 mx-4 my-2 rounded" style="background-color: #f8d7da; color: #842029;">
                ❗ Konsultasi ini telah <strong>dibatalkan secara otomatis</strong> karena pengacara tidak merespons selama 15 menit.
            </div>
        @endif
        <section class="d-flex flex-row align-items-center justify-content-between py-4 heading">
            <div class="d-flex flex-row align-items-center gap-4 first-half w-50">
                <a href="#" class="mx-5">
                    <img src="{{ asset('assets/images/weui_arrow-filled.png') }}">
                </a>
                <div class="nama_pengacara d-flex flex-row">
                    <h2>{{ $riwayat->pengguna->nama_pengguna }}</h2>
                    {{-- <h2> - </h2>
                    <h2>Offline</h2> --}}
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-evenly second-half w-50">
                <div class="sisa_waktu d-flex flex-row">
                    <h2>Sisa Waktu</h2>
                    <h2> : </h2>
                    <h2>01:35:47</h2>
                </div>
                {{-- <a href="#">
                    <img src="{{ asset('assets/images/material-symbols_call.png') }}">
                </a>
                <a href="#">
                    <img src="{{ asset('assets/images/weui_video-call-filled.png') }}">
                </a> --}}
            </div>
        </section>
        <section class="d-flex flex-column chat_wrapper my-4">
            @foreach ($pesan as $pesan_item)
                @if ($riwayat->pengacara->nik_pengacara == $pesan_item->nik)
                    <div class="chat d-flex flex-row p-2 w-100 justify-content-end">
                        <div class="chat_details d-flex flex-column w-25">
                            {{-- <h3>{{ $riwayat->pengacara->nama_pengacara }}</h3> --}}
                            <p class="chat-message">
                                {{ $pesan_item->teks }}
                            </p>
                        </div>
                        <div class="d-flex flex-column justify-content-end chat_time">
                            <p>{{ $pesan_item->created_at }}</p>
                        </div>
                    </div>
                @elseif ($riwayat->pengguna->nik_pengguna == $pesan_item->nik)
                    <div class="chat d-flex flex-row p-2 w-100 justify-content-start">
                        <div class="chat_details d-flex flex-column w-25">
                            <h3>{{ $riwayat->pengguna->nama_pengguna }}</h3>
                            <p class="chat-message">
                                {{ $pesan_item->teks }}
                            </p>
                        </div>
                        <div class="d-flex flex-column justify-content-end chat_time me-5 pe-5">
                            <p>{{ $pesan_item->created_at }}</p>
                        </div>
                    </div>
                @endif
            @endforeach
        </section>
        <section class="d-flex flex-row discussion-input w-100 p-4 mt-4">
            <form action="{{ route('consultation.lawyer.send', ['id' => $riwayat->id]) }}" method="POST" id="form_kirim_chat" class="d-flex flex-row w-100 gap-4 form_kirim_chat" data-riwayat-id="{{ $riwayat->id }}">
                @csrf
                <a href="#">
                    <img src="{{ asset('assets/images/ant-design_paper-clip-outlined(1).png') }}">
                </a>
                <input type="text" name="teks" class="form-control input-chat" id="input_chat">
                <a href="#">
                    <img src="{{ asset('assets/images/mingcute_send-line.png') }}">
                </a>
            </form>
        </section>
    </main>
</x-layout_user>
