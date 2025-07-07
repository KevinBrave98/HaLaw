@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/tarik_pendapatan.css') }}">
@endpush
<x-layout_lawyer>
    <x-slot:title>Penarikan Pendapatan</x-slot:title>
    <div class="container mt-5">
        <h5 class="mb-4" style="color: #2F1D0E;">Penarikan Pendapatan</h5>
        <div class="p-4 rounded" style="background-color: #F1CEAA;">
            <div class="row border border-dark mb-4">
                <div class="col-md-6 p-3 border-end border-dark">
                    <div class="fw-bold mb-1">Informasi Pendapatan</div>
                    <small class="text-muted">Saldo</small>
                    <div class="fs-5">Rp. {{number_format($saldo, 0, ',', '.')}}</div>
                </div>
                <div class="col-md-6 p-3 position-relative">
                    <div class="text-muted">Rekening Bank Saya</div>
                    <div class="d-flex align-items-center mt-2">
                        <i class="bi bi-bank me-2"></i>
                        <div>
                            <div>BCA</div>
                            <div>xxxxxxxxxx</div>
                        </div>
                    </div>
                    <a href="#" class="position-absolute end-0 bottom-0 me-3 mb-2 fw-bold"
                        style="font-size: 14px; color: #B99010;">Ubah ></a>
                </div>
            </div>

            <div class="text-end">
                <a href="#" class="btn btn-light px-4 py-2"
                    style="border: 1px solid #fff;">
                    Tarik Pendapatan
                </a>
            </div>
        </div>

        <h5 class="mt-5 mb-3" style="color: #2F1D0E;">Riwayat Dana</h5>
        <div class="rounded p-0 mb-5" style="background-color: #F1CEAA; overflow: hidden; height:40vw;">

            <div class="p-3 border-bottom border-dark">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="fw-bold">Terima Pembayaran</div>
                        <div class="text-muted">Dari Nama Pengguna</div>
                    </div>
                    <div class="text-dark fw-semibold">+Rp150.000,00</div>
                </div>
                <div class="d-flex justify-content-between">
                    <small class="text-muted">31 Des 2999</small>
                    <small class="text-muted">Biaya aplikasi : (-Rp15.000,00)</small>
                </div>
            </div>

            <div class="p-3 border-bottom border-dark">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="fw-bold">Tarik Dana</div>
                        <div class="text-muted">Ke Rekening xxxxxxxxx</div>
                    </div>
                    <div class="text-dark fw-semibold">-Rp50.000,00</div>
                </div>
                <div class="d-flex justify-content-between">
                    <small class="text-muted">31 Des 2999</small>
                    <span></span>
                </div>
            </div>
        </div>
    </div>
    {{-- ini link untuk ikon bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</x-layout_lawyer>
