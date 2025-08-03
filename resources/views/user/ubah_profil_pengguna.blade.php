@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/ubah_profil_pengguna.css') }}">
@endpush

<x-layout_user :title="'Ubah Profil'">
    {{-- Use <header> for the top section for better semantic structure --}}
    <header class="d-flex justify-content-between bagian-atas">
        {{-- Add aria-label for better screen reader context --}}
        <a class="button-back" href="{{ route('profile.show') }}" aria-label="Kembali ke halaman profil">
            <img src="{{ asset('assets/images/icon-back.png') }}" alt="Tombol kembali">
        </a>
        <div class="sapaan-foto d-flex flex-column">
            {{-- Use <h2> assuming <h1> is the main page title in the layout --}}
            <h2 class="fs-3">Halo, {{ $user->nama_pengguna }}</h2>
            <img id="preview-foto" class="foto-profil-preview"
                 src="{{ $user->foto_pengguna ? asset('storage/' . $user->foto_pengguna) : asset('assets/images/foto-profil-default.jpg') }}"
                 {{-- More descriptive alt text --}}
                 alt="Foto profil {{ $user->nama_pengguna }}">
        </div>
        <div class="d-flex align-item-center justify-content-center">
            <button type="button" class="button-edit">Ubah Profil</button>
        </div>
    </header>

    @if ($errors->any())
        {{-- Add role="alert" to make error announcements more immediate for screen readers --}}
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-profil d-flex align-item-center">
            <div class="form-element foto">
                {{-- Ensure 'for' attribute matches the input 'id' --}}
                <label for="foto_pengguna" class="form-label">Foto Profil</label>
                <input type="file" name="foto_pengguna" class="form-control" id="foto_pengguna">
            </div>
            <div class="form-element nama">
                {{-- Connect label to input with matching 'for' and 'id' --}}
                <label for="nama_pengguna" class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_pengguna" class="form-control input-text"
                       value="{{ $user->nama_pengguna }}" id="nama_pengguna">
            </div>
            <div class="form-element nik">
                 {{-- Connect label to input, even for readonly fields --}}
                <label for="nik_pengguna" class="form-label">NIK</label>
                <input type="text" class="form-control input-nik" value="{{ $user->nik_pengguna }}" readonly id="nik_pengguna">
            </div>
            <div class="form-element email">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control input-text" value="{{ $user->email }}" id="email">
            </div>
            <div class="form-element telepon">
                <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                <input type="text" name="nomor_telepon" class="form-control input-text"
                       value="{{ $user->nomor_telepon }}" id="nomor_telepon">
            </div>
            <div class="form-element alamat">
                <label for="alamat" class="form-label">Alamat Domisili</label>
                <input type="text" name="alamat" class="form-control input-text" value="{{ $user->alamat }}" id="alamat">
            </div>

            {{-- Use <fieldset> and <legend> to group related radio buttons --}}
            <fieldset class="form-element gender">
                <legend class="form-label">Jenis Kelamin</legend>
                <div class="d-flex justify-content-between gender-opsi">
                    <div class="form-radio">
                        <input class="form-check-input square-radio" type="radio" name="jenis_kelamin" id="laki"
                               value="Laki - Laki" {{ $user->jenis_kelamin == 'Laki - Laki' ? 'checked' : '' }}>
                        <label class="form-check-label" for="laki">Laki – Laki</label>
                    </div>

                    <div class="form-radio">
                        <input class="form-check-input square-radio" type="radio" name="jenis_kelamin" id="perempuan"
                               value="Perempuan" {{ $user->jenis_kelamin == 'Perempuan' ? 'checked' : '' }}>
                        <label class="form-check-label" for="perempuan">Perempuan</label>
                    </div>

                    <div class="form-radio">
                        <input class="form-check-input square-radio" type="radio" name="jenis_kelamin"
                               id="tidak_jawab" value="Memilih Tidak Menjawab"
                               {{ $user->jenis_kelamin == 'Memilih Tidak Menjawab' ? 'checked' : '' }}>
                        <label class="form-check-label" for="tidak_jawab">Memilih Tidak Menjawab</label>
                    </div>
                </div>
            </fieldset>

            <div class="button-save d-flex justify-content-center">
                <button type="submit">Simpan Perubahan</button>
            </div>
        </div>
    </form>
    <script src="{{ asset('assets/scripts/ubah_profil_pengguna.js') }}"></script>
</x-layout_user>