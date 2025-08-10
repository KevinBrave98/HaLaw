@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/tarik_pendapatan.css') }}">
    {{-- It's best practice to load all CSS in the <head> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush

<x-layout_lawyer>
    <x-slot:title>Penarikan Gagal</x-slot:title>

    {{-- Use <main> for the primary content and role="alert" for important failure messages --}}
    <main class="container mt-5 d-flex justify-content-center align-items-center flex-column text-center"
        style="min-height: 50vh" role="alert">

        {{-- Use a more appropriate background color for a failure/error status --}}
        <div class="d-flex justify-content-center align-items-center mb-4"
            style="width: 60px; height: 60px; background-color: #dc3545; border-radius: 50%;">
            {{-- Hide decorative icons from screen readers --}}
            <i class="bi bi-x-lg" style="color: white; font-size: 1.5rem;" aria-hidden="true"></i>
        </div>

        {{-- Use <h1> for the most important message on the page --}}
        <h1 class="h4">Penarikan Dana Gagal</h1>

        {{-- Use <p> for supporting data, but keep the visual style --}}
        <p class="fw-bold h1" style="color: #6C4521; margin-top: 0;">
            Rp. {{ number_format($total_penarikan, 0, ',', '.') }}
        </p>

        {{-- Add a descriptive paragraph to help the user understand the error --}}
        <p class="text-muted mt-2">
            @if (session('error_message'))
                {{ session('error_message') }}
            @else
                Ini bisa terjadi karena saldo tidak mencukupi atau ada gangguan teknis.
            @endif
        </p>

        <a href="{{ route('lawyer.penarikan.pendapatan') }}" class="btn mt-4 mb-5"
            style="border: 1px solid #6C4521; color: #6C4521; padding: 6px 24px; border-radius: 8px; width: 50%;">
            Coba Lagi
        </a>
    </main>
</x-layout_lawyer>