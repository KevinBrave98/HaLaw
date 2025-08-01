@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/dashboard_sebelum_login.css') }}">
@endpush

<x-layout :title="'Home'">
    <x-slot:title>HaLaw</x-slot:title>
    <main id="main-content">
        <section class="dasbor-top" role="region" aria-label="Banner">
            <figure class="banner-container" tabindex="0">
                <div class="banner-img">
                    <img src="{{ asset(path: 'assets/images/cewek-timbangan.png') }}" alt="Ilustrasi perempuan dengan timbangan hukum">
                </div>
                <figcaption class="banner-text">
                    <h1 class="banner-title">
                        <p>We Fight<br>for Right</p>
                    </h1>
                    <p class="banner-subtitle text-light">
                        Kami hadir untuk mendampingi setiap langkahmu mencari keadilan, karena setiap orang berhak dimengerti dan dibela di hadapan hukum.
                    </p>
                    <button class="banner-btn" onclick="window.location.href = '/daftar'">Konsultasi Sekarang</button>
                </figcaption>
            </figure>

            <section class="kelebihan" role="region" aria-label="Keunggulan Layanan HaLaw">
                <article class="kelebihan-1" tabindex="0">
                    <img class="kelebihan-icon" src="{{ asset(path: 'assets/images/el_check.png') }}" alt="Ikon tanda centang sebagai simbol kepraktisan">
                    <h2 class="kelebihan-judul">Praktis</h2>
                    <p class="kelebihan-deskripsi">Akses layanan hukum kapan saja dan di mana saja melalui pesan, panggilan suara, atau panggilan video tanpa harus datang langsung.</p>
                </article>

                <div class="vertical-line" aria-hidden="true"></div>

                <article class="kelebihan-2" tabindex="0">
                    <img class="kelebihan-icon" src="{{ asset(path: 'assets/images/material-symbols_price-change.png') }}" alt="Ikon simbol harga sebagai lambang keterjangkauan">
                    <h2 class="kelebihan-judul">Terjangkau</h2>
                    <p class="kelebihan-deskripsi">Biaya konsultasi yang transparan dan bersahabat, sehingga siapa pun dapat mendapatkan bantuan hukum tanpa khawatir soal biaya.</p>
                </article>

                <div class="vertical-line" aria-hidden="true"></div>

                <article class="kelebihan-3" tabindex="0">
                    <img class="kelebihan-icon" src="{{ asset(path: 'assets/images/ri_pass-valid-line.png') }}" alt="Ikon dokumen hukum valid sebagai simbol kepercayaan">
                    <h2 class="kelebihan-judul">Terpercaya</h2>
                    <p class="kelebihan-deskripsi">Didukung oleh pengacara profesional dan berpengalaman, HaLaw menjamin kualitas serta kerahasiaan setiap konsultasi hukum.</p>
                </article>
            </section>

            <section class="dasbor-middle" role="region" aria-label="Akses Kamus Hukum">
                <figure class="middle-img" tabindex="0">
                    <img src="{{ asset(path: 'assets/images/gambarPalu.png') }}" alt="Gambar palu hukum sebagai simbol keadilan">
                </figure>
                <div class="middle-text">
                    <header class="middle-text-top" tabindex="0">
                        <h2 class="middle-judul">Pahami Sebelum Bertindak</h2>
                        <p class="middle-deskripsi">Istilah hukum yang jelas adalah langkah pertama menuju keputusan yang benar.</p>
                    </header>
                    <button class="btn-kamus" onclick="window.location.href = '/kamus'">Telusuri Istilah Hukum</button>
                </div>
            </section>
        </section>

        <section class="dasbor-bottom" role="region" aria-label="Ulasan Pengguna">
            <h2 class="dasbor-bottom-judul">Apa Kata Mereka?</h2>
            <div class="review-container">
                <blockquote class="review-1" tabindex="0">
                    <div class="review-star">
                        <img src="assets/images/Star.png" alt="Ikon bintang lima">
                        <p>“Layanannya cepat dan pengacaranya responsif banget. Cocok buat yang butuh solusi hukum tanpa ribet.”</p>
                    </div>
                    <footer class="review-bottomstar">— Dimas</footer>
                </blockquote>

                <blockquote class="review-1" tabindex="0">
                    <div class="review-star">
                        <img src="assets/images/Star.png" alt="Ikon bintang lima">
                        <p>“Buat saya yang baru pertama kali konsultasi hukum, ini bantu banget. Prosesnya mudah dan nggak bikin stres.”</p>
                    </div>
                    <footer class="review-bottomstar">— Laras</footer>
                </blockquote>

                <blockquote class="review-1" tabindex="0">
                    <div class="review-star">
                        <img src="assets/images/Star.png" alt="Ikon bintang lima">
                        <p>“Saya kira harus mahal untuk dapat bantuan hukum, ternyata di HaLaw terjangkau dan jelas.”</p>
                    </div>
                    <footer class="review-bottomstar">— Nadya</footer>
                </blockquote>
            </div>
        </section>
    </main>
</x-layout>
