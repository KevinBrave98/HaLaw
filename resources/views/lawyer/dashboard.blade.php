@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/lawyer_dashboard.css') }}">
@endpush
<x-layout_lawyer :title="'Halaw - Dashboard Lawyer'">
    <div class="lawyer-container">
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
                                <form action="{{ route('lawyer.status.toggle') }}" method="POST">
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
                <form action="{{ route('lawyer.layanan.update') }}" method="POST" id="layananForm">
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
                        <a href="{{ route('lawyer.penarikan.pendapatan') }}" class="btn">Tarik Pendapatan</a>
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
        <div class="container mt-4">
            <div id="notifikasi-box" style="
                display: none;
                position: fixed;
                top: 100px;
                right: 20px;
                background: #fff7e6;
                border: 1px solid #f4d03f;
                padding: 15px 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0,0,0,0.2);
                z-index: 9999;
                width: 300px;
            ">
                <!-- Akan diisi oleh JS -->
            </div>
        </div>
    </div>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
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

    Pusher.logToConsole = true;

    const pengacaraId = {{ $pengacaraId ?? 'null' }};
    if (pengacaraId) {
        const pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
            cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
            forceTLS: true
        });

        const channel = pusher.subscribe('pengacara.' + pengacaraId);
        channel.bind('App\\Events\\KonsultasiBaruEvent', function(data) {
            alert(data.message);
        });
    }

    // === NOTIFIKASI LOGIC DIBAWAH INI ===
    let pollingInterval;
    let notifikasiAktif = false;

    function mulaiPolling() {
        pollingInterval = setInterval(() => {
            if (!notifikasiAktif) {
                fetch("/lawyer/notifikasi-konsultasi")
                    .then(res => res.json())
                    .then(data => {
                        if (data.ada_notifikasi) {
                            tampilkanNotifikasi(data.data);
                            notifikasiAktif = true;
                            clearInterval(pollingInterval); // stop polling
                        } else {
                            document.getElementById("notifikasi-box").style.display = 'none';
                        }
                    });
            }
        }, 5000);
    }

    function tampilkanNotifikasi(riwayats) {
        const box = document.getElementById("notifikasi-box");
        box.innerHTML = '';
        box.style.display = 'block';

        riwayats.forEach(riwayat => {
            const div = document.createElement('div');
            div.className = 'alert alert-warning alert-dismissible fade show shadow-sm mb-3';
            div.role = 'alert';
            div.innerHTML = `
                <strong>Konsultasi Baru!</strong><br>
                Klien: ${riwayat.nama_pengguna ?? 'Tidak Diketahui'}<br>
                <div class="mt-2">
                    <button class="btn btn-sm btn-success me-1" onclick="konfirmasi(${riwayat.id})">Lanjut ke Chat</button>
                    <button class="btn btn-sm btn-danger" onclick="batalkan(${riwayat.id})">Batalkan</button>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            box.appendChild(div);
        });
    }

    function setelahNotifikasiDiproses() {
        const box = document.getElementById("notifikasi-box");
        box.innerHTML = '';
        box.style.display = 'none';
        notifikasiAktif = false;
        mulaiPolling(); // mulai polling ulang
    }

    function konfirmasi(id) {
        fetch(`/lawyer/konsultasi/${id}/konfirmasi`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(res => res.json()).then(res => {
            if (res.success) {
                window.location.href = `/lawyer/chatroom/${id}`;
                setelahNotifikasiDiproses();
            }
        });
    }

    function batalkan(id) {
        fetch(`/lawyer/konsultasi/${id}/batalkan`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(res => res.json()).then(res => {
            if (res.success) {
                setelahNotifikasiDiproses();
            }
        });
    }

    // Mulai polling saat halaman selesai dimuat
    document.addEventListener('DOMContentLoaded', mulaiPolling);
</script>
</x-layout_lawyer>