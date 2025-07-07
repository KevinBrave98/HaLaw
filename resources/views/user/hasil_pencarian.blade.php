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
        @if (!empty($filters))
            <div class="mb-4 d-flex flex-wrap gap-3">
                @if (!empty($filters['nama_pengacara']))
                    <span class="badge rounded-pill bg-brown text-white px-3 py-2 filter-tag">
                        {{ $filters['nama_pengacara'] }}
                        <a href="{{ route('search.pengacara.view', ['remove_filter' => 'nama_pengacara']) }}" class="text-white text-decoration-none ms-2">
                            <img src="{{ asset('assets/images/icon_close.png') }}" alt="hapus nama pengacara"
                                class="icon-close">
                        </a>
                    </span>
                @endif

                @if (!empty($filters['jenis_kelamin']))
                    <span class="badge rounded-pill bg-brown text-white px-3 py-2 filter-tag">
                        {{ $filters['jenis_kelamin'] }}
                        <a href="{{ route('search.pengacara.view', ['remove_filter' => 'jenis_kelamin']) }}" class="text-white text-decoration-none ms-2">
                            <img src="{{ asset('assets/images/icon_close.png') }}" alt="hapus jenis kelamin"
                                class="icon-close">
                        </a>
                    </span>
                @endif

                @if (!empty($filters['spesialisasi']))
                    <span class="badge rounded-pill bg-brown text-white px-3 py-2 filter-tag">
                        {{ $filters['spesialisasi'] }}
                        <a href="{{ route('search.pengacara.view', ['remove_filter' => 'spesialisasi']) }}" class="text-white text-decoration-none ms-2">
                            <img src="{{ asset('assets/images/icon_close.png') }}" alt="hapus nama pengacara"
                                class="hapus spesialisasi">
                        </a>
                    </span>
                @endif

                @if (!empty($filters['jenis_layanan']))
                    @foreach ($filters['jenis_layanan'] as $layanan)
                        <span class="badge rounded-pill bg-brown text-white px-3 py-2 filter-tag">
                            {{ $layananLabels[$layanan] ?? ucfirst($layanan) }}
                            <a href="{{ route('search.pengacara.view', ['remove_filter' => 'jenis_layanan', 'remove_value' => $layanan]) }}" class="text-white text-decoration-none ms-2">
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
                @foreach ($lawyers_search as $lawyer)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <!-- Replace this part with your actual card layout -->
                            <div class="card-body">
                                <h5 class="card-title">{{ $lawyer->nama_pengacara }}</h5>
                                <p class="card-text">{{ $lawyer->spesialisasi }}</p>
                                <p class="card-text">Rp{{ number_format($lawyer->tarif_jasa, 0, ',', '.') }}</p>
                                <a href="{{ route('search.pengacara.view', ['remove_filter' => 'jenis_kelamin']) }}" class="btn btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <script src="{{ asset('assets/scripts/search_pengguna.js') }}"></script>
</x-layout_user>
