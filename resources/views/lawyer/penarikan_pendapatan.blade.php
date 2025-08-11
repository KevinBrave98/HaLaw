@push('css')
    {{-- It's good practice to keep all stylesheet links together --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush

<x-layout_lawyer>
    <x-slot:title>Penarikan Pendapatan</x-slot:title>

    {{-- Use <main> as the primary content container for the page --}}
    <main class="container mt-5">
        <h1 class="mb-4" style="color: #2F1D0E;">Penarikan Pendapatan</h1>

        {{-- Use <section> to group related content --}}
        <section class="p-4 rounded" style="background-color: #F1CEAA;" aria-labelledby="pendapatan-heading">
            <div class="row border border-dark mb-4">
                <div class="col-md-6 p-3 border-end border-dark">
                    {{-- Use proper heading levels for structure --}}
                    <h2 class="fw-bold mb-1" id="pendapatan-heading" style="font-size: 1rem;">Informasi Pendapatan</h2>
                    <p class="text-muted mb-0">Saldo</p>
                    <div class="fs-5">Rp. {{ number_format($saldo, 0, ',', '.') }}</div>
                </div>
                <div class="col-md-6 p-3 position-relative">
                    <h2 class="text-muted" style="font-size: 1rem;">Rekening Bank Saya</h2>
                    <div class="d-flex align-items-center mt-2">
                        {{-- Add aria-hidden to decorative icons to hide them from screen readers --}}
                        <i class="bi bi-bank me-2" aria-hidden="true"></i>
                        <div>
                            <div>{{ $bank }}</div>
                            <div>{{ $nomor_rekening }}</div>
                        </div>
                    </div>
                    {{-- Add aria-label to give context to ambiguous links --}}
                    <a href="{{ route('lawyer.ubah.rekening') }}"
                        class="position-absolute end-0 bottom-0 me-3 mb-2 fw-bold"
                        style="font-size: 14px; color: #B99010;"
                        aria-label="Ubah rekening bank">Ubah ></a>
                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('lawyer.detail_penarikan') }}" class="btn btn-light px-4 py-2"
                    style="border: 1px solid #fff;">
                    Tarik Pendapatan
                </a>
            </div>
        </section>

        {{-- A new section for the fund history --}}
        <section class="mt-5 mb-5">
            <h2 class="mb-3" style="color: #2F1D0E;">Riwayat Dana</h2>

            {{-- Use an ordered list (<ol>) for chronological history --}}
            <ol class="rounded p-0 m-0" style="background-color: #F1CEAA; overflow-y: auto; height:40vw; list-style: none;">
                @forelse ($riwayat_tarik as $riwayat)
                    {{-- Each history item is a list item (<li>) --}}
                    <li class="p-3 border-bottom border-dark">
                        @if ($riwayat->tipe_riwayat_dana == 'Tarik Dana')
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="fw-bold">{{ $riwayat->tipe_riwayat_dana }}</div>
                                    <div class="text-muted">Ke Rekening {{ $nomor_rekening }}</div>
                                </div>
                                {{-- Add a descriptive aria-label for monetary values --}}
                                <div class="text-dark fw-semibold" aria-label="Penarikan sebesar {{ number_format($riwayat->nominal, 0, ',', '.') }} rupiah">
                                    -Rp. {{ number_format($riwayat->nominal, 2, ',', '.') }}
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">{{ $riwayat->created_at->format('d F Y, H:i') }}</small>
                            </div>
                        @else
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="fw-bold">{{ $riwayat->tipe_riwayat_dana }}</div>
                                    <div class="text-muted">Dari {{ $riwayat->detail_riwayat_dana }}</div>
                                </div>
                                <div class="text-dark fw-semibold" aria-label="Penambahan sebesar {{ number_format($riwayat->nominal, 0, ',', '.') }} rupiah">
                                    +Rp. {{ number_format($riwayat->nominal, 2, ',', '.') }}
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                {{-- It's good practice to format the date for consistency --}}
                                <small class="text-muted">{{ $riwayat->created_at->format('d F Y, H:i') }}</small>
                            </div>
                        @endif
                    </li>
                @empty
                    {{-- The empty state should also be a list item for valid HTML --}}
                    <li class="p-5 text-center text-muted" style="justify-content: center; align-items: center; font-size: 1.5rem; height: 100%; display:flex;">
                        Belum ada transaksi
                    </li>
                @endforelse
            </ol>
        </section>
    </main>
</x-layout_lawyer>
