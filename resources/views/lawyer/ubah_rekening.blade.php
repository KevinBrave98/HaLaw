@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/tarik_pendapatan.css') }}">
@endpush
<x-layout_lawyer>
    <x-slot:title>Ubah Rekening</x-slot:title>
    <div class="container mt-5">
        <h1 class="mb-4" style="color: #4A2E19;">Ubah Rekening</h1>

        <form action= " " method="POST">
            @csrf
{{-- {{ old('nama_bank', $pengacara->nama_bank) == 'BNI' ? 'selected' : '' }} --}}
            <div class="mb-3 row align-items-center">
                <label for="nama_bank" class="col-sm-2 col-form-label" style="color: #4A2E19;">Nama Bank</label>
                <div class="col-sm-4">
                    <select class="form-select" id="nama_bank" name="nama_bank" required>
                        <option selected disabled>Pilih Bank</option>
                        <option value="BCA" selected>BCA</option>
                        <option value="Mandiri">Mandiri</option>
                        <option value="BNI">BNI</option>
                    </select>
                </div>
            </div>

            <div class="mb-1 row align-items-center">
                <label for="nomor_rekening" class="col-sm-2 col-form-label" style="color: #4A2E19;">Nomor
                    Rekening</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="nomor_rekening" name="nomor_rekening"
                        placeholder="Masukkan nomor rekening" required>
                </div>
            </div>

            <div class="mb-4 row">
                <div class="offset-sm-2 col-sm-4">
                    <small class="form-text text-muted">a/n [Nama Pengguna di Rekening]</small>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn mt-5 mb-4"
                    style="background-color: #6C4521; color: white; padding: 8px 32px; border-radius: 8px; width: 24vh;">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-layout_lawyer>
