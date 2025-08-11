@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush

<x-layout_lawyer>
    <x-slot:title>Hasil Penarikan</x-slot:title>

    {{-- Gunakan <main> untuk konten utama dan role="alert" agar pesan dibacakan oleh screen reader --}}
    <main class="container mt-5 d-flex justify-content-center align-items-center flex-column text-center"
        style="min-height: 50vh" role="alert">

        {{-- Sembunyikan ikon dekoratif dari screen reader dengan aria-hidden="true" --}}
        <div class="d-flex justify-content-center align-items-center mb-4"
            style="width: 60px; height: 60px; background-color: #C19402; border-radius: 50%;">
            <i class="bi bi-check-lg" style="color: white; font-size: 1.5rem;" aria-hidden="true"></i>
        </div>

        {{-- Gunakan <h1> untuk judul yang paling penting --}}
        <h1 class="text-muted h4">Penarikan Dana Berhasil</h1>

        {{-- Gunakan <p> untuk data pendukung, namun tetap pertahankan tampilan visualnya --}}
        <p class="fw-bold h1" style="color: #6C4521; margin-top: 0;">
            Rp. {{ number_format($total_penarikan, 0, ',', '.') }}
        </p>

        <a href="{{ route('lawyer.penarikan.pendapatan') }}" class="btn mt-4 mb-5"
            style="border: 1px solid #6C4521; color: #6C4521; padding: 6px 24px; border-radius: 8px; width: 50%;">
            Kembali
        </a>

    </main>
</x-layout_lawyer>
