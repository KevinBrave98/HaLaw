<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - HaLaw</title>
    {{-- Pastikan path ke file CSS ini benar --}}
    <link rel="stylesheet" href="{{ asset('assets/styles/daftar.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+KR:wght@200..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <main>
        <header>
            <div class="logo-halaw">
                {{-- Tautan ini sebaiknya mengarah ke halaman utama --}}
                <a href="/" aria-label="Kembali ke halaman utama">
                    <img src="{{ asset('assets/images/logo_halaw.png') }}" alt="Logo HaLaw">
                </a>
            </div>
            {{-- Mengembalikan div dengan class 'text-daftar' untuk mencocokkan CSS --}}
            <div class="text-daftar">
                <h1>Selamat Datang Di HaLaw</h1>
                <h2>Daftar sebagai...</h2>
            </div>
        </header>

        <div class="container-pilihan">
            {{-- Atribut aria-label sudah menangani konteks "Daftar sebagai Pengguna" dengan baik --}}
            <a href="{{ route('userregis.show') }}" aria-label="Daftar sebagai Pengguna">
                <section class="box-pengguna" role="region" aria-labelledby="user-heading">
                    <img src="{{ asset('assets/images/icon-pengguna.png') }}" alt="">
                    <h3 id="user-heading">Pengguna</h3>
                    
                    {{-- Teks ini hanya akan dibaca oleh screen reader --}}
                    <p class="sr-only">Fitur-fiturnya adalah:</p>
                    
                    <ul class="list-pengguna">
                        <li>Konsultasi hukum via chat, telepon, atau panggilan video</li>
                        <li>Akses ke pengacara profesional dengan harga transparan</li>
                        <li>Fitur pencarian pengacara berdasarkan kebutuhan (perdata, pidana, bisnis, dll)</li>
                    </ul>
                </section>
            </a>

            <a href="{{ route('lawyerregis.show') }}" aria-label="Daftar sebagai Pengacara">
                <section class="box-pengguna" role="region" aria-labelledby="lawyer-heading">
                    <img src="{{ asset('assets/images/icon-pengacara.png') }}" alt="">
                    <h3 id="lawyer-heading">Pengacara</h3>

                    {{-- Teks ini hanya akan dibaca oleh screen reader --}}
                    <p class="sr-only">Fitur-fiturnya adalah:</p>

                    <ul class="list-pengguna">
                        <li>Terima permintaan konsultasi dari pengguna langsung</li>
                        <li>Kelola profil, spesialisasi, dan harga jasa sendiri</li>
                        <li>Atur jam aktif dan status online/offline</li>
                    </ul>
                </section>
            </a>
        </div>
    </main>

</body>
</html>
