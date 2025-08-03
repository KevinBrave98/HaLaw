@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/metode_pembayaran.css') }}">
@endpush

@push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>

    <script type="text/javascript">
        document.getElementById('pay-button').addEventListener('click', function() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    fetch('/payment/store-riwayat', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                order_id: result.order_id,
                                nik_pengacara: '{{ $lawyer->nik_pengacara }}'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.href = "/konsultasi/sedang-berlangsung";
                            } else {
                                alert("Gagal menyimpan riwayat.");
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert("Gagal menyimpan riwayat. Coba lagi.");
                        });
                },
                onPending: function(result) {
                    console.log('Menunggu pembayaran:', result);
                    window.location.href = "/payment/pending";
                },
                onError: function(result) {
                    console.log('Terjadi kesalahan pembayaran:', result);
                    alert("Terjadi kesalahan. Silakan coba lagi.");
                },
                onClose: function() {
                    // Catatan: Alert dapat mengganggu. Untuk UX yang lebih baik,
                    // pertimbangkan notifikasi non-blocking di halaman.
                    alert('Transaksi dibatalkan oleh pengguna.');
                }
            });
        });
    </script>
@endpush

<x-layout_user :title="'Halaw - Metode Pembayaran'">
    {{-- Tambahkan id untuk direferensikan oleh <section> demi aksesibilitas --}}
    <h1 id="order-heading" class="title-pembayaran">1. Periksa Pesanan</h1>

    {{-- Gunakan <section> untuk pengelompokan konten tematik utama --}}
    <section class="pay-box" aria-labelledby="order-heading">
        {{-- <article> ideal untuk blok konten mandiri seperti ringkasan pesanan --}}
        <div class="lawyer-information">
            {{-- <header> dapat digunakan untuk mengelompokkan konten pengantar --}}
            <header class="d-flex">
                @if ($lawyer->foto_pengacara)
                    {{-- Teks alt harus deskriptif untuk screen reader --}}
                    <img src="{{ asset('storage/' . $lawyer->foto_pengacara) }}"
                        alt="Foto profil {{ $lawyer->nama_pengacara }}" class="rounded-circle" width="45"
                        height="45">
                @else
                    {{-- Teks alt untuk gambar default juga harus jelas --}}
                    <img src="{{ asset('assets/images/foto-profil-default.jpg') }}" alt="Foto profil    "
                        class="rounded-circle" width="45" height="45">
                @endif
                <div class="ms-3">
                    {{-- <h2> lebih semantik untuk sub-judul --}}
                    <h2 class="lawyer-name">{{ $lawyer->nama_pengacara }}</h2>
                    <p class="lawyer-desc">{{ $lawyer->spesialisasi }}</p>
                    <div class="d-flex gap-2">
                        {{-- <p> lebih sesuai. Ikon disembunyikan dari screen reader --}}
                        <p class="info-badge">
                            @if($lawyer->durasi_pengalaman)
                            <span aria-hidden="true">📁</span> {{ $lawyer->durasi_pengalaman }} tahun
                            @else
                            <span aria-hidden="true">📁</span> 0 tahun
                            @endif
                        </p>
                        <p class="info-badge">
                            <span aria-hidden="true">👥</span> {{ $total_klien }} klien
                        </p>
                    </div>
                </div>
            </header>

            {{-- <hr> adalah elemen semantik untuk pemisah visual --}}
            <hr class="line">

            {{-- Description List (<dl>) adalah cara paling semantik untuk markup key-value --}}
            <dl>
                <div class="d-flex justify-content-between">
                    <dt class="cost-label">Biaya Sesi 1 Jam</dt>
                    <dd class="cost-label">Rp {{ number_format($lawyer->tarif_jasa, 0, ',', '.') }}</dd>
                </div>
                <div class="d-flex justify-content-between">
                    <dt class="cost-label">Biaya Layanan</dt>
                    <dd class="cost-label">Rp 10.000</dd>
                </div>
                <div class="d-flex justify-content-between total-row mt-2">
                    <dt class="total-amount" style="color: #654220">Total Biaya</dt>
                    <dd class="total-amount">Rp {{ number_format($total_biaya, 0, ',', '.') }}</dd>
                </div>
            </dl>
        </div>

        {{-- <footer> cocok untuk tombol aksi yang terkait dengan section ini --}}
        <section class="pay-button">
            {{-- Praktik terbaik: Gunakan <a> yang diberi style seperti tombol, bukan <button> di dalam <a> --}}
            <a href="{{ url()->previous() }}" class="btn btn-lg"
                style="background-color: #B99010; color:#f5f5f5">Batalkan Pesanan</a>

            {{-- Teks tombol harus deskriptif untuk semua pengguna --}}
            <button type="button" id="pay-button" class="btn btn-lg"
                style="background-color: #B99010; color:#f5f5f5">Lanjutkan Pembayaran</button>
        </section>
        </div>
</x-layout_user>

@stack('scripts')
