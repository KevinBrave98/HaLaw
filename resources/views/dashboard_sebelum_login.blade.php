@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/dashboard_sebelum_login.css') }}">
@endpush
<x-layout :title="'Home'">
    <x-slot:title>HaLaw</x-slot:title>
    <div class="relative">
        <div class="dasbor-top">
            <div class="banner-container">
                <div class="banner-img">
                    <img src="{{ asset(path: 'assets/images/cewek-timbangan.png') }}" alt="Gambar Banner">
                </div>
                <div class="banner-text">
                    <div class="banner-title">
                        <p>We Fight<br>for Right</p>
                    </div>
                    <div class="banner-subtitle">
                        <p class="text-light">Kami hadir untuk mendampingi setiap langkahmu mencari keadilan, karena
                            setiap orang berhak dimengerti dan dibela di hadapan hukum.</p>
                    </div>
                    <button class="banner-btn">Konsultasi Sekarang</button>
                </div>
            </div>

            <div class="kelebihan">
                <div class="kelebihan-1">
                    <div class="kelebihan-icon">
                        <img src="{{ asset(path: 'assets/images/el_check.png') }}" alt="Ikon Check">
                    </div>
                    <div class="kelebihan-judul">
                        <p>Praktis</p>
                    </div>
                    <div class="kelebihan-deskripsi">
                        <p>Akses layanan hukum kapan saja dan di mana saja melalui pesan, panggilan suara, atau
                            panggilan video tanpa harus datang langsung.</p>
                    </div>
                </div>

                <div class="vertical-line"></div>

                <div class="kelebihan-2">
                    <div class="kelebihan-icon">
                        <img src="{{ asset(path: 'assets/images/material-symbols_price-change.png') }}"
                            alt="Ikon Shield">
                    </div>
                    <div class="kelebihan-judul">
                        <p>Terjangkau</p>
                    </div>
                    <div class="kelebihan-deskripsi">
                        <p>Biaya konsultasi yang transparan dan bersahabat, sehingga siapa pun dapat mendapatkan bantuan
                            hukum tanpa khawatir soal biaya.</p>
                    </div>
                </div>

                <div class="vertical-line"> </div>

                <div class="kelebihan-3">
                    <div class="kelebihan-icon">
                        <img src="{{ asset(path: 'assets/images/ri_pass-valid-line.png') }}" alt="Ikon Money">
                    </div>
                    <div class="kelebihan-judul">
                        <p>Terpercaya</p>
                    </div>
                    <div class="kelebihan-deskripsi">
                        <p>Didukung oleh pengacara profesional dan berpengalaman, HaLaw menjamin kualitas serta
                            kerahasiaan setiap konsultasi hukum.</p>
                    </div>
                </div>
            </div>

            <div class="dasbor-middle">
                <div class="middle-img">
                    <img src="{{ asset(path: 'assets/images/gambarPalu.png') }}" alt="Gambar Palu Hukum">
                </div>
                <div class="middle-text">
                    <div class="middle-text-top">
                        <p class="middle-judul">Pahami Sebelum Bertindak</p>
                        <p class="middle-deskripsi">Istilah hukum yang jelas adalah langkah pertama menuju keputusan
                            yang benar.</p>
                    </div>
                    <button class="btn-kamus">Telusuri Istilah Hukum</button>
                </div>
            </div>
        </div>

        <div class="dasbor-bottom">
            <p class="dasbor-bottom-judul">Apa Kata Mereka?</p>
            <div class="review-container">
                <div class="review-1">
                    <div class="review-star">
                        <img src="assets/images/Star.png" alt="review bintang 5">
                        <p>“Layanannya cepat dan pengacaranya responsif banget. Cocok buat yang butuh solusi hukum tanpa
                            ribet.”</p>
                    </div>
                    <div class="review-bottomstar">
                        <p>— Dimas</p>
                    </div>
                </div>

                <div class="review-1">
                    <div class="review-star">
                        <img src="assets/images/Star.png" alt="review bintang 5">
                        <p>“Buat saya yang baru pertama kali konsultasi hukum, ini bantu banget. Prosesnya mudah dan
                            nggak bikin stres.”</p>
                    </div>
                    <div class="review-bottomstar">
                        <p>— Laras</p>
                    </div>
                </div>

                <div class="review-1">
                    <div class="review-star">
                        <img src="assets/images/Star.png" alt="review bintang 5">
                        <p>“Saya kira harus mahal untuk dapat bantuan hukum, ternyata di HaLaw terjangkau dan jelas.”
                        </p>
                    </div>
                    <div class="review-bottomstar">
                        <p>— Nadya</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
