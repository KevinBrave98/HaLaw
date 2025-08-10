@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/search_pengacara.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/hasil_pencarian.css') }}">
@endpush

<x-layout_user :title="'Pencarian Pengacara'">
    {{-- Menggunakan <main> untuk konten utama halaman --}}
    <main class="container">
        <a class="button-back mt-4 d-block" href="{{ route('dashboard.user') }}" aria-label="Kembali ke Dashboard">
            <img src="{{ asset('assets/images/icon-back.png') }}" alt="">
        </a>

        {{-- Menggunakan <section> untuk blok pencarian --}}
        <section class="search-bar p-4 rounded-4 d-flex align-items-center" aria-labelledby="search-heading">
            <h2 id="search-heading" class="visually-hidden">Formulir Pencarian Pengacara</h2>
            <x-search_pengacara :hargaMin="$harga_min" :hargaMax="$harga_max" :spesialisasi="$spesialisasi"></x-search_pengacara>
        </section>

        {{-- Filter Tags --}}
        @if (!empty($lawyers_search))
            <section aria-labelledby="filter-tags-heading">
                <h2 id="filter-tags-heading" class="fw-bold">Filter Pencarian</h2>
                {{-- Menggunakan <ul> untuk daftar filter yang lebih semantik --}}
                <ul class="mb-4 d-flex flex-wrap gap-3 list-unstyled">
                    @if (!empty($filters['nama_pengacara']))
                        <li>
                            <span class="badge rounded-pill bg-brown text-white px-3 py-2 filter-tag">
                                {{ $filters['nama_pengacara'] }}
                                <a href="{{ route('search.pengacara.view', ['remove_filter' => 'nama_pengacara']) }}"
                                    class="text-white text-decoration-none ms-2"
                                    aria-label="Hapus filter nama: {{ $filters['nama_pengacara'] }}">
                                    <img src="{{ asset('assets/images/icon_close.png') }}" alt=""
                                        class="icon-close">
                                </a>
                            </span>
                        </li>
                    @endif

                    @if (!empty($filters['jenis_kelamin']))
                        <li>
                            <span class="badge rounded-pill bg-brown text-white px-3 py-2 filter-tag">
                                {{ $filters['jenis_kelamin'] }}
                                <a href="{{ route('search.pengacara.view', ['remove_filter' => 'jenis_kelamin']) }}"
                                    class="text-white text-decoration-none ms-2"
                                    aria-label="Hapus filter jenis kelamin: {{ $filters['jenis_kelamin'] }}">
                                    <img src="{{ asset('assets/images/icon_close.png') }}" alt=""
                                        class="icon-close">
                                </a>
                            </span>
                        </li>
                    @endif

                    @if (!empty($filters['spesialisasi']))
                        <li>
                            <span class="badge rounded-pill bg-brown text-white px-3 py-2 filter-tag">
                                {{ $filters['spesialisasi'] }}
                                <a href="{{ route('search.pengacara.view', ['remove_filter' => 'spesialisasi']) }}"
                                    class="text-white text-decoration-none ms-2"
                                    aria-label="Hapus filter spesialisasi: {{ $filters['spesialisasi'] }}">
                                    <img src="{{ asset('assets/images/icon_close.png') }}" alt=""
                                        class="icon-close">
                                </a>
                            </span>
                        </li>
                    @endif

                    @if (!empty($filters['jenis_layanan']))
                        @foreach ($filters['jenis_layanan'] as $layanan)
                            <li>
                                <span class="badge rounded-pill bg-brown text-white px-3 py-2 filter-tag">
                                    {{ $layananLabels[$layanan] ?? ucfirst($layanan) }}
                                    <a href="{{ route('search.pengacara.view', ['remove_filter' => 'jenis_layanan', 'remove_value' => $layanan]) }}"
                                        class="text-white text-decoration-none ms-2"
                                        aria-label="Hapus filter layanan: {{ $layananLabels[$layanan] ?? ucfirst($layanan) }}">
                                        <img src="{{ asset('assets/images/icon_close.png') }}" alt=""
                                            class="icon-close">
                                    </a>
                                </span>
                            </li>
                        @endforeach
                    @endif

                    @if (isset($filters['min_price']) && isset($filters['max_price']))
                        <li>
                            <span class="badge rounded-pill bg-brown text-white px-3 py-2 filter-tag">
                                Rp{{ number_format($filters['min_price'], 0, ',', '.') }} -
                                Rp{{ number_format($filters['max_price'], 0, ',', '.') }}
                                <a href="{{ route('search.pengacara.view', ['remove_filter' => 'harga']) }}"
                                    class="text-white text-decoration-none ms-2" aria-label="Hapus filter harga">
                                    <img src="{{ asset('assets/images/icon_close.png') }}" alt=""
                                        class="icon-close">
                                </a>
                            </span>
                        </li>
                    @endif
                </ul>
            </section>
        @endif

        <section aria-labelledby="search-results-heading">
            <h1 id="search-results-heading" class="fw-bold ms-6">Hasil Pencarian</h1>
            @if ($lawyers_search->isEmpty())
                <div class="text-center mt-5">
                    <img src="{{ asset('assets/images/no-result.png') }}" alt="Pencarian tidak ditemukan"
                        class="img-fluid" style="max-width: 300px;">
                    <h2 class="mt-4">Pencarian tidak ditemukan</h2>
                </div>
            @else
                {{-- Menggunakan <ul> untuk daftar hasil pencarian --}}
                <ul class="row list-unstyled">
                    @foreach ($lawyers_search as $lawyer_card)
                        <li class="col-md-6 mb-4">
                            {{-- Menggunakan <article> untuk setiap kartu pengacara --}}
                            <article class="lawyer-card">
                                <div class="image_wrapper">
                                    @if ($lawyer_card->foto_pengacara == null)
                                        <img src="{{ asset('assets/images/foto-profil-default.jpg') }}"
                                            alt="Foto Pengacara" class="lawyer-image">
                                    @else
                                        <img src="{{ asset('storage/' . $lawyer_card->foto_pengacara) }}"
                                            alt="Foto {{ $lawyer_card->nama_pengacara }}" class="lawyer-image">
                                    @endif
                                </div>
                                <div class="content-wrapper">
                                    <div>
                                        {{-- Menggunakan <h3> untuk nama di dalam kartu --}}
                                        <h3 class="nama h5">{{ $lawyer_card->nama_pengacara }}</h3>
                                        <p class="spesialisasi">
                                            @if ($lawyer_card->spesialisasis && $lawyer_card->spesialisasis->count() > 0)
                                                {{ Str::limit($lawyer_card->spesialisasis->pluck('nama_spesialisasi')->implode(', '), 50, '...') }}
                                            @else
                                                Tidak Ada Spesialisasi
                                            @endif
                                        </p>
                                        {{-- Menggunakan <ul> untuk daftar badge layanan --}}
                                        <ul class="badges list-unstyled">
                                            @if ($lawyer_card->chat)
                                                <li>
                                                    <span class="badge-custom">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor" class="bi bi-chat-fill"
                                                            viewBox="0 0 16 16" aria-hidden="true">
                                                            <path
                                                                d="M8 0a8 8 0 0 0-6.84 12.29L0 16l3.71-1.16A8 8 0 1 0 8 0z" />
                                                        </svg>
                                                        Pesan
                                                    </span>
                                                </li>
                                            @endif
                                            @if ($lawyer_card->voice_chat)
                                                <li>
                                                    <span class="badge-custom">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor"
                                                            class="bi bi-telephone-fill" viewBox="0 0 16 16"
                                                            aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                                                        </svg>
                                                        Panggilan suara
                                                    </span>
                                                </li>
                                            @endif
                                            @if ($lawyer_card->video_call)
                                                <li>
                                                    <span class="badge-custom">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor"
                                                            class="bi bi-camera-video-fill" viewBox="0 0 16 16"
                                                            aria-hidden="true">
                                                            <path
                                                                d="M0 5a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v.5l3.5-2v9l-3.5-2V11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V5z" />
                                                        </svg>
                                                        Panggilan Video
                                                    </span>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="price-detail">
                                        <div class="harga">Rp.
                                            {{ number_format($lawyer_card->tarif_jasa, 0, ',', '.') }}</div>
                                        <a href="{{ route('detail.pengacara', $lawyer_card->nik_pengacara) }}"
                                            class="btn-detail"
                                            aria-label="Lihat Detail untuk {{ $lawyer_card->nama_pengacara }}.
                                            Spesialisasi: {{ Str::limit($lawyer_card->spesialisasis->pluck('nama_spesialisasi')->implode(', '), 50, '...') }}
                                            Tarif jasa: Rp. {{ number_format($lawyer_card->tarif_jasa, 0, ',', '.') }}.
                                            Layanan tersedia:
                                            {{ $lawyer_card->chat ? 'Pesan,' : '' }}
                                            {{ $lawyer_card->voice_chat ? 'Panggilan suara,' : '' }}
                                            {{ $lawyer_card->video_call ? 'Panggilan Video.' : '' }}">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>
    </main>
    <script src="{{ asset('assets/scripts/search_pengguna.js') }}"></script>
</x-layout_user>
