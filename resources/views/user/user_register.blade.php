<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Register</title>
     @vite(['resources/js/app.js', 'resources/sass/app.scss'])
     <link rel="stylesheet" href="{{ asset('assets/styles/user_register.css') }}">
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="outer container-fluid">
        <img src="{{ asset('assets/images/bg.jpeg') }}" class="bg-image"></img>
        <div class="container">
        <img src="{{ asset('assets/images/daftar_sebagai_pengguna.jpg') }}" alt="background" class="palu">
        <h2 class="welcome">Selamat Datang Di Halaw</h2>
        <img src="{{ asset('assets/images/logo_putih.png') }}" alt="" class="logo">
            <div class="wrapper">
                <div class="title">
                    <h1>Buat Akun</h1>
                </div>
                <form action="{{ route('userregis') }}" method="POST">
                    @csrf
                    <div class="wrapper_form">
                        <label for="nama_pengguna" class="form-label">Nama Lengkap</label>
                        <input 
                            type="text"
                            name="nama_pengguna" 
                            class="form-control" 
                            id=""
                            value="{{ old('nama_pengguna') }}"
                            required
                        >

                        <label for="nik_pengguna" class="form-label">NIK</label>
                        <input 
                            type="text"
                            name="nik_pengguna" 
                            class="form-control" 
                            value="{{ old('nik_pengguna') }}"
                            required
                        >

                        <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                        <input 
                            type="text" 
                            name="nomor_telepon"
                            class="form-control" 
                            value="{{ old('nomor_telepon') }}"
                            required
                        >

                        <label for="email" class="form-label">Email</label>
                        <input 
                            type="email" 
                            name="email"
                            class="form-control" 
                            value="{{ old('email') }}"
                            required
                        >

                        <label for="password" class="form-label">Kata Sandi</label>
                        <input 
                            type="password" 
                            name="password"
                            class="form-control" 
                            required
                        >

                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                        <input 
                            type="password" 
                            name="password_confirmation"
                            class="form-control" 
                            required
                        >

                    </div>
                    <div class="btn_wrapper">
                        <button type="submit" class="btn btn-outline-warning btn-lg">Daftar</button>
                    </div>
                    <div class="text">
                        <p>Sudah punya akun? <a href="{{ route('login.show') }}">Masuk</a></p>
                    </div>
                    
                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="d-flex flex-column align-items-center justify-content-center div-error">
                                <ul class="px-2 bg-danger box-error">
                                    <p class="my-2 error">{{ $error }}</p>
                                    
                                </ul>
                            </div>
                        @endforeach
                    @endif
                </form>
            </div>
    </div>
</body>
</html>
