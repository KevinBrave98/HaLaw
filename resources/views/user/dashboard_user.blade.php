@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/dashboard_user.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/search_pengacara.css') }}">
@endpush
<x-layout_user :title="'Halaw - Dasbor Pengguna'">
    <main id="main-content">
        {{-- Menggunakan <section> sebagai pembungkus yang lebih semantik dan menambahkan id untuk "skip to content" --}}
        <section class="content">

            {{-- Pesan selamat datang lebih cocok menggunakan <p> daripada heading --}}
            <p class="username">Hallo {{ $pengguna->nama_pengguna }}</p>

            {{-- Menggunakan <h2> karena ini adalah judul bagian, bukan judul utama seluruh halaman (H1) --}}
            <h2 class="rekomendasi">Rekomendasi Pengacara</h2>

            <div class="scroll-wrapper">
                {{-- Menggunakan <ul> untuk daftar yang dapat di-scroll agar lebih semantik --}}
                <ul class="scroll-container">
                    @foreach ($pengacara as $lawyer_card)
                        {{-- Setiap kartu adalah item dalam daftar (<li>) --}}
                        <li>
                            {{-- <article> adalah tag yang tepat untuk komponen mandiri seperti kartu --}}
                            <article class="lawyer-card">
                                <div class="image_wrapper">
                                    @if ($lawyer_card->foto_pengacara == null)
                                        {{-- alt text lebih baik generik jika gambar fallback --}}
                                        <img src="{{ asset('assets/images/foto-profil-default.jpg') }}"
                                            alt="Foto Pengacara" class="lawyer-image">
                                    @else
                                        <img src="{{ asset('storage/' . $lawyer_card->foto_pengacara) }}"
                                            alt="Foto {{ $lawyer_card->nama_pengacara }}" class="lawyer-image">
                                    @endif
                                </div>

                                <div class="content-wrapper">
                                    <div class="content-detail">
                                        {{-- Judul di dalam kartu menggunakan <h3>, satu level di bawah <h2> "Rekomendasi" --}}
                                        <h3 class="nama">{{ $lawyer_card->nama_pengacara }}</h3>
                                        <p class="spesialisasi">
                                            @if ($lawyer_card->spesialisasis && $lawyer_card->spesialisasis->count() > 0)
                                                {{ Str::limit($lawyer_card->spesialisasis->pluck('nama_spesialisasi')->implode(', '), 50, '...') }}
                                            @else
                                                Tidak Ada Spesialisasi
                                            @endif
                                        </p>

                                        {{-- Badges juga merupakan daftar, jadi gunakan <ul> --}}
                                        <ul class="badges">
                                            @if ($lawyer_card->chat)
                                                <li>
                                                    {{-- SVG hanya dekoratif, jadi disembunyikan dari screen reader --}}
                                                    <i class="bi bi-chat-left-text-fill"></i>
                                                    {{-- Pesan --}}
                                                </li>
                                            @endif

                                            @if ($lawyer_card->voice_chat)
                                                <li>
                                                    <i class="bi bi-telephone-fill"></i>
                                                    {{-- Panggilan suara --}}
                                                </li>
                                            @endif

                                            @if ($lawyer_card->video_call)
                                                <li>
                                                    <i class="bi bi-camera-video-fill"></i>
                                                    {{-- Panggilan Video --}}
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="price-detail">
                                        <div class="harga">Rp.
                                            {{ number_format($lawyer_card->tarif_jasa, 0, ',', '.') }}
                                        </div>
                                        {{-- Menambahkan aria-label yang deskriptif untuk aksesibilitas --}}
                                        <a href="{{ route('detail.pengacara', $lawyer_card->nik_pengacara) }}"
                                            class="btn-detail"
                                            aria-label="Lihat Detail untuk {{ $lawyer_card->nama_pengacara }}. 
                                            Spesialisasi: Hukum perdata, Hukum pidana, Litigasi & Sengketa. 
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
            </div>
        </section>

        {{-- Menggunakan <section> sebagai pembungkus utama yang lebih semantik daripada <div> --}}
        <section class="search-wrapper mx-auto mt-5 d-flex flex-column align-items-center"
            aria-labelledby="search-lawyer-heading">

            {{-- Menggunakan <h2> untuk judul agar sesuai dengan standar heading dan SEO --}}
            <h2 class="search-header" id="search-lawyer-heading">Telusuri Pengacara</h2>

            <div class="search-bar p-4 rounded-4 d-flex align-items-center">
                <x-search_pengacara :hargaMin="$harga_min" :hargaMax="$harga_max"></x-search_pengacara>
            </div>

        </section>

        <section class="dasbor-middle" role="region" aria-label="Akses Kamus Hukum">
            <figure class="middle-img" tabindex="0">
                <img src="{{ asset(path: 'assets/images/gambarPalu.png') }}"
                    alt="Gambar palu hukum sebagai simbol keadilan">
            </figure>
            <div class="middle-text">
                <header class="middle-text-top" tabindex="0">
                    <h2 class="middle-judul">Pahami Sebelum Bertindak</h2>
                    <p class="middle-deskripsi">Istilah hukum yang jelas adalah langkah pertama menuju keputusan yang
                        benar.
                    </p>
                </header>
                <button class="btn-kamus" onclick="window.location.href = '/kamus'">Telusuri Istilah Hukum</button>
            </div>
        </section>
    </main>
    <script>
        const scrollContainer = document.querySelector('.scroll-wrapper');
        let isDown = false;
        let startX;
        let scrollLeft;

        scrollContainer.addEventListener('mousedown', (e) => {
            isDown = true;
            scrollContainer.classList.add('active');
            startX = e.pageX - scrollContainer.offsetLeft;
            scrollLeft = scrollContainer.scrollLeft;
        });

        scrollContainer.addEventListener('mouseleave', () => {
            isDown = false;
            scrollContainer.classList.remove('active');
        });

        scrollContainer.addEventListener('mouseup', () => {
            isDown = false;
            scrollContainer.classList.remove('active');
        });

        scrollContainer.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - scrollContainer.offsetLeft;
            const walk = (x - startX) * 2; // *2 = scroll speed
            scrollContainer.scrollLeft = scrollLeft - walk;
        });
    </script>
    <script src="{{ asset('assets/scripts/search_pengguna.js') }}"></script>
</x-layout_user>
