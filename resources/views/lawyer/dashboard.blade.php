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
    <link rel="stylesheet" href={{ asset('assets/styles/navbar_lawyer.css') }}>
    <title>Dashboard Pengacara</title>
</head>
<body>
    <x-navbar_lawyer></x-navbar_lawyer>
    <div class="container">
        <div class="greetings">
            <h1>Halo, <strong>{{ $pengacara->nama_pengacara }}</strong>!</h1>
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
                                <form action="{{ route('dasbor_pengacara.toggleStatus') }}" method="POST">
                                    @csrf
                                    <div class="form-check form-switch">
                                        <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        name="status_konsultasi"
                                        id="statusSwitch"
                                        onchange="this.form.submit()"
                                        {{ $status_konsultasi == 1 ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="statusSwitch">
                                        Status: {{ $status_konsultasi == 1 ? 'Online' : 'Offline' }}
                                    </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                </div>
                <form action="{{ route('dasbor_pengacara.updateLayanan') }}" method="POST" id="layananForm">
                    @csrf
                    <div class="layanan-konsultasi">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Layanan Konsultasi</h5>
                                <div class="checkbox-layanan-konsultasi">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input layanan-checkbox" type="checkbox" id="pesan" name="chat" value="Pesan"
                                            onchange="document.getElementById('layananForm').submit();"
                                            {{ $pengacara->chat ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pesan">Pesan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input layanan-checkbox" type="checkbox" id="suara" name="voice_chat" value="Panggilan Suara"
                                            onchange="document.getElementById('layananForm').submit();"
                                            {{ $pengacara->voice_chat ? 'checked' : '' }}>
                                        <label class="form-check-label" for="suara">Panggilan Suara</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input layanan-checkbox" type="checkbox" id="video" name="video_call" value="Panggilan Video"
                                            onchange="document.getElementById('layananForm').submit();"
                                            {{ $pengacara->video_call ? 'checked' : '' }}>
                                        <label class="form-check-label" for="video">Panggilan Video</label>
                                    </div>
                                </div>

                                <p class="card-text" id="layanan-terpilih">
                                    Layanan Anda Saat Ini:
                                    @php
                                        $layanan = [];
                                        if ($pengacara->chat) $layanan[] = 'Pesan';
                                        if ($pengacara->voice_chat) $layanan[] = 'Panggilan Suara';
                                        if ($pengacara->video_call) $layanan[] = 'Panggilan Video';
                                    @endphp
                                    {{ count($layanan) ? implode(', ', $layanan) : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="revenue">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Pendapatan</h5>
                    <div class="isi-card">
                        <p class="card-text"> Rp.{{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                        <a href="#" class="btn">Tarik Pendapatan</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="review">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Penilaian dan Ulasan dari Pengguna</h5>
                    <div class="isi-card">
                        <div class="isi-review">
                            <span style="font-size:150%;color:#B99010;">★</span><p class="card-text">{{ number_format($penilaian, 1, ',', '.') }}</p>
                        </div>
                        <a href="#" class="btn">Lihat Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const checkboxes = document.querySelectorAll('.layanan-checkbox');
        const layananTerpilih = document.getElementById('layanan-terpilih');

        function updateLayanan() {
            const aktif = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

            layananTerpilih.textContent = aktif.length > 0
            ? 'Layanan Anda Saat Ini : ' + aktif.join(', ')
            : 'Layanan Anda Saat Ini : -';
        }

        checkboxes.forEach(cb => cb.addEventListener('change', updateLayanan));
        updateLayanan();
    </script>
</body>
</html>