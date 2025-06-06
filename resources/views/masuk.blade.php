<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="masuk.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet" href="{{ asset('assets/styles/masuk.css')}}">
    <title>Halaman Masuk</title>
</head>

<body>
    <div class="outer container-fluid">
        <img src="{{ asset('assets/images/bg_halaman_masuk.jpeg')}}" class="bg-image"></img>
        <div class="container">
            <div class="wrapper">
                <div class="title">
                    <h1>Masuk</h1>
                </div>
                <div class="wrapper_form">
                    <form action="{{ $dynamic_login['form_action'] }}" method="POST" id="form_masuk">
                        @csrf
                        <div class="form-group">
                            <label for="pilih_user" class="form-label text-brown fw-semibold">Masuk sebagai</label>
                            <select name="pilih_user" class="form-select rounded-3 border-secondary"
                                id="pilih_user">
                                {!! $dynamic_login['selected_option'] !!}
                            </select>
                        </div>

                        <label for="email" class="form-label text-brown fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" required>

                        <label for="password" class="form-label text-brown fw-semibold">Kata Sandi</label>
                        <input type="password" name="password" class="form-control" id="kata_sandi" required>
                        <div class="forgotPass text-end">
                            <a href="{{ route('password.request') }}">Lupa kata sandi?</a>
                        </div>
                        <div class="btn_wrapper mt-4">
                            <button type="submit" class="btn btn-outline-warning btn-lg">Masuk</button>
                        </div>
                    </form>
                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="text mt-5">
                    <p>Belum memiliki akun? <a href="{{ route('register.show') }}">Buat Akun</a></p>
                </div>
            </div>
            <img src="{{ asset('assets/images/foto_halaman_masuk.jpeg')}}" alt="background" class="law">
            <img src="{{ asset('assets/images/logo_putih.png')}}" alt="" class="logo">
        </div>
    </div>
    <script src="{{ asset('assets/scripts/masuk.js')}}"></script>
</body>

</html>
