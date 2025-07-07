@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/konfirmasi_pembayaran.css') }}">
@endpush
<x-layout_user :title="'Konfirmasi Pembayaran'">
    <h1 class="title-pembayaran">3. Konfirmasi Pembayaran</h1>

    <ul>
        <li>Nama Kartu: {{ $data['card_name'] }}</li>
        <li>Nomor Kartu: {{ $data['card_number'] }}</li>
        <li>Tanggal Kadaluarsa: {{ $data['expiry_date'] }}</li>
        <li>CVV: {{ $data['cvv'] }}</li>
        <li>Negara: {{ $data['country'] }}</li>
        <li>Kode Pos: {{ $data['postal_code'] }}</li>
    </ul>

    <form action="{{ route('payment.confirm') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">Proses Pembayaran</button>
    </form>
</x-layout_user>