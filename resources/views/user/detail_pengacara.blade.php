@push('css')
    {{-- Pastikan path CSS ini sesuai dengan struktur proyek Anda --}}
    <link rel="stylesheet" href="{{ asset('assets/styles/detail_pengacara.css') }}">
@endpush

<x-layout_user :title="'Detail Pengacara - ' . $pengacara->nama_pengacara">

    {{-- Gunakan <main> untuk konten utama halaman --}}
    <main class="container-detail-pengacara">
        <a href="{{ route('search.pengacara.view') }}" class="button-back" aria-label="Kembali ke halaman pencarian">
            <img src="{{ asset('assets/images/icon-back.png') }}" alt="">
        </a>
        <header class="profil-header">
            {{-- <div class="profil-banner"> --}}
            {{-- </div> --}}
            <div class="profil-info-utama">
                <img src="{{ $pengacara->foto_pengacara ? asset('storage/' . $pengacara->foto_pengacara) : asset('assets/images/foto-profil-default.jpg') }}"
                    alt="Foto profil {{ $pengacara->nama_pengacara }}" class="profil-pic">
                {{-- Gunakan <h1> untuk nama pengacara sebagai judul utama halaman --}}
                <h1 class="nama-pengacara">{{ $pengacara->nama_pengacara }}</h1>
                <p class="jenis-kelamin">{{ $pengacara->jenis_kelamin }}</p>
            </div>
        </header>

        {{-- Gunakan <article> untuk konten yang mandiri dan lengkap seperti profil --}}
        <article class="profil-content">

            {{-- Setiap bagian informasi dibungkus dalam <section> dengan heading yang jelas --}}
            <section class="info-section">
                <h2 class="section-title">Lokasi Tempat Kerja</h2>
                @if ($pengacara->lokasi)
                    <p>{{ $pengacara->lokasi }}</p>
                @else
                    <p>-</p>
                @endif
            </section>



            <section class="info-section">
                <h2 class="section-title">Spesialisasi</h2>
                {{-- Menggunakan <p> untuk menampilkan teks, bukan input field --}}
                <p class="spesialisasi">
                    @if ($spesialisasi->count() > 0)
                        {{ $spesialisasi->pluck('nama_spesialisasi')->implode(', ') }}
                    @else
                        Tidak Ada Spesialisasi
                    @endif
                </p>
            </section>



            <section class="info-section">
                <h2 class="section-title">Informasi Pendidikan</h2>
                {{-- Jika data pendidikan bisa memiliki beberapa baris, gunakan <p> dengan style CSS `white-space: pre-line`
                     agar baris baru dari database tetap ditampilkan. Atau, idealnya simpan sebagai JSON dan loop di sini. --}}
                @if ($pengacara->pendidikan)
                    <p style="white-space: pre-line;">{{ $pengacara->pendidikan }}</p>
                @else
                    <p>-</p>
                @endif
            </section>



            <section class="info-section">
                <h2 class="section-title">Pengalaman Kerja</h2>
                {{-- Pengalaman kerja lebih cocok ditampilkan sebagai daftar.
                     Tag <p> dengan `white-space: pre-line` digunakan sebagai solusi praktis
                     jika data di database adalah teks tunggal dengan baris baru. --}}
                @if ($pengacara->pengalaman_bekerja)
                    <p style="white-space: pre-line;">{{ $pengacara->pengalaman_bekerja }}</p>
                @else
                    <p>-</p>
                @endif
                {{-- <p style="white-space: pre-line;">{{ $pengacara->pengalaman_bekerja }}</p> --}}
            </section>



            <section class="info-section">
                <h2 class="section-title">Durasi Pengalaman Kerja</h2>
                @if ($pengacara->durasi_pengalaman)
                    <p>{{ $pengacara->durasi_pengalaman }}</p>
                @else
                    <p>-</p>
                @endif
                {{-- <p>{{ $pengacara->durasi_pengalaman }}</p> --}}
            </section>



            <section class="info-section">
                <h2 class="section-title">Ketersediaan Layanan</h2>
                {{-- Gunakan <ul> untuk daftar layanan agar lebih semantik --}}
                <ul class="layanan-list">
                    {{-- class 'tersedia' / 'tidak-tersedia' bisa digunakan untuk styling (misal: warna teks atau ikon) --}}
                    <li class="{{ $pengacara->chat ? 'tersedia' : 'tidak-tersedia' }}">
                        {!! $pengacara->chat ? '&#10004;' : '&#10006;' !!} Pesan
                    </li>
                    <li class="{{ $pengacara->voice_chat ? 'tersedia' : 'tidak-tersedia' }}">
                        {!! $pengacara->voice_chat ? '&#10004;' : '&#10006;' !!} Panggilan Suara
                    </li>
                    <li class="{{ $pengacara->video_call ? 'tersedia' : 'tidak-tersedia' }}">
                        {!! $pengacara->video_call ? '&#10004;' : '&#10006;' !!} Panggilan Video
                    </li>
                </ul>
            </section>

        </article>

        <section class="profil-harga">
            <div class="tarif-section">
                <h3 class="tarif-title">Tarif Jasa</h3>
                <p class="tarif-harga">Rp{{ number_format($pengacara->tarif_jasa, 2, ',', '.') }}</p>
            </div>
            {{-- Gunakan <a> untuk navigasi/link, bukan <button> dengan JS. Ini lebih baik untuk SEO & aksesibilitas. --}}
            <a href="{{ route('pembayaran.pengacara', ['id' => $pengacara->nik_pengacara]) }}"
                class="button-konsultasi">
                Konsultasi Sekarang
            </a>
        </section>

    </main>
</x-layout_user>
