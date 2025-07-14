@push('css')

    <link rel="stylesheet" href="{{ asset('assets/styles/search_pengacara.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/hasil_pencarian.css') }}">
    @endpush
    <x-layout_user :title="'Pencarian Pengacara'">
        <div class="container">
            <div class="search-bar p-4 rounded-4 d-flex align-items-center">
                <x-search_pengacara></x-search_pengacara>
            </div>
        <h2 class="fw-bold">Filter Pencarian</h2>
        {{-- Filter Tags --}}
        @if (!empty($lawyers_search))
            <div class="mb-4 d-flex flex-wrap gap-3">
                @if (!empty($lawyers_search['nama_pengacara']))
                    <span class="badge rounded-pill bg-brown text-white px-3 py-2 filter-tag">
                        {{ $lawyers_search['nama_pengacara'] }}
                        <a href="{{ route('search.pengacara.view', ['remove_filter' => 'nama_pengacara']) }}" class="text-white text-decoration-none ms-2">
                            <img src="{{ asset('assets/images/icon_close.png') }}" alt="hapus nama pengacara"
                                class="icon-close">
                        </a>
                    </span>
                @endif

                @if (!empty($lawyers_search['jenis_kelamin']))
                    <span class="badge rounded-pill bg-brown text-white px-3 py-2 filter-tag">
                        {{ $lawyers_search['jenis_kelamin'] }}
                        <a href="{{ route('search.pengacara.view', ['remove_filter' => 'jenis_kelamin']) }}" class="text-white text-decoration-none ms-2">
                            <img src="{{ asset('assets/images/icon_close.png') }}" alt="hapus jenis kelamin"
                                class="icon-close">
                        </a>
                    </span>
                @endif

                @if (!empty($lawyers_search['spesialisasi']))
                    <span class="badge rounded-pill bg-brown text-white px-3 py-2 filter-tag">
                        {{ $lawyers_search['spesialisasi'] }}
                        <a href="{{ route('search.pengacara.view', ['remove_filter' => 'spesialisasi']) }}" class="text-white text-decoration-none ms-2">
                            <img src="{{ asset('assets/images/icon_close.png') }}" alt="hapus nama pengacara"
                                class="hapus spesialisasi">
                        </a>
                    </span>
                @endif

                @if (!empty($lawyers_search['jenis_layanan']))
                    @foreach ($lawyers_search['jenis_layanan'] as $layanan)
                        <span class="badge rounded-pill bg-brown text-white px-3 py-2 filter-tag">
                            {{ $layananLabels[$layanan] ?? ucfirst($layanan) }}
                            <a href="{{ route('search.pengacara.view', ['remove_filter' => 'jenis_layanan', 'remove_value' => $layanan]) }}" class="text-white text-decoration-none ms-2">
                                <img src="{{ asset('assets/images/icon_close.png') }}" alt="hapus jenis layanan"
                                    class="icon-close">
                            </a>
                        </span>
                    @endforeach
                @endif

                @if (isset($lawyers_search['min_price']) && isset($lawyers_search['max_price']))
                    <span class="badge rounded-pill bg-brown text-white px-3 py-2 filter-tag">
                        Rp{{ number_format($lawyers_search['min_price'], 2, ',', '.') }} -
                        Rp{{ number_format($lawyers_search['max_price'], 2, ',', '.') }}
                        <a href="{{ route('search.pengacara.view', ['remove_filter' => 'harga']) }}" class="text-white text-decoration-none ms-2">
                            <img src="{{ asset('assets/images/icon_close.png') }}" alt="hapus harga"
                                class="icon-close">
                        </a>
                    </span>
                @endif
            </div>
        @endif
        <h1 class="fw-bold ms-6">Hasil Pencarian</h1>
        @if ($lawyers_search->isEmpty())
            <div class="text-center mt-5">
                <img src="{{ asset('assets/images/no-result.png') }}" alt="Pencarian tidak ditemukan"
                    class="img-fluid" style="max-width: 300px;">
                <h2 class="mt-4">Pencarian tidak ditemukan</h2>
            </div>
        @else
            <div class="row">
               @foreach ($lawyers_search as $lawyer_card)
                    <div class="lawyer-card">
                        @if ($lawyer_card->foto_pengacara == null)
                            <div class="image_wrapper">
                                <img src="{{ asset('assets/images/lawyer1.jpeg') }}" alt="Fajar Nugroho"
                                    class="lawyer-image">
                            </div>
                        @else
                            <div class="image_wrapper">
                                <img src="{{ asset('storage/' . $lawyer_card->foto_pengacara) }}"
                                    alt="{{ $lawyer_card->nama_pengacara }}" class="lawyer-image">
                            </div>
                        @endif
                        <div class="content-wrapper">
                            <div>
                                <h5 class="nama">{{ $lawyer_card->nama_pengacara }}</h5>
                                <p class="spesialisasi">
                                    Hukum perdata, Hukum pidana, Litigasi & Sengketa...
                                </p>
                                <div class="badges">
                                    <span class="badge-custom">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M6.5 0a.5.5 0 0 0-.5.5V2H3a2 2 0 0 0-2 2v1h14V4a2 2 0 0 0-2-2H10V.5a.5.5 0 0 0-.5-.5h-3zM7 2V1h2v1H7z" />
                                            <path d="M0 5v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V5H0z" />
                                        </svg>
                                        7 - 10 tahun
                                    </span>
                                    <span class="badge-custom">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M13 7c1.105 0 2-.672 2-1.5S14.105 4 13 4s-2 .672-2 1.5S11.895 7 13 7zM6.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm6.5 1c-1.183 0-3.337.356-4.5 1.21C7.337 9.356 5.183 9 4 9c-1.5 0-4 .75-4 2.25V13a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-.75c0-1.5-2.5-2.25-4-2.25z" />
                                        </svg>
                                        40 klien
                                    </span>
                                </div>
                            </div>
                            <div class="price-detail">
                                <div class="harga">Rp. {{ number_format($lawyer_card->tarif_jasa, 0, ',', '.') }}</div>
                                <a href="#" class="btn-detail">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <script src="{{ asset('assets/scripts/search_pengguna.js') }}"></script>
</x-layout_user>
