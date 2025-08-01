<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Masuk - HaLaw</title>

    {{-- Memuat font dari Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@400;700&display=swap" rel="stylesheet">

    {{-- Memuat aset (CSS & JS) menggunakan Vite --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/styles/masuk.css') }}">
</head>

<body>
    {{-- Latar belakang utama halaman --}}
    <div class="page-background"></div>

    {{-- Kontainer utama yang akan berada di tengah halaman --}}
    <main class="login-container d-flex flex-column flex-lg-row">

        <section class="form-panel d-flex flex-column justify-content-center align-items-center">
            <div class="form-wrapper">
                <header>
                    <h1>Masuk</h1>
                </header>

                <form action="{{ $dynamic_login['form_action'] }}" method="POST" id="form_masuk" class="mt-4" novalidate>
                    @csrf

                    {{-- Masuk Sebagai --}}
                    <div class="mb-4">
                        <label for="pilih_user" class="form-label">Masuk sebagai</label>
                        <select name="pilih_user" class="form-select @error('pilih_user') is-invalid @enderror" id="pilih_user">
                            {{-- PERINGATAN: Menggunakan {!! !!} bisa berisiko XSS. --}}
                            {{-- Pastikan data dari $dynamic_login['selected_option'] aman. --}}
                            {!! $dynamic_login['selected_option'] !!}
                        </select>
                        @error('pilih_user')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kata Sandi --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required>
                         @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Lupa Kata Sandi --}}
                    <div class="text-end mb-4">
                        <a href="{{ $dynamic_login['forgot_password'] }}" class="forgot-password-link">Lupa kata sandi?</a>
                    </div>
                    
                    {{-- Tombol Masuk --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-login">Masuk</button>
                    </div>

                </form>

                <div class="text-center mt-5">
                    <p class="register-link-text">Belum memiliki akun? <a href="{{ route('register.show') }}">Buat Akun</a></p>
                </div>
            </div>
        </section>

        <section class="image-panel">
            <img src="{{ asset('assets/images/logo_putih.png') }}" alt="Logo HaLaw" class="logo">
        </section>

    </main>

    @routes
    <script src="{{ asset('assets/scripts/masuk.js') }}"></script>
    <script>
        // Script untuk auto-focus ke input pertama yang error
        document.addEventListener('DOMContentLoaded', function () {
            const firstInvalidField = document.querySelector('.is-invalid');
            if (firstInvalidField) {
                firstInvalidField.focus();
            }
        });
    </script>
</body>

</html>