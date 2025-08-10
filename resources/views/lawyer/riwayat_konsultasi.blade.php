@push('css')
    {{-- I've added suggested CSS classes in a block below --}}
    <link rel="stylesheet" href="{{ asset('assets/styles/riwayat_konsultasi.css') }}">
@endpush

<x-layout_lawyer :title="'Halaw - Riwayat Konsultasi'">

    <nav class="konsultasi-nav d-flex border-bottom w-100" aria-label="Navigasi Konsultasi">
        <a href="{{ route('lawyer.konsultasi.berlangsung') }}"
            class="tab d-flex align-items-center justify-content-center flex-fill text-white text-decoration-none"
            aria-current="page">
            Sedang Berlangsung
        </a>
        <a href="{{ route('lawyer.riwayat.konsultasi') }}"
            class="tab d-flex align-items-center justify-content-center flex-fill text-white text-decoration-none selected">
            Riwayat Konsultasi
        </a>
    </nav>
    <main>
        {{-- Tab Navigation --}}

        {{-- Filter Section --}}
        <section class="container mt-3" aria-labelledby="filter-heading">
            <h2 id="filter-heading" class="visually-hidden">Filter Riwayat</h2>
            <form method="GET" action="{{ route('riwayat.konsultasi') }}"
                class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

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
                <fieldset class="date-filter-group">
                    {{-- <legend class="date-filter-legend">Filter berdasarkan Tanggal</legend> --}}
                    <div class="d-flex flex-column flex-md-row align-items-md-center gap-2">
                        <div class="date-input-wrapper">
                            <label for="from" class="form-label">Dari</label>
                            <input type="date" name="tanggal_awal" id="from"
                                value="{{ request('tanggal_awal') }}" class="form-control form-control-sm">
                        </div>
                        <span aria-hidden="true" class="mx-1">-</span>
                        <div class="date-input-wrapper">
                            <label for="to" class="form-label">Sampai</label>
                            <input type="date" name="tanggal_akhir" id="to"
                                value="{{ request('tanggal_akhir') }}" class="form-control form-control-sm">
                        </div>
                        <div class="d-flex align-items-end">
                            <button type="submit" class="btn btn-light btn-sm ms-md-2 mt-2 mt-md-0">Filter</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </section>

        {{-- Daftar Konsultasi --}}
        <section class="container mt-4 consultation-list" aria-labelledby="list-heading">
            <h2 id="list-heading" class="visually-hidden">Daftar Hasil Riwayat Konsultasi</h2>
            @forelse ($riwayats as $riwayat)
                <article class="card-riwayat">
                    <img src="{{ $riwayat->pengguna->foto_pengguna ? asset('storage/' . $riwayat->pengguna->foto_pengguna) : asset('assets/images/foto-profil-default.jpg') }}"
                        alt="Foto {{ $riwayat->pengguna->foto_pengguna ?? 'pengguna' }}">

                    <dl class="info">
                        <div>
                            <dt>Tanggal</dt>
                            <dd>{{ \Carbon\Carbon::parse($riwayat->created_at)->translatedFormat('l, d F Y') }}</dd>
                        </div>
                        <div>
                            <dt>Waktu</dt>
                            <dd>{{ \Carbon\Carbon::parse($riwayat->created_at)->format('H:i') }}</dd>
                        </div>
                        <div>
                            <dt>Pengguna</dt>
                            <dd>{{ $riwayat->pengguna->nama_pengguna ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt>Status</dt>
                            <dd>
                                <span
                                    class="status-box {{ $riwayat->status === 'Selesai' ? 'status-selesai' : 'status-dibatalkan' }}">
                                    {{ $riwayat->status }}
                                </span>
                            </dd>
                        </div>
                    </dl>

                    <div class="card-actions">
                        <a href="{{ route('consultation.lawyer', ['id' => $riwayat->id]) }}" class="btn btn-dark">Lihat
                            Detail</a>
                    </div>
                </article>
            @empty
                <div class="text-center mt-5">
                    <p class="empty-message">Belum Pernah Ada Konsultasi</p>
                </div>
            @endforelse
        </section>
    </main>
</x-layout_lawyer>
