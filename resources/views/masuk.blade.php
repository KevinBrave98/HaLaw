<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="masuk.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet" href="assets/styles/masuk.css">
    <title>Halaman Masuk</title>
</head>
<body>
    <div class="outer container-fluid">
        <img src="assets/images/bg_halaman_masuk.jpeg" class="bg-image"></img>
        <div class="container">
            <div class="wrapper">
                <div class="title">
                    <h1>Masuk</h1>
                </div>
                <div class="wrapper_form">
                    <form>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="form-label text-brown fw-semibold">Masuk sebagai</label>
                            <select class="form-select rounded-3 border-secondary" id="exampleFormControlSelect1">
                                <option selected disabled hidden></option>
                                <option value="">Sebagai Pengguna</option>
                                <option value="">Sebagai Pengacara</option>
                            </select>
                        </div>

                        <label for="exampleFormControlInput1" class="form-label text-brown fw-semibold">Email</label>
                        <input type="email" class="form-control" id="exampleFormControlInput1">

                        <label for="exampleFormControlInput1" class="form-label text-brown fw-semibold">Kata Sandi</label>
                        <input type="password" class="form-control" id="exampleFormControlInput1">
                        <div class="forgotPass text-end">
                                <a href="">Lupa kata sandi?</a>
                        </div>
                    </form>
                </div>
                <div class="btn_wrapper">
                     <button type="button" class="btn btn-outline-warning btn-lg">Masuk</button>
                </div>
                <div class="text">
                    <p>Belum memiliki akun? <a href="">Buat Akun</a></p>
                </div>
            </div>
            <img src="assets/images/foto_halaman_masuk.jpeg" alt="background" class="law">
            <img src="assets/images/logo_putih.png" alt="" class="logo">
        </div>
    </div>
</body>
</html>