@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/dashboard_user.css') }}">
@endpush
<x-layout_user>
    <x-slot:title>Halaw - Dashboard User</X-slot:title>
    <div class="content">
        <h5 class="username">Hallo {{ $pengguna->nama_pengguna }}</h5>
        <h1 class="rekomendasi">Rekomendasi Pengacara</h1>
        <div class="scroll-wrapper">
            <div class="scroll-container">
                @foreach ($pengacara as $lawyer_card)
                    <div class="lawyer-card">
                        @if ($lawyer_card->foto_pengacara == null)
                            <div class="image_wrapper">
                                <img src="{{ asset('assets/images/lawyer1.jpeg') }}" alt="Fajar Nugroho"
                                    class="lawyer-image">
                            </div>
                        @else
                            <div class="image_wrapper">
                                <img src="{{ asset('storage/' . $lawyer_card->foto_pengacara) }}"
                                    alt="{{ $lawyer_card->nama_pengacara }}" class="lawyer-image">
                            </div>
                        @endif
                        <div class="content-wrapper">
                            <div>
                                <h5 class="nama">{{ $lawyer_card->nama_pengacara }}</h5>
                                <p class="spesialisasi">
                                    Hukum perdata, Hukum pidana, Litigasi & Sengketa...
                                </p>
                                <div class="badges">
                                    <span class="badge-custom">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M6.5 0a.5.5 0 0 0-.5.5V2H3a2 2 0 0 0-2 2v1h14V4a2 2 0 0 0-2-2H10V.5a.5.5 0 0 0-.5-.5h-3zM7 2V1h2v1H7z" />
                                            <path d="M0 5v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V5H0z" />
                                        </svg>
                                        7 - 10 tahun
                                    </span>
                                    <span class="badge-custom">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M13 7c1.105 0 2-.672 2-1.5S14.105 4 13 4s-2 .672-2 1.5S11.895 7 13 7zM6.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm6.5 1c-1.183 0-3.337.356-4.5 1.21C7.337 9.356 5.183 9 4 9c-1.5 0-4 .75-4 2.25V13a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-.75c0-1.5-2.5-2.25-4-2.25z" />
                                        </svg>
                                        40 klien
                                    </span>
                                </div>
                            </div>
                            <div class="price-detail">
                                <div class="harga">Rp. {{ number_format($lawyer_card->tarif_jasa, 0, ',', '.') }}</div>
                                <a href="#" class="btn-detail">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="search-wrapper mx-auto mt-5 d-flex flex-column align-items-center">
        <div class="search-header">Telusuri Pengacara</div>
        <div class="search-bar p-4 rounded-4 d-flex align-items-center">
            <x-search_pengacara></x-search_pengacara>
        </div>
    </div>

    <div class="luaran container">
        <div class="palu">
            <img src="{{ asset('assets/images/gambarPalu.png') }}" alt="">
        </div>
        <div class="isi">
            <h1>Pahami Sebelum Bertindak</h1>
            <h5>Istilah hukum yang jelas adalah langkah pertama menuju keputusan yang benar.</h5>
            <div class="telusuri">
                <button type="button" class="button btn btn-lg">Telusuri Istilah Hukum</button>
            </div>
        </div>
    </div>
    <script>
        const scrollContainer = document.querySelector('.scroll-wrapper');
        let isDown = false;
        let startX;
        let scrollLeft;

        scrollContainer.addEventListener('mousedown', (e) => {
            isDown = true;
            scrollContainer.classList.add('active');
            startX = e.pageX - scrollContainer.offsetLeft;
            scrollLeft = scrollContainer.scrollLeft;
        });

        scrollContainer.addEventListener('mouseleave', () => {
            isDown = false;
            scrollContainer.classList.remove('active');
        });

        scrollContainer.addEventListener('mouseup', () => {
            isDown = false;
            scrollContainer.classList.remove('active');
        });

        scrollContainer.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - scrollContainer.offsetLeft;
            const walk = (x - startX) * 2; // *2 = scroll speed
            scrollContainer.scrollLeft = scrollLeft - walk;
        });
    </script>
    <script src="{{ asset('assets/scripts/search_pengguna.js') }}"></script>
</x-layout_user>
