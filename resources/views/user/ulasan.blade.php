{{-- Menggunakan layout utama untuk user --}}
<x-layout_user :title="'Halaw - Penilaian dan Ulasan'">

    {{-- Push CSS khusus untuk halaman ini --}}
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/styles/penilaian.css') }}">
    @endpush

    {{-- KONTEN UTAMA HALAMAN --}}
    <main class="container py-5">
        {{-- Menambahkan kelas .penilaian-card dan menghapus style inline --}}
        <section class="penilaian-card">

            <header class="text-center mb-4">
                <h1>Penilaian dan Ulasan</h1>
            </header>

            {{-- Tambahkan notifikasi sukses/error di atas form --}}
            {{-- Tampilkan notifikasi sukses/error --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($sudahReview)
                <div class="alert alert-info" role="alert" aria-live="polite">
                    <h5>
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        Penilaian Sudah Diberikan
                    </h5>
                    <p>Anda telah memberikan penilaian untuk konsultasi ini pada
                        {{ $riwayat->updated_at->format('d F Y, H:i') }}.</p>
                </div>

                <section class="penilaian-card" aria-labelledby="penilaian-heading">
                    <div class="text-center mb-4">
                        <h4 id="penilaian-heading">Penilaian Anda</h4>
                    </div>

                    {{-- * Tampilkan rating yang sudah diberikan * --}}
                    <div class="mb-4">
                        <h5 class="form-label" id="rating-label">Penilaian:</h5>
                        <div class="display-rating-container" role="img" aria-labelledby="rating-label"
                            aria-describedby="rating-description">

                            {{-- Screen reader description --}}
                            <div id="rating-description" class="sr-only" >
                                Rating {{ $riwayat->penilaian }} dari 5 bintang
                            </div>

                            @for ($i = 1; $i <= 5; $i++)
                                {{-- * Wrapper untuk mengatur ukuran setiap bintang * --}}
                                <div class="display-star-wrapper" aria-hidden="true">
                                    <svg viewBox="0 0 51 48"
                                        class="{{ $i <= $riwayat->penilaian ? 'star-filled' : 'star-empty' }}"
                                        focusable="false">
                                        <path d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"></path>
                                    </svg>
                                </div>
                            @endfor

                            {{-- Visible text for sighted users --}}
                            <span class="rating-text ms-2" aria-hidden="true">
                                ({{ $riwayat->penilaian }}/5)
                            </span>
                        </div>
                    </div>

                    {{-- * Tampilkan ulasan jika ada * --}}
                    @if ($riwayat->ulasan)
                        <div class="mb-4">
                            <h5 class="form-label" id="ulasan-label">Ulasan Anda:</h5>
                            <div class="p-3 bg-light rounded" role="region" aria-labelledby="ulasan-label"
                                tabindex="0">
                                <p class="mb-0">{{ $riwayat->ulasan }}</p>
                            </div>
                        </div>
                    @else
                        <div class="mb-4">
                            <h5 class="form-label">Ulasan:</h5>
                            <p class="text-muted fst-italic">Tidak ada ulasan yang diberikan.</p>
                        </div>
                    @endif

                    <div class="text-center">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary" role="button">
                            Kembali
                        </a>
                    </div>
                </section>
            @else
                {{-- TAMPILAN FORM JIKA BELUM REVIEW --}}
                <form action="{{ route('user.ulasan.submit', $id) }}" method="POST">
                    @csrf

                    {{-- * 1. BAGIAN PENILAIAN BINTANG * --}}
                    <fieldset class="mb-4">
                        <legend class="form-label">
                            Nilai <span class="text-danger" aria-hidden="true">*</span>
                        </legend>
                        <div role="group" aria-labelledby="nilaiLabel"
                            class="d-flex align-items-center justify-content-between rounded-3 p-3 rating-box">
                            <span class="text-muted">Sangat Buruk</span>
                            <div class="star-rating">
                                <input type="radio" id="star5" name="rating" value="5" required
                                    {{ old('rating') == '5' ? 'checked' : '' }}>
                                <label for="star5" title="Sangat Baik" aria-label="Beri nilai 5 dari 5">★</label>

                                <input type="radio" id="star4" name="rating" value="4"
                                    {{ old('rating') == '4' ? 'checked' : '' }}>
                                <label for="star4" title="Baik" aria-label="Beri nilai 4 dari 5">★</label>

                                <input type="radio" id="star3" name="rating" value="3"
                                    {{ old('rating') == '3' ? 'checked' : '' }}>
                                <label for="star3" title="Cukup" aria-label="Beri nilai 3 dari 5">★</label>

                                <input type="radio" id="star2" name="rating" value="2"
                                    {{ old('rating') == '2' ? 'checked' : '' }}>
                                <label for="star2" title="Buruk" aria-label="Beri nilai 2 dari 5">★</label>

                                <input type="radio" id="star1" name="rating" value="1"
                                    {{ old('rating') == '1' ? 'checked' : '' }}>
                                <label for="star1" title="Sangat Buruk" aria-label="Beri nilai 1 dari 5">★</label>
                            </div>
                            <span class="text-muted">Sangat Baik</span>
                        </div>
                        @error('rating')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    {{-- * 2. BAGIAN ULASAN TEKS (OPSIONAL) * --}}
                    <div class="mb-5">
                        <label for="ulasan" class="form-label">
                            Ulasan <span class="text-muted">(Opsional)</span>
                        </label>
                        <textarea class="form-control @error('ulasan') is-invalid @enderror" id="ulasan" name="ulasan" rows="6"
                            placeholder="Bagikan pengalaman konsultasi Anda di sini (opsional)...">{{ old('ulasan') }}</textarea>
                        @error('ulasan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Ulasan bersifat opsional, Anda boleh
                            mengosongkannya.</small>
                    </div>

                    {{-- * 3. TOMBOL SUBMIT * --}}
                    <div class="text-center">
                        <button type="submit" class="btn btn-submit-ulasan">Kirim Penilaian</button>
                    </div>
                </form>
            @endif

        </section>
    </main>

</x-layout_user>
