@push('css')
    {{-- <link rel="stylesheet" href="{{ asset('assets/styles/tarik_pendapatan.css') }}"> --}}
@endpush

<x-layout_lawyer>
    <x-slot:title>Ubah Rekening</x-slot:title>

    {{-- Use <main> for the primary content area for better semantics --}}
    <main class="container mt-5">
        <h1 class="mb-4" style="color: #4A2E19;">Ubah Rekening</h1>

        {{-- Best practice: Use a named route for the action. Use @method('PUT') for updates. --}}
        <form action="" method="POST">
            @csrf
            {{-- @method('POST') Method spoofing for RESTful updates --}}

            <div class="mb-3 row align-items-center">
                <label for="nama_bank" class="col-sm-2 col-form-label" style="color: #4A2E19;">Nama Bank</label>
                <div class="col-sm-4">
                    <select class="form-select @error('nama_bank') is-invalid @enderror" id="nama_bank" name="nama_bank" required>
                        <option value="" disabled>Pilih Bank</option>
                        {{-- Dynamically set the 'selected' attribute based on old input or existing data --}}
                        <option value="BCA" {{ old('nama_bank', $pengacara->nama_bank) == 'BCA' ? 'selected' : '' }}>BCA</option>
                        <option value="Mandiri" {{ old('nama_bank', $pengacara->nama_bank) == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                        <option value="BNI" {{ old('nama_bank', $pengacara->nama_bank) == 'BNI' ? 'selected' : '' }}>BNI</option>
                    </select>
                    {{-- Display validation errors for this field --}}
                    @error('nama_bank')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="mb-1 row align-items-center">
                <label for="nomor_rekening" class="col-sm-2 col-form-label" style="color: #4A2E19;">Nomor Rekening</label>
                <div class="col-sm-4">
                    {{-- Use the 'value' attribute to show old input or existing data --}}
                    <input type="text" class="form-control @error('nomor_rekening') is-invalid @enderror" id="nomor_rekening" name="nomor_rekening"
                           value="{{ old('nomor_rekening', $pengacara->nomor_rekening) }}"
                           placeholder="Masukkan nomor rekening" required aria-describedby="rekening-help">
                    @error('nomor_rekening')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="mb-4 row">
                <div class="offset-sm-2 col-sm-4">
                    {{-- Use an 'id' for the helper text to link it with aria-describedby --}}
                    {{-- Assuming $pengacara->nama_pemilik_rekening exists. Change if needed. --}}
                    <small id="rekening-help" class="form-text text-muted">a/n {{ $pengacara->nama_pemilik_rekening }}</small>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn mt-5 mb-4"
                        style="background-color: #6C4521; color: white; padding: 8px 32px; border-radius: 8px; width: 24vh;">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </main>
</x-layout_lawyer>
