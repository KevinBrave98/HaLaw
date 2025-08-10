@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/riwayat_konsultasi.css') }}">
    <style>
        /* Additional CSS for riwayat cards */
        .riwayat-card {
            background-color: #fdf5ee;
            border: 2px solid #87680D;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            gap: 20px;
            align-items: flex-start;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .riwayat-card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #ddd;
            flex-shrink: 0;
        }

        .riwayat-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .riwayat-header {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .riwayat-field {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .riwayat-field label {
            font-weight: bold;
            color: #3c2a1a;
            font-size: 14px;
        }

        .riwayat-field input[readonly] {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 8px 10px;
            font-size: 14px;
            background-color: white;
            color: #333;
        }

        .riwayat-rating {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .star-display {
            display: flex;
            gap: 2px;
        }

        .star-display .star {
            font-size: 18px;
            color: #FFC107;
            -webkit-text-stroke: 1px #000000;
            text-stroke: 1px #000000;
        }

        .star-display .star.empty {
            color: #E0E0E0;
        }

        .rating-text {
            font-weight: 600;
            color: #333;
            margin-left: 5px;
        }

        .riwayat-comment {
            width: 100%;
        }

        .riwayat-comment textarea[readonly] {
            width: 100%;
            min-height: 80px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            font-size: 14px;
            background-color: white;
            color: #333;
            resize: none;
            font-family: inherit;
        }

        .no-comment {
            font-style: italic;
            color: #666;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }

        .riwayats-summary {
            background-color: #281805;
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
        }

        .summary-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .summary-stats {
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .riwayat-card {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .riwayat-header {
                grid-template-columns: 1fr;
                width: 100%;
            }

            .riwayat-card img {
                width: 80px;
                height: 80px;
            }
        }
    </style>
@endpush

<x-layout_lawyer :title="'Halaw - Penilaian dan Ulasan'">
    <main>
        {{-- Summary Section --}}
        <section class="container mt-4">
            <div class="riwayats-summary">
                <div class="summary-title">Penilaian dan Ulasan</div>
                <div class="summary-stats">
                    Rata-rata Penilaian: {{ number_format($averageRating, 1) }} dari {{ $sudahReview->count() }} Ulasan
                </div>
            </div>
        </section>

        {{-- Daftar riwayat --}}
        <section class="container mt-4 consultation-list" aria-labelledby="riwayats-heading">
            <h2 id="riwayats-heading" class="visually-hidden">Daftar Penilaian dan Ulasan</h2>

            @forelse ($sudahReview as $riwayat)
                <article class="riwayat-card {{ $loop->first ? 'highlighted' : '' }}"
                         role="article"
                         aria-labelledby="riwayat-{{ $riwayat->id }}">

                    {{-- Client Photo --}}
                    <img src="{{ $riwayat->pengguna->foto_pengguna ? asset('storage/' . $riwayat->pengguna->foto_pengguna) : asset('assets/images/foto-profil-default.jpg') }}"
                        alt="Foto {{ $riwayat->pengguna->nama_pengguna ?? 'Klien' }}"
                        class="client-photo">

                    <div class="riwayat-content">
                        {{-- riwayat Header Info --}}
                        <div class="riwayat-header">
                            <div class="riwayat-field">
                                <label for="client-{{ $riwayat->id }}">Klien</label>
                                <input type="text"
                                       id="client-{{ $riwayat->id }}"
                                       value="{{ $riwayat->pengguna->nama_pengguna ?? 'Nama tidak tersedia' }}"
                                       readonly
                                       aria-label="Nama klien">
                            </div>
                            <div class="riwayat-field">
                                <label for="date-{{ $riwayat->id }}">Tanggal</label>
                                <input type="text"
                                       id="date-{{ $riwayat->id }}"
                                       value="{{ \Carbon\Carbon::parse($riwayat->updated_at)->translatedFormat('l, d F Y') }}"
                                       readonly
                                       aria-label="Tanggal riwayat">
                            </div>
                        </div>

                        {{-- Rating Section --}}
                        <div class="riwayat-field">
                            <label>Nilai</label>
                            <div class="riwayat-rating"
                                 role="img"
                                 aria-label="Rating {{ $riwayat->penilaian }} dari 5 bintang">
                                <div class="star-display" aria-hidden="true">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="star {{ $i <= $riwayat->penilaian ? '' : 'empty' }}">★</span>
                                    @endfor
                                </div>
                                <span class="rating-text">{{ $riwayat->penilaian }}/5</span>
                            </div>
                        </div>

                        {{-- Comment Section --}}
                        <div class="riwayat-field riwayat-comment">
                            <label for="comment-{{ $riwayat->id }}">Komentar</label>
                            @if($riwayat->ulasan)
                                <textarea id="comment-{{ $riwayat->id }}"
                                          readonly
                                          aria-label="Komentar ulasan">{{ $riwayat->ulasan }}</textarea>
                            @else
                                <div class="no-comment">Tidak ada komentar yang diberikan</div>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="text-center mt-5">
                    <p class="empty-message">Belum ada penilaian dan ulasan</p>
                </div>
            @endforelse
        </section>
    </main>
</x-layout_lawyer>
