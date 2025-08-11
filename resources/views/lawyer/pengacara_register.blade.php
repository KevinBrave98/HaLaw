<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Sebagai Pengacara - HaLaw</title>
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    {{-- Arahkan ke file CSS yang sama atau buat yang baru khusus untuk pengacara jika ada perbedaan --}}
    <link rel="stylesheet" href="{{ asset('assets/styles/pengacara_register.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>
    {{-- Menggunakan flexbox untuk layout utama. Menjadi vertikal di mobile, horizontal di layar besar (lg) --}}
    <main class="d-flex flex-column flex-lg-row min-vh-100">

        <section class="split-screen-info d-flex flex-column justify-content-center align-items-center p-5">
            <img src="{{ asset('assets/images/logo_putih.png') }}" alt="Logo HaLaw" class="logo">
            <h2 class="welcome">Selamat Datang Di Halaw</h2>
        </section>

        <section class="split-screen-form d-flex flex-column justify-content-center align-items-center p-4 p-md-5">
            <div class="wrapper">
                <header class="title">
                    <h1>Buat Akun Pengacara</h1>
                </header>

                {{-- PENTING: form action diubah ke 'lawyerregis' dan ditambahkan enctype untuk file upload --}}
                <form action="{{ route('lawyerregis') }}" method="POST" enctype="multipart/form-data" class="mt-4" novalidate>
                    @csrf
                    <div class="wrapper_form">

                        {{-- Nama Lengkap --}}
                        <div class="mb-3">
                            <label for="nama_pengacara" class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_pengacara"
                                class="form-control @error('nama_pengacara') is-invalid @enderror" id="nama_pengacara"
                                value="{{ old('nama_pengacara') }}" required autocomplete="name" placeholder="Masukkan Nama Lengkap Anda">
                            @error('nama_pengacara')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- NIK --}}
                        <div class="mb-3">
                            <label for="nik_pengacara" class="form-label">NIK</label>
                            <input type="text" name="nik_pengacara"
                                class="form-control @error('nik_pengacara') is-invalid @enderror" id="nik_pengacara"
                                value="{{ old('nik_pengacara') }}" required autocomplete="off" placeholder="Masukkan NIK Anda (16 Digit)">
                            @error('nik_pengacara')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nomor Telepon --}}
                        <div class="mb-3">
                            <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                            <input type="tel" name="nomor_telepon"
                                class="form-control @error('nomor_telepon') is-invalid @enderror" id="nomor_telepon"
                                value="{{ old('nomor_telepon') }}" required autocomplete="tel" placeholder="Masukkan Nomor Telepon Anda (11 atau 12 Digit)">
                            @error('nomor_telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Masukkan Email Anda">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kata Sandi --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Kata Sandi</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Masukkan Password Anda" required
                                autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Konfirmasi Kata Sandi --}}
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                id="password_confirmation" required autocomplete="new-password" placeholder="Masukkan Lagia Password Anda">
                        </div>
                        
                        {{-- Unggah KTPA / PKPA --}}
                        <div class="mb-3">
                            <label for="tanda_pengenal" class="form-label">Unggah KTPA / PKPA</label>
                            <input class="form-control @error('tanda_pengenal') is-invalid @enderror" type="file" id="tanda_pengenal" name="tanda_pengenal" required>
                            @error('tanda_pengenal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
        document.addEventListener('DOMContentLoaded', function () {
            const firstInvalidField = document.querySelector('.is-invalid');
            if (firstInvalidField) {
                firstInvalidField.focus();
            }
        });
    </script>
</body>

</html>