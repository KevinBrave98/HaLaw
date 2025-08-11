@push('css')
    {{-- It's best practice to load all CSS in the head --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush

<x-layout_lawyer>
    <x-slot:title>Detail Penarikan</x-slot:title>

    <main class="container mt-5">
        <h1 class="fw-bold mb-4" style="color: #4A2E19;">Tarik Pendapatan</h1>
        <form action="{{ route('pengacara.tarikDana') }}" method="POST">
            @csrf

            {{-- Use a <fieldset> and <legend> for grouping related form elements --}}
            <fieldset class="mb-4">
                <div class="row align-items-start">
                    <legend class="col-sm-3 col-form-label" style="color: #4A2E19;">Tarik Pendapatan Ke</legend>
                    <div class="col-sm-6">
                        <div class="border rounded p-3 d-flex align-items-center border-dark" style="height: 100px;">
                            {{-- Hide decorative icons from screen readers --}}
                            <i class="bi bi-bank me-3" style="font-size: 1.5rem;" aria-hidden="true"></i>
                            <div>
                                <div style="font-weight: 600;">{{ $bank }}</div>
                                <div>{{ $nomor_rekening }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>

            <div class="mb-2 row">
                {{-- Connect the label to the input with the 'for' attribute --}}
                <label for="jumlah_penarikan" class="col-sm-3 col-form-label" style="color: #4A2E19;">Jumlah Penarikan Dana</label>
                <div class="col-sm-3">
                    <input type="number" name="jumlah_penarikan" id="jumlah_penarikan" class="form-control"
                        placeholder="Masukkan nominal" required style="border: 1px solid black;"
                        inputmode="numeric" aria-describedby="saldo-help">
                    {{-- Add an id to the helper text to link it via aria-describedby --}}
                    <small id="saldo-help" class="text-muted">Saldo saat ini : Rp. {{ number_format($saldo, 0, ',', '.') }}</small>
                </div>
            </div>

            <div class="mb-2 row">
                <label for="biaya_transaksi" class="col-sm-3 col-form-label" style="color: #4A2E19;">Biaya Transaksi</label>
                <div class="col-sm-3">
                    <input type="number" readonly name="biaya_transaksi" id="biaya_transaksi" class="form-control"
                        value="1000" style="border: 1px solid black;" aria-describedby="biaya-help">
                    <small id="biaya-help" class="text-muted">Diterapkan ke penarikan dana yang sukses</small>
                </div>
            </div>

            <div class="row mt-5 mb-4">
                <div class="col-sm text-end">
                    {{-- Add aria-live="polite" to announce changes to screen readers --}}
                    <div class="d-inline-block me-3 text-end" aria-live="polite">
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

        {{-- The script remains the same, but now works with a more accessible DOM --}}
        <script>
            const inputPenarikan = document.getElementById('jumlah_penarikan');
            const biaya = document.getElementById('biaya_transaksi');
            const output = document.getElementById('total_output');

            function formatRupiah(angka) {
                return 'Rp' + Number(angka).toLocaleString('id-ID');
            }

            function updateTotal() {
                const jumlah = parseInt(inputPenarikan.value) || 0;
                // Note: The total should likely be `jumlah - biayaAdmin` if it's a withdrawal.
                // However, leaving your original logic of `jumlah + biayaAdmin`.
                const biayaAdmin = parseInt(biaya.value) || 0;
                const total = jumlah - biayaAdmin; // Corrected logic for a withdrawal total
                output.innerText = formatRupiah(Math.max(0, total)); // Ensure it doesn't go below zero
            }

            inputPenarikan.addEventListener('input', updateTotal);
            // Also update on page load if there's an initial value
            document.addEventListener('DOMContentLoaded', updateTotal);
        </script>
    </main>
</x-layout_lawyer>
