<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pengacara Register</title>
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet" href="{{ asset('assets/styles/pengacara_register.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="outer container-fluid">
        <img src="{{ asset('assets/images/bg.jpeg') }}" class="bg-image"></img>
        <div class="container">
            <img src="{{ asset('assets/images/daftar_pengacara.jpeg') }}" alt="background" class="palu">
            <h2 class="welcome">Selamat Datang Di Halaw</h2>
            <img src="{{ asset('assets/images/logo_putih.png') }}" alt="" class="logo">
            <div class="wrapper">
                <div class="title">
                    <h1>Buat Akun</h1>
                </div>
                <div class="wrapper_form">
                    <form action="{{ route('lawyerregis.regis') }}" method="POST">
                        @csrf
                        <label for="nama_pengacara" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_pengacara" name="nama_pengacara">

                        <label for="nik_pengacara" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="nik_pengacara" name="nik_pengacara">

                        <label for="email" class="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email">

                        <label for="password" class="form-label">Kata Sandi</label>
                        <input type="password" class="form-control" id="password" name="password">

                        <label for="formFile" class="form-label">Unggah KTPA / PKPA</label>
                        <input class="form-control" type="file" id="formFile">
                        <div class="btn_wrapper mt-4">
                            <button type="submit" class="btn btn-outline-warning btn-lg">Daftar</button>
                        </div>
                    </form>
                </div>
                <div class="text">
                    <p>Sudah punya akun? <a href="{{ route('login.show') }}">Masuk</a></p>
                </div>
            </div>
        </div>
</body>

</html>
