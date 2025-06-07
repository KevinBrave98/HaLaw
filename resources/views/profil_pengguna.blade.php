<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profil Pengguna</title>
    <link rel="stylesheet" href="{{ asset('assets/styles/profil_pengguna.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/navbar_user.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/footer.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+KR:wght@200..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
</head>
<body>
     <x-navbar_user />
     @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif
    <div class="d-flex justify-content-between bagian-atas">
        <div class="sapaan-foto d-flex flex-column">
            <h1 class="fs-3">Halo, {{ $user->nama_pengguna }}</h1>
            <img class="foto-profil" src="{{ $user->foto_pengguna ? asset('storage/' . $user->foto_pengguna) : asset('assets/images/foto-profil.png') }}" alt="foto profil">
        </div>
        <div class="d-flex justify-content-center">
            <button type="button" class="button-edit" onclick="window.location.href='{{ route('profile.edit') }}'">Ubah Profil</button>
        </div>
    </div>

   <div class="form-profil d-flex align-item-center">
        <div class="form-element nama">
            <label for="" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control input-nama" value="{{ $user->nama_pengguna }}" readonly>
        </div>
        <div class="form-element nik">
            <label for="" class="form-label">NIK</label>
            <input type="text" class="form-control input-nik" value="{{ $user->nik_pengguna }}" readonly>
        </div>
        <div class="form-element email">
            <label for="" class="form-label">Email</label>
            <input type="email" class="form-control input-email" value="{{ $user->email }}" readonly>
        </div>
        <div class="form-element telepon">
            <label for="" class="form-label">Nomor Telepon</label>
            <input type="text" class="form-control input-telepon" value="{{ $user->nomor_telepon }}" readonly>
        </div>
        <div class="form-element alamat">
            <label for="" class="form-label">Alamat Domisili</label>
            <input type="text" class="form-control input-alamat" value=" " readonly>
        </div>
        <div class="form-element gender">
            <label for="" class="form-label">Jenis Kelamin</label>
            <input type="text" class="form-control input-gender" value="{{ $user->jenis_kelamin }}" readonly>
        </div>
        <div class="button-exit d-flex justify-content-center">
            <button onclick="window.location.href='{{ route('profile.exit') }}'">Keluar Akun</button>
        </div>

   </div>
    <x-footer />

    
</body>
</html>