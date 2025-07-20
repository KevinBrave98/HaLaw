@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/kamus.css') }}">
@endpush
<x-layout :title="'Kamus Hukum'">
    <x-slot:title>Kamus Hukum</x-slot:title>
    <div class="container py-5">

        <h1 class="text-center tulisan-cari-istilah">CARI ISTILAH HUKUM</h1>

        <form method="GET" action="{{ route('kamus') }}" class="mb-5">
            <div class="d-flex flex-row kamus-search-bar">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Cari Istilah" value="{{ request('q') }}">
                </div>
                <div class="container-search">
                    <button class="btn d-flex flex-row" type="submit">
                        <img class="img-search" src="{{ asset('assets/images/search-kamus.png') }}" alt="search-icon">
                        Cari
                    </button>
                </div>
            </div>
        </form>


    <h5 class="mb-3 teks-cari-huruf">Cari berdasarkan huruf</h5>
    <div class="mb-5">
        <a href="{{ route('kamus') }}" class="btn btn-outline-warning btn-sm mb-1 huruf huruf-all {{ request('letter') == null ? 'active-letter' : '' }}">
            Semua
        </a>
        @foreach (range('A', 'Z') as $char)
            <a href="{{ route('kamus', ['letter' => $char]) }}" class="btn btn-outline-warning btn-sm mb-1 huruf {{ request('letter') == $char ? 'active-letter' : '' }}">
                {{ $char }}
            </a>
        @endforeach
    </div>
    @if($letter)
        <h3 class="mb-3">Kamus Hukum</h3>
        <div class="huruf-terpilih">{{ $letter }}</div>
    @elseif($query)
        <h3 class="mb-3">Hasil Pencarian untuk "{{ $query }}"</h3>
    @else
        <h3 class="mb-3">Kamus Hukum</h3>
    @endif

    @if($kamus->count())
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-3 mb-4">
            @foreach ($kamus as $item)
                <div class="col">
                    <div
                        class="istilah-item"
                        data-bs-toggle="modal"
                        data-bs-target="#kamusModal"
                        data-istilah="{{ e($item->istilah) }}"
                        data-arti="{{ e($item->arti_istilah) }}"
                        >

                        {{-- <div class="card-body">
                            <h6 class="card-title mb-0">{{ $item->istilah }}</h6>
                        </div> --}}
                        {{ $item->istilah }}
                    </div>
                </div>
            @endforeach
        </div>


        <div class="d-flex justify-content-center">
            {{ $kamus->onEachSide(1)->links('pagination::bootstrap-5') }}
            {{-- onEachSide(1) = tampil 1 halaman kiri/kanan dari yang aktif (misal 2 3 4)
            'pagination::bootstrap-5' = pakai template Bootstrap bawaan Laravel --}}
        </div>
    @elseif($query || $letter)
        <p class="text-muted">Tidak ditemukan hasil untuk pencarian ini.</p>
    @endif


    <div class="modal fade" id="kamusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Judul Awal Modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="modalArti">Isi arti istilah muncul di sini</p>
                </div>
            </div>
        </div>
    </div>



    <script src="{{ asset('assets/scripts/kamus-modal.js') }}"></script>
</x-layout>
