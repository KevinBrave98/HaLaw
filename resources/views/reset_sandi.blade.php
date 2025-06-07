<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi</title>
    <link rel="stylesheet" href="{{ asset('assets/styles/reset_sandi.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
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
            <h1>Reset Kata Sandi</h1>
        </div>
        <div class="box-reset">
            <h3>Masukkan kata sandi baru untuk akunmu</h3>

            {{-- Error Handling --}}
            @if ($errors->any())
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ $reset_role }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="form-group">
                    <label for="password">Kata Sandi Baru</label>
                    <input type="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" required>
                </div>

                <div class="button-submit">
                    <button type="submit">Reset Sandi</button>
                </div>
            </form>

            <p>Kembali ke halaman <a href="{{ route('login.show') }}">Masuk</a></p>
        </div>
    </div>
</body>

</html>
