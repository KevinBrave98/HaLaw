<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ubah Profil</title>
    <link rel="stylesheet" href="{{ asset('assets/styles/ubah_profil_pengguna.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/navbar_user.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/footer.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+KR:wght@200..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
</head>
<body>
    <x-navbar_user />
    <div class="d-flex justify-content-between bagian-atas">
        <a class="button-back" href="{{ route('profile.show') }}">
            <img src="{{ asset('assets/images/icon-back.png') }}" alt="tombol kembali">
        </a>
        <div class="sapaan-foto d-flex flex-column">
            <h1 class="fs-3">Halo, Nadia Putri</h1>
            <img src="{{ asset('assets/images/foto-profil.png') }}" alt="foto profil">
        </div>
        <div class="d-flex align-item-center justify-content-center">
            <button type="button" class="button-edit">Ubah Profil</button>
        </div>
    </div>

   <div class="form-profil d-flex align-item-center">
        <div class="form-element nama">
            <label for="" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control input-text" value="Nadia Putri">
        </div>
        <div class="form-element nik">
            <label for="" class="form-label">NIK</label>
            <input type="text" class="form-control input-nik" value="12345678901">
        </div>
        <div class="form-element email">
            <label for="" class="form-label">Email</label>
            <input type="email" class="form-control input-text" value="nadiaputri@gmail.com">
        </div>
        <div class="form-element telepon">
            <label for="" class="form-label">Nomor Telepon</label>
            <input type="text" class="form-control input-text" value="087123456789">
        </div>
        <div class="form-element alamat">
            <label for="" class="form-label">Alamat Domisili</label>
            <input type="text" class="form-control input-text" value="Jln. Abcdefghijk, Lmnopqrs, Tuvwxyz, Abcdef, Indonesia 12345">
        </div>
        <div class="form-element gender">
            <label class="form-label">Jenis Kelamin</label>
            <div class="d-flex justify-content-between">

                <div class="form-radio">
                <input class="form-check-input square-radio" type="radio" name="jenis_kelamin" id="laki" value="Laki - Laki">
                <label class="form-check-label" for="laki">Laki – Laki</label>
                </div>

                <div class="form-radio">
                <input class="form-check-input square-radio" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan">
                <label class="form-check-label" for="perempuan">Perempuan</label>
                </div>

                <div class="form-radio">
                <input class="form-check-input square-radio" type="radio" name="jenis_kelamin" id="tidak_jawab" value="Memilih Tidak Menjawab">
                <label class="form-check-label" for="tidak_jawab">Memilih Tidak Menjawab</label>
                </div>

            </div>
        </div>
        <a class="button-save d-flex justify-content-center" href="{{ route('profile.show') }}">
            <button>Simpan Perubahan</button>
        </a>

   </div>
    <x-footer />

</body>
</html>