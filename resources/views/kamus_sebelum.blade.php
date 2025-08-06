@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/kamus.css') }}">
@endpush

<x-layout :title="'Kamus Hukum'">
    <x-slot:title>Kamus Hukum</x-slot:title>

    {{-- Menggunakan <main> untuk konten utama halaman agar lebih semantik --}}
    <main class="container py-5">

        <h1 class="text-center tulisan-cari-istilah">CARI ISTILAH HUKUM</h1>

        {{-- Menambahkan tag <section> untuk mengelompokkan form pencarian --}}
        <section aria-labelledby="search-heading">
            <h2 id="search-heading" class="visually-hidden">Pencarian Istilah</h2>
            <form method="GET" action="{{ route('kamus') }}" class="mb-5">
                <div class="d-flex flex-row kamus-search-bar">
                    <div class="input-group">
                        {{-- Menambahkan <label> yang tersembunyi untuk aksesibilitas screen reader --}}
                        <label for="search-term" class="visually-hidden">Cari Istilah</label>
                        <input type="text" name="q" id="search-term" class="form-control" placeholder="Cari Istilah" value="{{ request('q') }}">
                    </div>
                    <div class="container-search">
                        <button class="btn d-flex flex-row" type="submit">
                            <img class="img-search" src="{{ asset('assets/images/search-kamus.png') }}" alt="" aria-hidden="true">
                            Cari
                        </button>
                    </div>
                </div>
            </form>
        </section>


        <h5 class="mb-3 teks-cari-huruf">Cari berdasarkan huruf</h5>
        {{-- Menggunakan <nav> untuk navigasi abjad agar lebih semantik --}}
        <nav class="mb-5" aria-label="Navigasi abjad">
            <a href="{{ route('kamus') }}" class="btn btn-outline-warning btn-sm mb-1 huruf huruf-all {{ request('letter') == null ? 'active-letter' : '' }}">
                Semua
            </a>
            @foreach (range('A', 'Z') as $char)
                <a href="{{ route('kamus', ['letter' => $char]) }}" class="btn btn-outline-warning btn-sm mb-1 huruf {{ request('letter') == $char ? 'active-letter' : '' }}">
                    {{ $char }}
                </a>
            @endforeach
        </nav>

        @if($letter)
            <h3 class="mb-3">Kamus Hukum</h3>
            <div class="huruf-terpilih">{{ $letter }}</div>
        @elseif($query)
            <h3 class="mb-3">Hasil Pencarian untuk "{{ $query }}"</h3>
        @else
            <h3 class="mb-3">Kamus Hukum</h3>
        @endif

        @if($kamus->count())
            {{-- Menggunakan <ul> dan <li> untuk daftar istilah, yang lebih semantik daripada <div> --}}
            <ul class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-3 mb-4 list-unstyled">
                @foreach ($kamus as $item)
                    {{-- Mengubah <li> menjadi pembungkus kolom --}}
                    <li class="col">
                        {{-- Mengubah <div> yang dapat diklik menjadi <button> untuk aksesibilitas keyboard --}}
                        <button
                            type="button"
                            class="istilah-item"
                            data-bs-toggle="modal"
                            data-bs-target="#kamusModal"
                            data-istilah="{{ e($item->istilah) }}"
                            data-arti="{{ e($item->arti_istilah) }}"
                            >
                            {{ $item->istilah }}
                        </button>
                    </li>
                @endforeach
            </ul>

            <div class="d-flex justify-content-center">
                {{ $kamus->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>

        @elseif($query || $letter)
            <p class="text-muted">Tidak ditemukan hasil untuk pencarian ini.</p>
        @endif

        {{-- Menambahkan atribut aria-labelledby untuk menghubungkan modal dengan judulnya --}}
        <div class="modal fade" id="kamusModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Judul Awal Modal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <p id="modalArti">Isi arti istilah muncul di sini</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('assets/scripts/kamus-modal.js') }}"></script>
</x-layout>