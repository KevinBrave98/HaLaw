@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/konsultasi.css') }}">
@endpush

<x-layout_lawyer :title="'Halaw - Konsultasi Sedang Berlangsung'">

    {{-- 1. STRUKTUR NAVIGASI TAB --}}
    <nav class="konsultasi-nav d-flex border-bottom w-100" aria-label="Navigasi Konsultasi">
        <a href="{{ route('lawyer.konsultasi.berlangsung') }}"
            class="tab d-flex align-items-center justify-content-center flex-fill text-white text-decoration-none selected"
            aria-current="page">
            Sedang Berlangsung
        </a>
        <a href="#"
            class="tab d-flex align-items-center justify-content-center flex-fill text-white text-decoration-none">
            Riwayat Konsultasi
        </a>
    </nav>

    {{-- 2. STRUKTUR KONTEN UTAMA --}}
    <main class="container mt-4 konsultasi-list-container">
        <ul class="list-unstyled">
            @forelse ($riwayats as $riwayat)
                <li>
                    <article class="card shadow-sm mb-3">
                        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
                            <div class="d-flex align-items-center mb-2 mb-md-0 card-info-wrapper">
                                @if ($riwayat->pengguna->foto_pengguna)
                                    <img src="{{ asset('storage/' . $riwayat->pengguna->foto_pengguna) }}"
                                        alt="Foto {{ $riwayat->pengguna->nama_pengguna }}" class="lawyer-photo">
                                @else
                                    <img src="{{ asset('assets/images/foto-profil-default.jpg') }}"
                                        alt="Foto" class="lawyer-photo">
                                @endif
                                <div class="ms-3">
                                    <h3 class="h5 mb-1 lawyer-name">{{ $riwayat->pengguna->nama_pengguna }}</h3>
                                    @if ($riwayat->pesans->last())
                                        <small
                                            class="text-muted last-message">{{ $riwayat->pesans->last()->teks }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex gap-3 card-action-icons">
                                <div class="d-flex gap-3">
                                    <a href="{{ route('consultation.lawyer', ['id' => $riwayat->id]) }}"
                                        class="buka_tombol text-brown fs-4 mx-4 px-4 py-2 text-decoration-none text-bold"
                                        role="button"
                                        aria-label="Buka konsultasi dengan {{ $riwayat->pengacara->nama_pengacara }}{{ $riwayat->pesans->last() ? ', pesan terakhir: ' . Str::limit($riwayat->pesans->last()->teks, 50) : '' }}">Buka</a>
                                </div>
                                {{-- Ikon Chat --}}
                                {{-- @if ($riwayat->chat)
                                    <a href="{{ route('consultation.client', ['id' => $riwayat->id]) }}"
                                        class="text-brown fs-4" 
                                        aria-label="Mulai chat dengan {{ $riwayat->pengacara->nama_pengacara }}" title="Mulai Chat">
                                        <i class="bi bi-chat-left-text-fill"></i>
                                    </a>
                                @else
                                    <span class="fs-4 icon-disabled" title="Chat tidak tersedia">
                                        <i class="bi bi-chat-left-text-fill"></i>
                                    </span>
                                @endif --}}

                                {{-- Ikon Voice Call --}}
                                {{-- @if ($riwayat->voice_chat)
                                    <a href="#" class="text-brown fs-4"
                                       aria-label="Mulai panggilan suara dengan {{ $riwayat->pengacara->nama_pengacara }}" title="Mulai Panggilan Suara">
                                       <i class="bi bi-telephone-fill"></i>
                                    </a>
                                @else
                                    <span class="fs-4 icon-disabled" title="Panggilan suara tidak tersedia">
                                        <i class="bi bi-telephone-fill"></i>
                                    </span>
                                @endif

                                {{-- Ikon Video Call --}}
                                {{-- @if ($riwayat->video_call)
                                    <a href="#" class="text-brown fs-4"
                                       aria-label="Mulai panggilan video dengan {{ $riwayat->pengacara->nama_pengacara }}" title="Mulai Panggilan Video">
                                       <i class="bi bi-camera-video-fill"></i>
                                    </a>
                                @else
                                    <span class="fs-4 icon-disabled" title="Panggilan video tidak tersedia">
                                        <i class="bi bi-camera-video-fill"></i>
                                    </span>
                                @endif --}}
                            </div>
                        </div>
                    </article>
                </li>
            @empty
                <li>
                    <p class="text-center text-muted mt-5">Tidak ada data untuk ditampilkan.</p>
                </li>
            @endforelse
        </ul>
    </main>
</x-layout_lawyer>
