<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ubah Profil</title>

    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet" href="{{ asset('assets/styles/navbar_lawyer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/ubah_profil_pengacara.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Serif+KR:wght@200..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">


    <script src="{{ asset('assets/scripts/ubah_profil_pengacara.js') }}"></script>
</head>

<body>
    <x-navbar_lawyer></x-navbar_lawyer>
    <div class="d-flex justify-content-between bagian-atas">
        <a class="button-back" href="{{ route('lawyer.profile.show') }}">
            <img src="{{ asset('assets/images/icon-back.png') }}" alt="tombol kembali">
        </a>
        <div class="sapaan-foto d-flex flex-column">
            <h1 class="fs-3">Halo, Fajar Nugroho, S. H., M.H.</h1>
            <img src="{{ asset('assets/images/foto_profil_pengacara.png') }}" alt="foto profil">
        </div>
        <div class="d-flex align-item-center justify-content-center">
            <button type="button" class="button-edit">Ubah Profil</button>
        </div>
    </div>

    <div class="profile-container">
        <form id="profileForm" class="form-profil" novalidate>
            <div class="form-element nama">
                <label for="" class="form-label">Nama Lengkap</label>
                <input id="namaLengkap" required type="text" class="form-control input-text"
                    value="Fajar Nugroho, S. H., M.H.">
            </div>
            <div readonly class="form-element nik">
                <label for="" class="form-label">NIK</label>
                <input type="text" class="form-control input-text" value="09876543210">
            </div>
            <div class="form-element email">
                <label for="" class="form-label">Email</label>
                <input id="email" type="email" class="form-control input-text" value="fajarnugroho@gmail.com">
            </div>
            <div class="form-element telepon">
                <label for="" class="form-label">Nomor Telepon</label>
                <input id="nomorTelepon" type="text" class="form-control input-text" value="087123456789">
            </div>
            <div class="form-element alamat">
                <label for="" class="form-label">Lokasi Tempat Kerja</label>
                <input id="lokasi" type="text" class="form-control input-text" value="Jakarta">
            </div>
            <div class="form-element tarifJasa">
                <label for="" class="form-label">Tarif jasa</label>
                <input id="tarifJasa" type="text" class="form-control input-text" value="Rp300.000,00">
            </div>
            <div class="input-pengalaman-container">
                <label class="form-label">Spesialisasi Hukum</label>
                <div class="custom-checkbox">
                    <input class="form-check-input" type="checkbox" value="Hukum Perdata" id="perdata">
                    <label class="form-check-label" for="perdata">Hukum Perdata</label>
                </div>
                <div class="custom-checkbox">
                    <input class="form-check-input" type="checkbox" value="Hukum Pidana" id="pidana">
                    <label class="form-check-label" for="pidana">Hukum Pidana</label>
                </div>
                <div class="custom-checkbox">
                    <input class="form-check-input" type="checkbox" value="Hukum Keluarga" id="keluarga">
                    <label class="form-check-label" for="keluarga">Hukum Keluarga</label>
                </div>
                <div class="custom-checkbox">
                    <input class="form-check-input" type="checkbox" value="Hukum Perusahaan" id="perusahaan">
                    <label class="form-check-label" for="perusahaan">Hukum Perusahaan</label>
                </div>
                <div class="custom-checkbox">
                    <input class="form-check-input" type="checkbox" value="Hukum Hak Kekayaan Intelektual"
                        id="haki">
                    <label class="form-check-label" for="haki">Hukum Hak Kekayaan Intelektual</label>
                </div>
                <div class="custom-checkbox">
                    <input class="form-check-input" type="checkbox" value="Hukum Pajak" id="pajak">
                    <label class="form-check-label" for="pajak">Hukum Pajak</label>
                </div>
                <div class="custom-checkbox">
                    <input class="form-check-input" type="checkbox" value="Hukum Kepailitan" id="kepailitan">
                    <label class="form-check-label" for="kepailitan">Hukum Kepailitan</label>
                </div>
                <div class="custom-checkbox">
                    <input class="form-check-input" type="checkbox" value="Hukum Lingkungan Hidup" id="lingkungan">
                    <label class="form-check-label" for="lingkungan">Hukum Lingkungan Hidup</label>
                </div>
                <div class="custom-checkbox">
                    <input class="form-check-input" type="checkbox" value="Hukum Kepentingan Publik" id="publik">
                    <label class="form-check-label" for="publik">Hukum Kepentingan Publik</label>
                </div>
                <div class="custom-checkbox">
                    <input class="form-check-input" type="checkbox" value="Hukum Ketenagakerjaan"
                        id="ketenagakerjaan">
                    <label class="form-check-label" for="ketenagakerjaan">Hukum Ketenagakerjaan</label>
                </div>
                <div class="custom-checkbox">
                    <input class="form-check-input" type="checkbox" value="Hukum Tata Usaha Negara" id="tun">
                    <label class="form-check-label" for="tun">Hukum Tata Usaha Negara</label>
                </div>
                <div class="custom-checkbox">
                    <input class="form-check-input" type="checkbox" value="Hukum Imigrasi" id="imigrasi">
                    <label class="form-check-label" for="imigrasi">Hukum Imigrasi</label>
                </div>
            </div>
            <div class="form-element pendidikan">
                <label for="" class="form-label">Informasi Pendidikan</label>
                <textarea class="form-control input-pendidikan" rows="4">Sarjana Hukum (S.H.) - Fakultas Hukum, Bina Nusantara University (2015-2019)
Magister Hukum (M.H.) - Universitas Indonesia, Konsentrasi Hukum Bisnis (2020-2022)</textarea>
            </div>
            <div class="form-element pengalaman">
                <label for="" class="form-label">Pengalaman Kerja</label>
                <textarea class="form-control input-pendidikan" rows="8">1. Associate Lawyer Widjaja & Partners | 2020 - Sekarang Perdata, ketenagakerjaan, dan kontrak bisnis.
2. Legal Officer PT Sentosa Finance | 2018 - 2020 Dokumen hukum, perizinan, dan kepatuhan regulasi.
3. Legal Intern Mahkamah Agung RI | 2017 Riset yuridis dan pendampingan analisis perkara.</textarea>
            </div>
            <div class="form-element durasi_kerja">
                <label for="" class="form-label">Durasi Pengalaman Kerja</label>
                <input type="text" class="form-control input-text" id="durasi"value="1 Tahun">
            </div>
            <div class="form-element gender">
                <label class="form-label">Jenis Kelamin</label>
                <div class="d-flex justify-content-between">

                    <div class="form-radio">
                        <input class="form-check-input square-radio" type="radio" name="jenis_kelamin"
                            id="laki" value="Laki - Laki">
                        <label class="form-check-label" for="laki">Laki – Laki</label>
                    </div>

                    <div class="form-radio">
                        <input class="form-check-input square-radio" type="radio" name="jenis_kelamin"
                            id="perempuan" value="Perempuan">
                        <label class="form-check-label" for="perempuan">Perempuan</label>
                    </div>

                    <div class="form-radio">
                        <input class="form-check-input square-radio" type="radio" name="jenis_kelamin"
                            id="tidak_jawab" value="Memilih Tidak Menjawab">
                        <label class="form-check-label" for="tidak_jawab">Memilih Tidak Menjawab</label>
                    </div>

                </div>
            </div>
            <div class="form-element gender">
                <label class="form-label">Jenis Layanan</label>
                <div class="d-flex justify-content-between">

                    <div class="custom-checkbox">
                        <input type="checkbox" name="jenis_layanan" id="pesan" value="Pesan">
                        <label class="form-check-label" for="pesan">Pesan</label>
                    </div>

                    <div class="custom-checkbox">
                        <input type="checkbox" name="jenis_layanan" id="panggilan_suara" value="Panggilan Suara">
                        <label class="form-check-label" for="panggilan_suara">Panggilan Suara</label>
                    </div>

                    <div class="custom-checkbox">
                        <input type="checkbox" name="jenis_layanan" id="panggilan_video" value="Panggilan Video">
                        <label class="form-check-label" for="panggilan_video">Panggilan Video</label>
                    </div>

                </div>
            </div>
            <a class="button-save d-flex justify-content-center" href="{{ route('profile.show') }}">
                <div class="error-message" id="namaError"></div>
                <button type="submit">Simpan Perubahan</button>
            </a>
        </form>
    </div>
</body>

</html>
