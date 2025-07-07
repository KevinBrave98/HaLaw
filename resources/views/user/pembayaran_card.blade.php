@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/card.css') }}">
@endpush
<x-layout_user :title="'Halaw - Credit/Debit Card'">
    <h1 class="title-pembayaran">2. Pilih Metode Pembayaran</h1>
    <div class="pay-box">
        <h5 class="metode-pembayaran">Credit Card / Debit Online</h5>
        <form class="form-card" method="POST" action="{{ route('payment.confirm') }}">
            @csrf
            <div class="row mb-3">
                <div class="col-12">
                    <label class="form-label">Nama di Kartu</label>
                    <input type="text" class="form-control" name="card_name" required placeholder="AXXXXX BXXXXX">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <label class="form-label">Nomor Kartu</label>
                    <input type="text" class="form-control" name="card_number" required maxlength="19" placeholder="1234 1234 1234 1234">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Tanggal Kadaluwarsa</label>
                    <input type="text" class="form-control" name="expiry_date" placeholder="MM/YY" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">CVV/CVC</label>
                    <input type="text" class="form-control" name="cvv" maxlength="4" required placeholder="12345">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Negara</label>
                    <input type="text" class="form-control" name="country" placeholder="Indonesia" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kode Pos</label>
                    <input type="text" class="form-control" name="postal_code" required placeholder="12345">
                </div>
            </div>
            <div class="pay-button mx-auto">
                <a href="{{ route('pilih_pembayaran.pengacara') }}"><button type="button" class="btn btn-lg" style="background-color: #B99010; color:#f5f5f5"><</button></a>
                <button type="submit" class="btn btn-lg" style="background-color: #B99010; color:#f5f5f5">></button>
        </div>
        </form>
    </div>
</x-layout_user>