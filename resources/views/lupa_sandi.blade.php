<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/styles/lupa_sandi.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <title>Lupa Kata Sandi</title>
</head>

<body>
    <div class="back-logo">
        <a class="back" href="{{ route('login.show') }}">
                <img src="{{ asset('assets/images/icon-back.png') }}" alt="tombol kembali">
        </a>
        <div class="logo">
            <img src="{{ asset('assets/images/logo_hitam.png') }}" alt="">
        </div>
    </div>
    <div class="isi">
        <div class="judul">
            <h1>Lupa Kata Sandi</h1>
        </div>
        <div class="box-lupa">
            <h3>Silahkan masukan email yang sebelumnya terdaftar, link reset sandi baru akan dikirim ke emailmu</h3>
            <form action="{{ $reset_password }}" method="POST">
                @csrf
                <div class="form-email">
                    <label for="">Email terdaftar</label>
                    <input type="email" name="email" required>
                </div>
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
                <div class="button-lanjut">
                    <button type="submit">Lanjut</button>
                </div>
            </form>
            @if (session('status'))
                <div class="alert-success">
                    {{ session('status') }}
                </div>
            @endif
    
            
            <p>Kembali ke halaman <a href="{{ route('login.show') }}">Masuk</a> atau <a href="{{ route('register.show') }}">Daftar</a></p>
    
        </div>

    </div>
</body>

</html>
