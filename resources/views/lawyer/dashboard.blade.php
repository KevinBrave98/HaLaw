@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/lawyer_dashboard.css') }}">
@endpush
<x-layout_lawyer :title="'Halaw - Dashboard Lawyer'">
    {{-- Gunakan <main> sebagai wrapper utama untuk konten halaman --}}
    <main class="lawyer-container">
        <div class="greetings">
            <h1>Halo, <strong>{{ $pengacara->nama_pengacara }}</strong>!</h1>
        </div>

        {{-- Gunakan <section> untuk mengelompokkan konten yang saling terkait --}}
        <section class="consult-container" aria-labelledby="sesi-konsultasi-heading">
            <h2 id="sesi-konsultasi-heading">Cek Sesi Konsultasi yang Sedang Berjalan</h2>
            {{-- Gunakan <a> untuk navigasi, bukan <button> dengan onclick --}}
            <a href="{{ route('lawyer.konsultasi.berlangsung')}}" class="btn">Lihat Sesi</a> {{-- TODO: Ganti # dengan route yang benar --}}
        </section>

        {{-- Ini adalah bagian utama lain dari dasbor --}}
        <section class="consult-information" aria-labelledby="informasi-anda-heading">
            <h2 id="informasi-anda-heading">Informasi Anda</h2>
            <div class="isi-consult-info">
                <div class="status-konsultasi">
                    <div class="card">
                        {{-- Gunakan <fieldset> dan <legend> untuk grup form --}}
                        <form action="{{ route('lawyer.status.toggle') }}" method="POST">
                            @csrf
                            <fieldset class="card-body">
                                <legend class="card-title h5">Status Konsultasi</legend>
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
                            </fieldset>
                        </form>
                    </div>
                </div>
                <form action="{{ route('lawyer.layanan.update') }}" method="POST" id="layananForm">
                    @csrf
                    <div class="layanan-konsultasi">
                        <div class="card">
                             {{-- <fieldset> dan <legend> juga ideal untuk grup checkbox --}}
                            <fieldset class="card-body">
                                <legend class="card-title h5">Layanan Konsultasi</legend>
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

                                {{-- aria-live akan membuat screen reader mengumumkan perubahan teks secara otomatis --}}
                                <p class="card-text" id="layanan-terpilih" aria-live="polite">
                                    Layanan Anda Saat Ini:
                                    @php
                                        $layanan = [];
                                        if ($pengacara->chat) $layanan[] = 'Pesan';
                                        if ($pengacara->voice_chat) $layanan[] = 'Panggilan Suara';
                                        if ($pengacara->video_call) $layanan[] = 'Panggilan Video';
                                    @endphp
                                    {{ count($layanan) ? implode(', ', $layanan) : '-' }}
                                </p>
                            </fieldset>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <section class="revenue" aria-labelledby="pendapatan-heading">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" id="pendapatan-heading">Total Pendapatan</h5>
                    <div class="isi-card">
                        <p class="card-text"> Rp.{{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                        <a href="{{ route('lawyer.penarikan.pendapatan') }}" class="btn">Tarik Pendapatan</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="review" aria-labelledby="penilaian-heading">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" id="penilaian-heading">Penilaian dan Ulasan dari Pengguna</h5>
                    <div class="isi-card">
                        <div class="isi-review">
                             {{-- Sembunyikan bintang dekoratif dari screen reader dan berikan teks yang lebih deskriptif --}}
                            <span style="font-size:150%;color:#B99010;" aria-hidden="true">★</span>
                            <p class="card-text">
                                <span class="visually-hidden">Rating: </span>{{ number_format($penilaian, 1, ',', '.') }} dari 5
                            </p>
                        </div>
                         {{-- TODO: Ganti # dengan route yang benar --}}
                        <a href="{{ route('lawyer.ulasan') }}" class="btn">Lihat Detail</a>
                    </div>
                </div>
            </div>
        </section>

        {{-- Jadikan kotak notifikasi sebagai "live region" agar isinya diumumkan saat muncul --}}
        <div class="container mt-4">
            <div id="notifikasi-box"
                 aria-live="assertive"
                 aria-atomic="true"
                 style="display: none; position: fixed; ...">
                </div>
        </div>
    </div>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>
    // ... (Fungsi updateLayanan tidak berubah) ...
    const checkboxes = document.querySelectorAll('.layanan-checkbox');
    const layananTerpilih = document.getElementById('layanan-terpilih');

    function updateLayanan() {
        const aktif = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        const newText = `Layanan Anda Saat Ini: ${aktif.length > 0 ? aktif.join(', ') : '-'}`;

        // Cek jika teks berubah sebelum update untuk menghindari pengumuman yang tidak perlu
        if (layananTerpilih.textContent.trim() !== newText.trim()) {
            layananTerpilih.textContent = newText;
        }
    }

    checkboxes.forEach(cb => cb.addEventListener('change', () => {
        document.getElementById('layananForm').submit();
        updateLayanan(); // Panggil setelah submit untuk update tampilan
    }));
    updateLayanan();


    Pusher.logToConsole = true;

    const pengacaraId = {{ $pengacaraId ?? 'null' }};
    if (pengacaraId) {
        const pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
            cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
            forceTLS: true
        });

        const channel = pusher.subscribe('pengacara.' + pengacaraId);

        // HINDARI alert(). Gunakan sistem notifikasi yang sudah ada.
        channel.bind('App\\Events\\KonsultasiBaruEvent', function(data) {
            // Asumsikan event mengirim data yang mirip dengan polling
            // Sesuaikan properti (nama_pengguna, id) berdasarkan data event Anda
            if(data.data) {
                 tampilkanNotifikasi(data.data);
            }
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
