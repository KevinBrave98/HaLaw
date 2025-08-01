<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Sebagai Pengguna - HaLaw</title>
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet" href="{{ asset('assets/styles/user_register.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    {{-- Menggunakan flexbox untuk layout utama. Menjadi vertikal di mobile, horizontal di layar besar (lg) --}}
    <main class="d-flex flex-column flex-lg-row min-vh-100">

        <!-- Kolom Kiri: Informasi & Gambar Latar -->
        <section class="split-screen-info d-flex flex-column justify-content-center p-5">
            <img src="{{ asset('assets/images/logo_putih.png') }}" alt="Logo HaLaw" class="logo">
            <h2 class="welcome">Selamat Datang Di Halaw</h2>
        </section>

        <!-- Kolom Kanan: Formulir -->
        <section class="split-screen-form d-flex flex-column justify-content-center align-items-center p-4 p-md-5">
            <div class="wrapper">
                <header class="title">
                    <h1>Buat Akun</h1>
                </header>

                <form action="{{ route('userregis') }}" method="POST" class="mt-4" novalidate>
                    @csrf
                    <div class="wrapper_form">
                        
                        <div class="mb-3">
                            <label for="nama_pengguna" class="form-label">Nama Lengkap</label>
                            <input 
                                type="text"
                                name="nama_pengguna" 
                                class="form-control @error('nama_pengguna') is-invalid @enderror" 
                                id="nama_pengguna"
                                value="{{ old('nama_pengguna') }}"
                                required
                                aria-required="true"
                                autocomplete="name"
                                @error('nama_pengguna') aria-describedby="nama_pengguna-error" aria-invalid="true" @enderror
                            >
                            @error('nama_pengguna')
                                <div id="nama_pengguna-error" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nik_pengguna" class="form-label">NIK</label>
                            <input 
                                type="text"
                                name="nik_pengguna" 
                                class="form-control @error('nik_pengguna') is-invalid @enderror" 
                                id="nik_pengguna"
                                value="{{ old('nik_pengguna') }}"
                                required
                                aria-required="true"
                                autocomplete="off"
                                @error('nik_pengguna') aria-describedby="nik_pengguna-error" aria-invalid="true" @enderror
                            >
                            @error('nik_pengguna')
                                <div id="nik_pengguna-error" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                            <input 
                                type="tel" 
                                name="nomor_telepon"
                                class="form-control @error('nomor_telepon') is-invalid @enderror"
                                id="nomor_telepon"
                                value="{{ old('nomor_telepon') }}"
                                required
                                aria-required="true"
                                autocomplete="tel"
                                @error('nomor_telepon') aria-describedby="nomor_telepon-error" aria-invalid="true" @enderror
                            >
                            @error('nomor_telepon')
                                <div id="nomor_telepon-error" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input 
                                type="email" 
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                value="{{ old('email') }}"
                                required
                                aria-required="true"
                                autocomplete="email"
                                @error('email') aria-describedby="email-error" aria-invalid="true" @enderror
                            >
                            @error('email')
                                <div id="email-error" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Kata Sandi</label>
                            <input 
                                type="password" 
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                required
                                aria-required="true"
                                autocomplete="new-password"
                                @error('password') aria-describedby="password-error" aria-invalid="true" @enderror
                            >
                             @error('password')
                                <div id="password-error" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                            <input 
                                type="password" 
                                name="password_confirmation"
                                class="form-control"
                                id="password_confirmation"
                                required
                                aria-required="true"
                                autocomplete="new-password"
                            >
                        </div>

                    </div>

                    <div class="btn_wrapper mt-4">
                        <button type="submit" class="btn btn-warning btn-lg w-100">Daftar</button>
                    </div>

                    <div class="text mt-4 text-center">
                        <p>Sudah punya akun? <a href="{{ route('login.show') }}">Masuk</a></p>
                    </div>
                    
                </form>
            </div>
        </section>
        
    </main>
    <script>
        // Script untuk auto-focus ke input pertama yang error untuk UX yang lebih baik
        document.addEventListener('DOMContentLoaded', function() {
            const firstInvalidField = document.querySelector('.is-invalid');
            if (firstInvalidField) {
                firstInvalidField.focus();
            }
        });
    </script>
</body>
</html>
