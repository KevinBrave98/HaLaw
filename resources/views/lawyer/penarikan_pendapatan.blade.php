@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/tarik_pendapatan.css') }}">
@endpush
<x-layout_lawyer>
    <x-slot:title>Penarikan Pendapatan</x-slot:title>
    <div class="container mt-5">
        <h5 class="mb-4" style="color: #2F1D0E;">Penarikan Pendapatan</h5>
        <div class="p-4 rounded" style="background-color: #F1CEAA;">
            <div class="row border border-dark mb-4">
                <div class="col-md-6 p-3 border-end border-dark">
                    <div class="fw-bold mb-1">Informasi Pendapatan</div>
                    <small class="text-muted">Saldo</small>
                    <div class="fs-5">Rp. {{ number_format($saldo, 0, ',', '.') }}</div>
                </div>
                <div class="col-md-6 p-3 position-relative">
                    <div class="text-muted">Rekening Bank Saya</div>
                    <div class="d-flex align-items-center mt-2">
                        <i class="bi bi-bank me-2"></i>
                        <div>
                            <div>{{ $bank }}</div>
                            <div>{{ $nomor_rekening }}</div>
                        </div>
                    </div>
                    <a href="{{ route('lawyer.ubah.rekening') }}"
                        class="position-absolute end-0 bottom-0 me-3 mb-2 fw-bold"
                        style="font-size: 14px; color: #B99010;">Ubah ></a>
                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('lawyer.detail_penarikan') }}" class="btn btn-light px-4 py-2"
                    style="border: 1px solid #fff;">
                    Tarik Pendapatan
                </a>
            </div>
        </div>

        <h5 class="mt-5 mb-3" style="color: #2F1D0E;">Riwayat Dana</h5>
        <div class="rounded p-0 mb-5" style="background-color: #F1CEAA; overflow: scroll; height:40vw;">

            @forelse ($riwayat_tarik as $riwayat)
                @if ($riwayat->tipe_riwayat_dana == 'Tarik Dana')
                    <div class="p-3 border-bottom border-dark">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="fw-bold">{{ $riwayat->tipe_riwayat_dana }}</div>
                                <div class="text-muted">Ke Rekening {{ $nomor_rekening }}</div>
                            </div>
                            <div class="text-dark fw-semibold">-Rp. {{ number_format($riwayat->nominal, 2, ',', '.') }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">{{ $riwayat->created_at }}</small>
                            <span></span>
                        </div>
                    </div>
                @else
                    <div class="p-3 border-bottom border-dark">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="fw-bold">{{ $riwayat->tipe_riwayat_dana }}</div>
                                <div class="text-muted">Dari {{ $riwayat->detail_riwayat_dana }}</div>
                            </div>
                            <div class="text-dark fw-semibold">+Rp. {{ number_format($riwayat->nominal, 2, ',', '.') }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">{{ $riwayat->created_at }}</small>
                            <span></span>
                        </div>
                    </div>
                @endif
                @empty
                    <div class="p-5 text-center text-muted" style="justify-content: center; align-items: center; margin-top: 15vw; font-size: 1.5vw;">
                        Belum ada transaksi
                    </div>
                @endforelse
            </div>
        </div>
        {{-- ini link untuk ikon bootstrap --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    </x-layout_lawyer>
