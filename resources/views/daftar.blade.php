<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar</title>
    <link rel="stylesheet" href="assets/styles/daftar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+KR:wght@200..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="logo-halaw">
        <img src="{{ asset('assets/images/logo_halaw.png') }}" alt="logo">
    </div>

    <div class="text-daftar">
        <h2>Selamat Datang Di Halaw</h2>
        <h3>Daftar sebagai...</h3>
    </div>

    <div class="container-pilihan">
        <div class="box-pengguna">
            <img src="{{ asset('assets/images/icon-pengguna.png') }}" alt="icon pengguna">
            <h3>Pengguna</h3>
            <div class="list-pengguna">
                <li>Konsultasi hukum via chat, telepon, atau panggilan video</li>
                <li>Akses ke pengacara profesional dengan harga transparan</li>
                <li>Fitur pencarian pengacara berdasarkan kebutuhan (perdata, pidana, bisnis, dll)</li>
            </div>
        </div>
        <div class="box-pengguna">
            <img src="{{ asset('assets/images/icon-pengacara.png') }}" alt="icon pengacara">
            <h3>Pengacara</h3>
            <div class="list-pengguna">
                <li>Terima permintaan konsultasi dari pengguna langsung</li>
                <li>Kelola profil, spesialisasi, dan harga jasa sendiri</li>
                <li>Atur jam aktif dan status online/offline</li>
            </div>

        </div>
    </div>
    
</body>
</html>