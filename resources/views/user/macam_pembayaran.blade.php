@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/macam_pembayaran.css') }}">
@endpush
@push('js')
    @vite('resources/js/payment.js')
@endpush
<x-layout_user :title="'Halaw - Metode Pembayaran'">
    <h1 class="title-pembayaran">2. Pilih Metode Pembayaran</h1>
    <div class="pay-box">
        <div class="accordion" id="paymentAccordion">

        <!-- Credit Card -->
        <div class="accordion-item" id="credit-card">
            <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button collapsed d-flex align-items-center" type="button"
                data-bs-toggle="collapse" data-bs-target="#collapseOne">
                <span class="dot"></span> Credit Card / Debit Online
            </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
            <div class="accordion-body">
                <div class="info-box">⚠️ Minimum transaksi Rp.100.000</div>
                <p>Tipe Credit card yang dapat digunakan:</p>
                <div class="card-icons">
                <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png" alt="VISA">
                <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png" alt="MasterCard">
                <img src="https://upload.wikimedia.org/wikipedia/commons/1/1e/JCB_logo.svg" alt="JCB">
                </div>
            </div>
            </div>
        </div>

        <!-- QRIS -->
        <div class="accordion-item" id="qris">
            <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed d-flex align-items-center" type="button"
                data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                <span class="dot"></span> QRIS
            </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
                <div class="accordion-body">
                    Cara Pembayaran <br>
                    1. Buka aplikasi e-wallet atau mobile banking (GoPay, OVO, DANA, BCA Mobile, dll).<br>
                    2. Pilih menu Scan QR atau Bayar.<br>
                    3. Arahkan kamera ke QR code yang ditampilkan. <br>
                    4. Periksa detail pembayaran dan konfirmasi. <br>
                    5. Setelah berhasil, klik tombol "Saya Sudah Bayar" di bawah ini. <br>
                </div>
            </div>
        </div>

        <!-- BCA VA -->
        <div class="accordion-item" id="bca-va">
            <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed d-flex align-items-center" type="button"
                data-bs-toggle="collapse" data-bs-target="#collapseThree">
                <span class="dot"></span> BCA Virtual Account
            </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
            <div class="accordion-body">
                Cara Pembayaran <br>
                    1. Buka aplikasi BCA Mobile, KlikBCA, atau ke ATM BCA.<br>
                    2. Pilih menu Transfer > ke Rekening Virtual Account.<br>
                    3. Masukkan nomor VA: 88081XXXXXXXXXX (contoh). <br>
                    4. Periksa nama penerima dan jumlah tagihan. <br>
                    5. Konfirmasi dan selesaikan pembayaran. <br>
            </div>
            </div>
        </div>

        <!-- Mandiri VA -->
        <div class="accordion-item" id="mandiri-va">
            <h2 class="accordion-header" id="headingFour">
            <button class="accordion-button collapsed d-flex align-items-center" type="button"
                data-bs-toggle="collapse" data-bs-target="#collapseFour">
                <span class="dot"></span> Mandiri Virtual Account
            </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
            <div class="accordion-body">
                Cara Pembayaran <br>
                1. Buka aplikasi Livin' by Mandiri atau kunjungi ATM Mandiri.<br>
                Pilih menu Bayar > Multipayment.<br>
                2. Masukkan kode penyedia layanan atau pilih penyedia yang sesuai.<br>
                3. Masukkan Nomor Virtual Account: 88710XXXXXXXXXX (contoh).<br>
                4. Periksa nama penerima dan jumlah tagihan.<br>
                5. Konfirmasi dan selesaikan pembayaran.<br>
            </div>
            </div>
        </div>

        <!-- blu by BCA -->
        <div class="accordion-item" id="blu-va">
            <h2 class="accordion-header" id="headingFive">
            <button class="accordion-button collapsed d-flex align-items-center" type="button"
                data-bs-toggle="collapse" data-bs-target="#collapseFive">
                <span class="dot"></span> blu by BCA Digital
            </button>
            </h2>
            <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
            <div class="accordion-body">
                Cara Pembayaran <br>
                    1. Buka aplikasi blu by BCA.<br>
                    2. Pilih menu Transfer > Virtual Account.<br>
                    3. Pilih bank tujuan sesuai instruksi (contoh: BCA atau Mandiri).<br>
                    4. Masukkan nomor VA: 88081XXXXXXXXXX (contoh). <br>
                    5. Periksa nama penerima dan jumlah tagihan. <br>
                    6. Konfirmasi dan selesaikan pembayaran. <br>
            </div>
            </div>
        </div>

        <!-- GoPay -->
        <div class="accordion-item" id="gopay">
            <h2 class="accordion-header" id="headingSix">
            <button class="accordion-button collapsed d-flex align-items-center" type="button"
                data-bs-toggle="collapse" data-bs-target="#collapseSix">
                <span class="dot"></span> GoPay / GoPay Later
            </button>
            </h2>
            <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
            <div class="accordion-body">
                Cara Pembayaran <br>
                    1. Buka aplikasi GoPay.<br>
                    2. Pilih menu Bayar > Ke Rekening Bank.<br>
                    3. Pilih bank tujuan sesuai instruksi (contoh: BCA atau Mandiri).<br>
                    4. Masukkan nomor VA: 88081XXXXXXXXXX (contoh). <br>
                    5. Periksa nama penerima dan jumlah tagihan. <br>
                    6. Konfirmasi dan selesaikan pembayaran dengan PIN GoPay. <br>
            </div>
            </div>
        </div>

        <!-- OVO -->
        <div class="accordion-item" id="ovo">
            <h2 class="accordion-header" id="headingSeven">
            <button class="accordion-button collapsed d-flex align-items-center" type="button"
                data-bs-toggle="collapse" data-bs-target="#collapseSeven">
                <span class="dot"></span> OVO
            </button>
            </h2>
            <div id="collapseSeven" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
            <div class="accordion-body">
                Cara Pembayaran <br>
                    1. Buka aplikasi OVO.<br>
                    2. Pilih menu Bayar > Ke Rekening Bank.<br>
                    3. Pilih bank tujuan sesuai instruksi (contoh: BCA atau Mandiri).<br>
                    4. Masukkan nomor VA: 88081XXXXXXXXXX (contoh). <br>
                    5. Periksa nama penerima dan jumlah tagihan. <br>
                    6. Konfirmasi dan selesaikan pembayaran dengan PIN OVO. <br>
            </div>
            </div>
        </div>

        <!-- Shopee Pay -->
        <div class="accordion-item" id="shopeepay">
            <h2 class="accordion-header" id="headingEight">
            <button class="accordion-button collapsed d-flex align-items-center" type="button"
                data-bs-toggle="collapse" data-bs-target="#collapseEight">
                <span class="dot"></span> Shopee Pay / SPayLater
            </button>
            </h2>
            <div id="collapseEight" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
            <div class="accordion-body">
                Cara Pembayaran <br>
                    1. Buka aplikasi Shopee, masuk ke ShopeePay.<br>
                    2. Pilih menu Bayar > Ke Rekening Bank.<br>
                    3. Pilih bank tujuan sesuai instruksi (contoh: BCA atau Mandiri).<br>
                    4. Masukkan nomor VA: 88081XXXXXXXXXX (contoh). <br>
                    5. Periksa nama penerima dan jumlah tagihan. <br>
                    6. Konfirmasi dan selesaikan pembayaran dengan PIN ShopeePay. <br>
            </div>
            </div>
        </div>
        </div>
        <div class="pay-button">
                <a href="{{ route('pembayaran.pengacara') }}"><button type="button" class="btn btn-lg" style="background-color: #B99010; color:#f5f5f5"><</button></a>
                <button type="button" class="btn btn-lg" style="background-color: #B99010; color:#f5f5f5" id="next-button">></button>
        </div>
    </div>
            
</x-layout_user>