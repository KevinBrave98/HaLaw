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
                @if (!empty($filters['nama_pengacara']))
                    <span class="badge rounded-pill bg-brown text-white px-3 py-2 filter-tag">
                        {{ $filters['nama_pengacara'] }}
                        <a href="{{ route('search.pengacara.view', ['remove_filter' => 'nama_pengacara']) }}"
                            class="text-white text-decoration-none ms-2">
                            <img src="{{ asset('assets/images/icon_close.png') }}" alt="hapus nama pengacara"
                                class="icon-close">
                        </a>
                    </span>
                @endif

                @if (!empty($filters['jenis_kelamin']))
                    <span class="badge rounded-pill bg-brown text-white px-3 py-2 filter-tag">
                        {{ $filters['jenis_kelamin'] }}
                        <a href="{{ route('search.pengacara.view', ['remove_filter' => 'jenis_kelamin']) }}"
                            class="text-white text-decoration-none ms-2">
                            <img src="{{ asset('assets/images/icon_close.png') }}" alt="hapus jenis kelamin"
                                class="icon-close">
                        </a>
                    </span>
                @endif

                @if (!empty($filters['spesialisasi']))
                    <span class="badge rounded-pill bg-brown text-white px-3 py-2 filter-tag">
                        {{ $filters['spesialisasi'] }}
                        <a href="{{ route('search.pengacara.view', ['remove_filter' => 'spesialisasi']) }}"
                            class="text-white text-decoration-none ms-2">
                            <img src="{{ asset('assets/images/icon_close.png') }}" alt="hapus nama pengacara"
                                class="hapus spesialisasi">
                        </a>
                    </span>
                @endif

                @if (!empty($filters['jenis_layanan']))
                    @foreach ($filters['jenis_layanan'] as $layanan)
                        <span class="badge rounded-pill bg-brown text-white px-3 py-2 filter-tag">
                            {{ $layananLabels[$layanan] ?? ucfirst($layanan) }}
                            <a href="{{ route('search.pengacara.view', ['remove_filter' => 'jenis_layanan', 'remove_value' => $layanan]) }}"
                                class="text-white text-decoration-none ms-2">
                                <img src="{{ asset('assets/images/icon_close.png') }}" alt="hapus jenis layanan"
                                    class="icon-close">
                            </a>
                        </span>
                    @endforeach
                @endif

                @if (isset($filters['min_price']) && isset($filters['max_price']))
                    <span class="badge rounded-pill bg-brown text-white px-3 py-2 filter-tag">
                        Rp{{ number_format($filters['min_price'], 2, ',', '.') }} -
                        Rp{{ number_format($filters['max_price'], 2, ',', '.') }}
                        <a href="{{ route('search.pengacara.view', ['remove_filter' => 'harga']) }}"
                            class="text-white text-decoration-none ms-2">
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
                <img src="{{ asset('assets/images/no-result.png') }}" alt="Pencarian tidak ditemukan" class="img-fluid"
                    style="max-width: 300px;">
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
                                    @if ($lawyer_card->chat)
                                        <span class="badge-custom">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-chat-fill" viewBox="0 0 16 16">
                                                <path d="M8 0a8 8 0 0 0-6.84 12.29L0 16l3.71-1.16A8 8 0 1 0 8 0z" />
                                            </svg>
                                            Pesan
                                        </span>
                                    @endif

                                    @if ($lawyer_card->voice_chat)
                                        <span class="badge-custom">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                                            </svg>
                                            Panggilan suara
                                        </span>
                                    @endif

                                    @if ($lawyer_card->video_call)
                                        <span class="badge-custom">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-camera-video-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M0 5a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v.5l3.5-2v9l-3.5-2V11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V5z" />
                                            </svg>
                                            Panggilan Video
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="price-detail">
                                <div class="harga">Rp. {{ number_format($lawyer_card->tarif_jasa, 0, ',', '.') }}
                                </div>
                                <a href="{{ route('detail.pengacara', $lawyer_card->nik_pengacara) }}"
                                    class="btn-detail">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <script src="{{ asset('assets/scripts/search_pengguna.js') }}"></script>
</x-layout_user>
