<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/styles/dashboard_sebelum_login.css">

    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet" href="assets/styles/navbar_sebelum_login.css">
    <link rel="stylesheet" href="{{ asset('assets/styles/footer.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+KR:ital,wght@0,100..900;1,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="relative">
        <x-navbar_sebelum_login></x-navbar_sebelum_login>

        <div class="dasbor-top">
            <div class="banner-container">
                <div class="banner-img">
                    <img src="assets/images/cewek-timbangan.png" alt="Gambar Banner">
                </div>
                <div class="banner-text">
                    <div class="banner-title">
                        <p>We Fight<br>for Right</p>
                    </div>
                    <div class="banner-subtitle">
                        <p class="text-light">Kami hadir untuk mendampingi setiap langkahmu mencari keadilan, karena setiap orang berhak dimengerti dan dibela di hadapan hukum.</p>
                    </div>
                    <button class="banner-btn">Konsultasi Sekarang</button>
                </div>
            </div>

            <div class="kelebihan">
                <div class="kelebihan-1">
                    <div class="kelebihan-icon">
                        <img src="images/el_check.png" alt="Ikon Check">
                    </div>
                    <div class="kelebihan-judul">
                        <p>Praktis</p>
                    </div>
                    <div class="kelebihan-deskripsi">
                        <p>Akses layanan hukum kapan saja dan di mana saja melalui pesan, panggilan suara, atau panggilan video tanpa harus datang langsung.</p>
                    </div>
                </div>

                <div class="vertical-line"></div>
                
                <div class="kelebihan-2">
                    <div class="kelebihan-icon">
                        <img src="assets/images/material-symbols_price-change.png" alt="Ikon Shield">
                    </div>
                    <div class="kelebihan-judul">
                        <p>Terjangkau</p>
                    </div>
                    <div class="kelebihan-deskripsi">
                    <p>Biaya konsultasi yang transparan dan bersahabat, sehingga siapa pun dapat mendapatkan bantuan hukum tanpa khawatir soal biaya.</p>
                    </div>
                </div>

                <div class="vertical-line"> </div>

                <div class="kelebihan-3">
                    <div class="kelebihan-icon">
                        <img src="assets/images/ri_pass-valid-line.png" alt="Ikon Money">
                    </div>
                    <div class="kelebihan-judul">
                        <p>Terpercaya</p>
                    </div>
                    <div class="kelebihan-deskripsi">
                        <p>Didukung oleh pengacara profesional dan berpengalaman, HaLaw menjamin kualitas serta kerahasiaan setiap konsultasi hukum.</p>
                    </div>
                </div>
            </div>
        
            <div class="dasbor-middle">
                <div class="middle-img">
                    <img src="assets/images/gambarPalu.png" alt="Gambar Palu Hukum">
                </div>
                <div class="middle-text">
                    <div class="middle-text-top">
                        <p class="middle-judul">Pahami Sebelum Bertindak</p>
                        <p class="middle-deskripsi">Istilah hukum yang jelas adalah langkah pertama menuju keputusan yang benar.</p>
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
                        <p>“Layanannya cepat dan pengacaranya responsif banget. Cocok buat yang butuh solusi hukum tanpa ribet.”</p>
                    </div>
                    <div class="review-bottomstar">
                        <p>— Dimas</p>
                    </div>
                </div>

                <div class="review-1">
                    <div class="review-star">
                        <img src="assets/images/Star.png" alt="review bintang 5">
                        <p>“Buat saya yang baru pertama kali konsultasi hukum, ini bantu banget. Prosesnya mudah dan nggak bikin stres.”</p>    
                    </div>
                    <div class="review-bottomstar">
                        <p>— Laras</p>
                    </div>
                </div>

                <div class="review-1">
                    <div class="review-star">
                        <img src="assets/images/Star.png" alt="review bintang 5">
                        <p>“Saya kira harus mahal untuk dapat bantuan hukum, ternyata di HaLaw terjangkau dan jelas.”</p>
                    </div>
                    <div class="review-bottomstar">
                        <p>— Nadya</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-footer></x-footer>
</body>
</html>