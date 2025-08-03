@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/profil_pengguna.css') }}">
@endpush

<x-layout_user :title="'Profil Pengguna'">

    @if (session('success'))
        {{-- Use role="status" for non-critical success messages --}}
        <div class="alert alert-success text-center" role="status">
            {{ session('success') }}
        </div>
    @endif

    {{-- Use <header> for semantic page structure --}}
    <header class="d-flex justify-content-between bagian-atas">
        <div class="sapaan-foto d-flex flex-column">
            {{-- Use <h2> for a sub-heading, assuming <h1> is in the layout --}}
            <h2 class="fs-3">Halo, {{ $user->nama_pengguna }}</h2>
            <img class="foto-profil"
                 src="{{ $user->foto_pengguna ? asset('storage/' . $user->foto_pengguna) : asset('assets/images/foto-profil-default.jpg') }}"
                 {{-- Add more descriptive alt text --}}
                 alt="Foto profil {{ $user->nama_pengguna }}">
        </div>
        <div class="d-flex justify-content-center">
            {{-- Use a link <a> for navigation, styled as a button --}}
            <a href="{{ route('profile.edit') }}" class="button-edit">Ubah Profil</a>
        </div>
    </header>

    {{-- The data is displayed in what looks like a form. We'll make it accessible. --}}
    <div class="form-profil d-flex align-item-center">
        <div class="form-element nama">
            {{-- Connect label to input with matching 'for' and 'id' --}}
            <label for="nama_pengguna" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control input-nama" value="{{ $user->nama_pengguna }}" readonly id="nama_pengguna">
        </div>
        <div class="form-element nik">
            <label for="nik_pengguna" class="form-label">NIK</label>
            <input type="text" class="form-control input-nik" value="{{ $user->nik_pengguna }}" readonly id="nik_pengguna">
        </div>
        <div class="form-element email">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control input-email" value="{{ $user->email }}" readonly id="email">
        </div>
        <div class="form-element telepon">
            <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
            <input type="text" class="form-control input-telepon" value="{{ $user->nomor_telepon }}" readonly id="nomor_telepon">
        </div>
        <div class="form-element alamat">
            <label for="alamat" class="form-label">Alamat Domisili</label>
            <input type="text" class="form-control input-alamat" value="{{ $user->alamat }} " readonly id="alamat">
        </div>
        <div class="form-element gender">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <input type="text" class="form-control input-gender" value="{{ $user->jenis_kelamin }}" readonly id="jenis_kelamin">
        </div>
        <div class="button-exit d-flex justify-content-center">
             {{-- Use a link <a> for navigation --}}
            <a href="{{ route('profile.exit') }}" class="button-logout">Keluar Akun</a>
            {{-- Note: I changed the class to 'button-logout' for clarity, assuming you can add this class and style it like your other buttons. If not, reuse an existing button class. --}}
        </div>
    </div>
</x-layout_user>