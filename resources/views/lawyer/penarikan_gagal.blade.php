@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/tarik_pendapatan.css') }}">
@endpush

<x-layout_lawyer>
    <x-slot:title>Hasil Penarikan</x-slot:title>

    <div class="w-auto container mt-5 d-flex justify-content-center align-items-center flex-column"
        style="min-height: 40vh">
        <div class="d-flex justify-content-center align-items-center mb-5"
            style="width: 60px; height: 60px; background-color: #C19402; border-radius: 50%;">
            <i class="bi bi-x-lg" style="color: white; font-size: 1.5rem;"></i>
        </div>
        <div class="container d-flex row justify-content-center align-items-center text-center">
            <h4 class="text-muted">Penarikan Dana Gagal</h4> {{-- opsional ubah teks juga --}}
            <h1 class="fw-bold" style="color: #6C4521;">Rp. {{ number_format($total_penarikan, 0, ',', '.') }}</h1>
        </div>
    </div>

    <div class="container d-flex justify-content-center mb-5">
        <a href="{{ route('lawyer.penarikan.pendapatan') }}" class="btn mb-4"
            style="border: 1px solid #6C4521; color: #6C4521; padding: 6px 24px; border-radius: 8px; width: 12vw;">
            Coba Lagi
        </a>
    </div>

    {{-- Link Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</x-layout_lawyer>
