<footer>
    <div class="footer-main">
        {{-- Kolom Kiri: Logo & Media Sosial --}}
        <div class="footer-column footer-logo-social">
            <img src="{{ asset('assets/images/Logo.png') }}" alt="Logo HaLaw" class="footer-logo">
            
            {{-- Daftar link media sosial yang lebih semantik --}}
            <ul class="social-links">
                <li>
                    <a href="https://www.instagram.com/halaw" target="_blank" rel="noopener noreferrer" aria-label="Instagram HaLaw">
                        <img src="{{ asset('assets/images/icon_instagram.png') }}" alt="Instagram">
                    </a>
                </li>
                <li>
                    <a href="https://www.facebook.com/halaw" target="_blank" rel="noopener noreferrer" aria-label="Facebook HaLaw">
                        <img src="{{ asset('assets/images/icon_facebook-line.png') }}" alt="Facebook">
                    </a>
                </li>
                <li>
                    <a href="https://twitter.com/halaw" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter) HaLaw">
                        <img src="{{ asset('assets/images/icon_twitter.png') }}" alt="X">
                    </a>
                </li>
                <li>
                    <a href="https://www.linkedin.com/company/halaw" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn HaLaw">
                        <img src="{{ asset('assets/images/icon_linkedin.png') }}" alt="LinkedIn">
                    </a>
                </li>
            </ul>
        </div>

        {{-- Kolom Tengah: Tentang Kami --}}
        <div class="footer-column footer-about">
            <h2>Tentang Kami</h2>
            <p>HaLaw merupakan platform layanan hukum digital yang menyediakan akses cepat, mudah, dan terpercaya kepada pengacara profesional. Kami hadir untuk menjawab kebutuhan masyarakat akan konsultasi hukum yang efisien dan terjangkau. Dengan HaLaw, urusan hukum menjadi lebih jelas, terarah, dan dapat diakses oleh siapa saja.</p>
        </div>

        {{-- Kolom Kanan: Kontak Kami --}}
        <div class="footer-column footer-contact">
            <h2>Kontak Kami</h2>
            <ul class="contact-info">
                <li>
                    <img src="{{ asset('assets/images/icon_call.png') }}" alt="Telepon" class="contact-icon">
                    {{-- Menggunakan link 'tel:' agar bisa langsung ditelepon dari mobile --}}
                    <a href="tel:+622112345678">(021) 1234 5678</a>
                </li>
                <li>
                    <img src="{{ asset('assets/images/icon_mail.png') }}" alt="Email" class="contact-icon">
                    {{-- Menggunakan link 'mailto:' agar bisa langsung membuka aplikasi email --}}
                    <a href="mailto:halawcare@halaw.com">halawcare@halaw.com</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        {{-- Menggunakan tag <small> untuk teks copyright yang lebih semantik --}}
        <small>© 2025 HaLaw. Hak cipta dilindungi undang-undang.</small>
    </div>
</footer>