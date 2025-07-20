@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/tarik_pendapatan.css') }}">
@endpush
<x-layout_lawyer>
    <x-slot:title>Detail Penarikan</x-slot:title>
    <div class="container mt-5">
        <h4 class="fw-bold mb-4" style="color: #4A2E19;">Tarik Pendapatan</h4>
        <form action="{{ route('pengacara.tarikDana') }}" method="POST">
            @csrf

            <div class="mb-4 row align-items-start">
                <label class="col-sm-3 col-form-label" style="color: #4A2E19;">Tarik Pendapatan Ke</label>
                <div class="col-sm-6">
                    <div class="border rounded p-3 d-flex align-items-center border-dark" style="height: 100px;">
                        <i class="bi bi-bank me-3" style="font-size: 1.5rem;"></i>
                        <div>
                            <div style="font-weight: 600;">{{ $bank }}</div>
                            <div>{{ $nomor_rekening }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-2 row">
                <label class="col-sm-3 col-form-label" style="color: #4A2E19;">Jumlah Penarikan Dana</label>
                <div class="col-sm-3">
                    <input type="number" name="jumlah_penarikan" id="jumlah_penarikan" class="form-control"
                        placeholder="Masukkan nominal" required style="border: 1px solid black;">
                    <small class="text-muted">Saldo saat ini : Rp. {{ number_format($saldo, 0, ',', '.') }}</small>
                </div>
            </div>

            <div class="mb-2 row">
                <label class="col-sm-3 col-form-label" style="color: #4A2E19;">Biaya Transaksi</label>
                <div class="col-sm-3">
                    <input type="number" readonly name="biaya_transaksi" id="biaya_transaksi" class="form-control"
                        value="1000" style="border: 1px solid black;">
                    <small class="text-muted">Diterapkan ke penarikan dana yang sukses</small>
                </div>
            </div>

            <div class="row mt-5 mb-4">
                <div class="col-sm text-end">
                    <div class="d-inline-block me-3 text-end">
                        <div class="fw-light" style="font-size: 14px; color: #654220;">Jumlah Akhir Penarikan Dana</div>
                        <div class="fw-bold" style="font-size: 18px; color: #654220;" id="total_output">Rp0</div>
                    </div>
                    <button type="submit" class="btn mb-4"
                        style="border: 1px solid #6C4521; color: #6C4521; padding: 6px 24px; border-radius: 8px;">
                        Konfirmasi
                    </button>
                </div>
            </div>
        </form>

        <script>
            const inputPenarikan = document.getElementById('jumlah_penarikan');
            const biaya = document.getElementById('biaya_transaksi');
            const output = document.getElementById('total_output');

            function formatRupiah(angka) {
                return 'Rp' + Number(angka).toLocaleString('id-ID');
            }

            function updateTotal() {
                const jumlah = parseInt(inputPenarikan.value) || 0;
                const biayaAdmin = parseInt(biaya.value) || 0;
                const total = jumlah + biayaAdmin;
                output.innerText = formatRupiah(total);
            }

            inputPenarikan.addEventListener('input', updateTotal);
        </script>
    </div>
    {{-- ini link untuk ikon bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</x-layout_lawyer>
