@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/metode_pembayaran.css') }}">
@endpush
<x-layout_user :title="'Halaw - Metode Pembayaran'">
    <h1 class="title-pembayaran">1. Periksa Pesanan</h1>
    <div class="pay-box">
        <div class="lawyer-information">
            <div class="d-flex">
                <img src="{{ asset($lawyer->foto_pengacara) }}" alt="Foto Lawyer" class="lawyer-img">
                <div class="ms-3">
                <div class="lawyer-name">{{ $lawyer->nama_pengacara }}</div>
                <div class="lawyer-desc">{{ $lawyer->spesialisasi }}</div>
                <div class="d-flex gap-2">
                    <div class="info-badge">
                    📁 <span>{{ $lawyer->durasi_pengalaman }} tahun</span>
                    </div>
                    <div class="info-badge">
                    👥 <span>{{ $total_klien }} klien</span>
                    </div>
                </div>
                </div>
            </div>

            <div class="line"></div>

            <div class="d-flex justify-content-between">
                <div class="cost-label">Biaya Sesi 1 Jam</div>
                <div class="cost-label">Rp {{ number_format($lawyer->tarif_jasa, 0, ',', '.') }}</div>
            </div>
            <div class="d-flex justify-content-between">
                <div class="cost-label">Biaya Layanan</div>
                <div class="cost-label">Rp 10.000</div>
            </div>
            <div class="d-flex justify-content-between total-row mt-2">
                <div class="total-amount" style="color: #654220">Total Biaya</div>
                <div class="total-amount">Rp {{ number_format($total_biaya, 0, ',', '.') }}</div>
            </div>
            </div>
        <div class="pay-button">
            <a href=""><button type="button" class="btn btn-lg" style="background-color: #B99010; color:#f5f5f5">Batalkan Pesanan</button></a>
            <a href="{{ route('pilih_pembayaran.pengacara') }}"><button type="button" class="btn btn-lg" style="background-color: #B99010; color:#f5f5f5">></button></a>
        </div>
    </div>
</x-layout_user>