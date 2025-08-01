@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/riwayat_konsultasi_pengguna.css') }}">
@endpush

<x-layout_user :title="'Halaw - Riwayat Konsultasi'">

    {{-- Tab Navigasi --}}
    <div class="d-flex border-bottom mb-3 w-100" style="height: 80px">
        <a href="{{ route('konsultasi.berlangsung') }}"
            class="tab d-flex align-items-center justify-content-center flex-fill text-white text-decoration-none"
            style="font-weight: bold; font-size: 25px; background-color: #3c2a1a;">
            Sedang Berlangsung
        </a>
        <a href="{{ route('riwayat.konsultasi') }}"
            class="tab d-flex align-items-center justify-content-center flex-fill text-white text-decoration-none selected"
            style="font-weight: bold; font-size: 25px;">
            Riwayat Konsultasi
        </a>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('riwayat.konsultasi') }}"
        class="container mt-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

        {{-- Filter Status --}}
        <div class="filter-buttons">
            <button type="submit" name="status" value=""
                class="btn-filter {{ is_null($status) ? 'active' : '' }}">Semua</button>
            <button type="submit" name="status" value="Selesai"
                class="btn-filter {{ $status === 'Selesai' ? 'active' : '' }}">Selesai</button>
            <button type="submit" name="status" value="Dibatalkan"
                class="btn-filter {{ $status === 'Dibatalkan' ? 'active' : '' }}">Dibatalkan</button>
        </div>

        {{-- Filter Tanggal --}}
        <div class="bg-dark text-white p-3 rounded d-flex flex-column flex-md-row align-items-md-center gap-2">
            <div class="d-flex flex-column">
                <label for="from" class="form-label mb-0">Dari</label>
                <input type="date" name="tanggal_awal" id="from" value="{{ request('tanggal_awal') }}"
                    class="form-control form-control-sm">
            </div>
            <span class="mx-1">-</span>
            <div class="d-flex flex-column">
                <label for="to" class="form-label mb-0">Sampai</label>
                <input type="date" name="tanggal_akhir" id="to" value="{{ request('tanggal_akhir') }}"
                    class="form-control form-control-sm">
            </div>
            <div class="d-flex align-items-end">
                <button type="submit" class="btn btn-light btn-sm ms-md-2 mt-2 mt-md-0">Filter</button>
            </div>
        </div>
    </form>

    {{-- Daftar Konsultasi --}}
    <div class="container mt-4" id="konsultasi-list" style="padding: 20px">

        @forelse ($riwayats as $riwayat)
            <div class="card-riwayat">
                <img src="{{ asset($riwayat->pengacara->foto_pengacara ?? 'assets/images/foto_profile_pengacara.png') }}"
                    alt="Foto Pengacara">

                <div class="info">
                    <div>
                        <label>Tanggal</label><br>
                        <input type="text"
                            value="{{ \Carbon\Carbon::parse($riwayat->created_at)->translatedFormat('l, d F Y') }}"
                            readonly>
                    </div>
                    <div>
                        <label>Waktu</label><br>
                        <input type="text" value="{{ \Carbon\Carbon::parse($riwayat->created_at)->format('H:i') }}"
                            readonly>
                    </div>
                    <div>
                        <label>Pengacara</label><br>
                        <input type="text" value="{{ $riwayat->pengacara->nama_pengacara ?? '-' }}" readonly>
                    </div>
                    <div>
                        <label>Status</label><br>
                        <span
                            class="status-box {{ $riwayat->status === 'Selesai' ? 'status-selesai' : 'status-dibatalkan' }}">
                            {{ $riwayat->status }}
                        </span>
                    </div>
                </div>

                <div>
                    <a href="{{ route('consultation.client', ['id' => $riwayat->id]) }}" class="btn btn-dark">Lihat Detail</a>
                </div>
            </div>
        @empty
            <h1 class="text-center mt-5 fw-bold" style="color: #654220;">Belum Pernah Ada Konsutasi</h1>
        @endforelse
    </div>
</x-layout_user>
