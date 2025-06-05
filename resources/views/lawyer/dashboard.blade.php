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
            <h1>Halo</h1><a href="">{{ $nama_pengacara }}</a>
        </div>
        <div class="consult-container">
            <h2>Cek Sesi Konsultasi yang Sedang Berjalan</h2>
            <button type="button" class="btn btn-primary btn-lg">Large button</button>
        </div>
        <div class="consult-information">
            <h2>Informasi Anda</h2>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Special title treatment</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Special title treatment</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="revenue">
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