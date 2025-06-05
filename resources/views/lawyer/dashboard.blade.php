<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet" href={{ asset('assets/styles/lawyer_dashboard.css') }}>
    <title>Dashboard Pengacara</title>
</head>
<body>
    <div class="container">
        <div class="greetings">
            <h1>Halo, <strong>{{ $nama_pengacara }}!</strong></h1>
        </div>
        <div class="consult-container">
            <h2>Cek Sesi Konsultasi yang Sedang Berjalan</h2>
            <button type="button" class="btn" onclick="">Lihat Sesi</button>
        </div>
        <div class="consult-information">
            <h2>Informasi Anda</h2>
            <div class="isi-consult-info">
                <div class="status-konsultasi">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Status Konsultasi</h5>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                </div>
                                <p class="card-text">Status Anda Saat Ini : </p>
                            </div>
                        </div>
                </div>
                <div class="layanan-konsultasi">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Layanan Konsultasi</h5>
                                <div class="checkbox-layanan-konsultasi">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                        <label class="form-check-label" for="inlineCheckbox1">Pesan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                                        <label class="form-check-label" for="inlineCheckbox2">Panggilan Suara</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                                        <label class="form-check-label" for="inlineCheckbox2">Panggilan Video</label>
                                    </div>
                                </div>
                                <p class="card-text">Layanan Anda Saat Ini : </p>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="revenue">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Pendapatan</h5>
                    <div class="isi-card">
                        <p class="card-text"> Rp.</p>
                        <a href="#" class="btn btn-primary">Tarik Pendapatan</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="review">
            <div class="card w-75">
                <div class="card-body">
                    <div class="card-left">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    </div>
                    <div class="card-right">
                        <a href="#" class="btn btn-primary">Button</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>