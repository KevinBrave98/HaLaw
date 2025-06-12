<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profil Pengguna</title>
     <link rel="stylesheet" href="{{ asset('assets/styles/navbar_lawyer.css') }}">
    <link rel="stylesheet" href="assets/styles/profil_pengacara.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+KR:wght@200..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
</head>
<body>
    <x-navbar_lawyer></x-navbar_lawyer>
    <div class="d-flex justify-content-between bagian-atas">
        <div class="sapaan-foto d-flex flex-column">
            <h1 class="fs-3">Halo, Fajar Nugroho, S. H., M.H.</h1>
            <img src="{{ asset('assets/images/foto_profil_pengacara.png') }}" alt="foto profil">
        </div>
        <div class="d-flex justify-content-center">
            <button type="button" class="button-edit" onclick="window.location.href='{{ route('lawyer.profile.edit') }}'">Ubah Profil</button>
        </div>
    </div>

   <div class="form-profil d-flex align-item-center">
        <div class="form-element nama">
            <label for="" class="form-label">Nama Lengkap</label>
            <input readonly type="text" class="form-control input-nama" value="Fajar Nugroho, S. H., M.H.">
        </div>
        <div class="form-element nik">
            <label for="" class="form-label">NIK</label>
            <input readonly type="text" class="form-control input-nik" value="09876543210">
        </div>
        <div class="form-element email">
            <label for="" class="form-label">Email</label>
            <input readonly type="email" class="form-control input-email" value="fajarnugroho@gmail.com">
        </div>
        <div class="form-element telepon">
            <label for="" class="form-label">Nomor Telepon</label>
            <input readonly type="text" class="form-control input-telepon" value="087123456789">
        </div>
        <div class="form-element lokasi">
            <label for="" class="form-label">Lokasi Tempat Kerja</label>
            <input readonly type="text" class="form-control input-lokasi" value="Jakarta">
        </div>
        <div class="form-element tarifJasa">
            <label for="" class="form-label">Tarif jasa</label>
            <input readonly type="text" class="form-control input-tarifJasa" value="Rp300.000,00">
        </div>
        <div class="form-element spesialisasi">
            <label for="" class="form-label">Spesialisasi</label>
            <input readonly type="text" class="form-control input-spesialisasi" id="savedSpecialties" value="Hukum perdata, Hukum pidana, Litigasi & Sengketa">
        </div>

        <div class="form-element pendidikan">
            <label for="" class="form-label">Informasi Pendidikan</label>
            <textarea readonly class="form-control input-pendidikan" rows="4">Sarjana Hukum (S.H.) - Fakultas Hukum, Bina Nusantara University (2015-2019)
Magister Hukum (M.H.) - Universitas Indonesia, Konsentrasi Hukum Bisnis (2020-2022)</textarea>
        </div>
        <div class="form-element pengalaman">
            <label for="" class="form-label">Pengalaman Kerja</label>
            <textarea readonly class="form-control input-pendidikan" rows="8">1. Associate Lawyer Widjaja & Partners | 2020 - Sekarang Perdata, ketenagakerjaan, dan kontrak bisnis.
2. Legal Officer PT Sentosa Finance | 2018 - 2020 Dokumen hukum, perizinan, dan kepatuhan regulasi.
3. Legal Intern Mahkamah Agung RI | 2017 Riset yuridis dan pendampingan analisis perkara.</textarea>
        </div>
         <div class="form-element durasi_kerja">
            <label for="" class="form-label">Durasi Pengalaman Kerja</label>
            <input readonly type="text" class="form-control input-spesialisasi" id="savedSpecialties" oninput="tambahTahun(this)" value="Hukum perdata, Hukum pidana, Litigasi & Sengketa">
        </div>
        <div class="form-element gender">
            <label for="" class="form-label">Jenis Kelamin</label>
            <input readonly type="text" class="form-control input-text" value="Perempuan">
        </div>
        <div class="form-element jenis_layanan">
            <label for="" class="form-label">Jenis Layanan</label>
            <input readonly type="text" class="form-control input-text" value="Pesan, Panggilan Suara">
        </div>
        <div class="button-exit d-flex justify-content-center" >
            <button onclick="window.location.href='{{ route('profile_pengacara.exit') }}'">Keluar Akun</button>
        </div>

   </div>
</body>
</html>e
