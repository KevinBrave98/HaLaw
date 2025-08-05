@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/profil_pengacara.css') }}">
@endpush

<x-layout_lawyer :title="'Profil Pengacara'">

    {{-- 1. Menggunakan <header> untuk bagian atas agar lebih semantik --}}
    <header class="d-flex justify-content-between bagian-atas">
        <div class="sapaan-foto d-flex flex-column">
            <h2 class="fs-3">Halo, {{ $user->nama_pengacara }}</h2>
            <img id="preview-foto" class="foto-profil-preview"
                src="{{ $user->foto_pengacara ? asset('storage/' . $user->foto_pengacara) : asset('assets/images/foto-profil-default.jpg') }}"
                {{-- 2. Alt text dibuat lebih deskriptif untuk aksesibilitas --}} alt="Foto profil {{ $user->nama_pengacara }}">
        </div>
        <div class="d-flex justify-content-center">
            {{-- Menggunakan <a> untuk navigasi adalah praktik yang lebih baik --}}
            <a href="{{ route('lawyer.profile.edit') }}" class="button-edit" role="button">Ubah Profil</a>
        </div>
    </header>

    {{-- 3. Menggunakan <main> untuk area konten utama --}}
    <main class="form-profil d-flex align-item-center">

        {{-- 4. SETIAP LABEL KINI TERHUBUNG DENGAN INPUT-NYA VIA `for` DAN `id` --}}
        <div class="form-element nama">
            <label for="nama_pengacara" class="form-label">Nama Lengkap</label>
            <input readonly type="text" id="nama_pengacara" class="form-control input-nama"
                value="{{ $user->nama_pengacara }}">
        </div>
        <div class="form-element nik">
            <label for="nik_pengacara" class="form-label">NIK</label>
            <input readonly type="text" id="nik_pengacara" class="form-control input-nik"
                value="{{ $user->nik_pengacara }}">
        </div>
        <div class="form-element email">
            <label for="email" class="form-label">Email</label>
            <input readonly type="email" id="email" class="form-control input-email" value="{{ $user->email }}">
        </div>
        <div class="form-element telepon">
            <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
            <input readonly type="text" id="nomor_telepon" class="form-control input-telepon"
                value="{{ $user->nomor_telepon }}">
        </div>
        <div class="form-element lokasi">
            <label for="lokasi" class="form-label">Lokasi Tempat Kerja</label>
            <input readonly type="text" id="lokasi" class="form-control input-lokasi" value="{{ $user->lokasi }}">
        </div>
        <div class="form-element tarifJasa">
            <label for="tarif_jasa" class="form-label">Tarif jasa</label>
            <input readonly type="text" id="tarif_jasa" class="form-control input-tarifJasa"
                value="{{ $user->tarif_jasa }}">
        </div>
        <div class="form-element spesialisasi">
            <label for="spesialisasi" class="form-label">Spesialisasi</label>
            <input readonly type="text" id="spesialisasi" class="form-control input-spesialisasi"
                value="@if ($user->spesialisasis && $user->spesialisasis->count() > 0){{ Str::limit($user->spesialisasis->pluck('nama_spesialisasi')->implode(', '), 50, '...') }}@else Tidak Ada Spesialisasi @endif">
        </div>
        <div class="form-element pendidikan">
            <label for="pendidikan" class="form-label">Informasi Pendidikan</label>
            <textarea readonly id="pendidikan" class="form-control input-pendidikan" rows="4">{{ $user->pendidikan }}</textarea>
        </div>
        <div class="form-element pengalaman">
            <label for="pengalaman_bekerja" class="form-label">Pengalaman Kerja</label>
            <textarea readonly id="pengalaman_bekerja" class="form-control input-pendidikan" rows="8">{{ $user->pengalaman_bekerja }}</textarea>
        </div>
        <div class="form-element durasi_kerja">
            <label for="durasi_pengalaman" class="form-label">Durasi Pengalaman Kerja</label>
            <input readonly type="text" id="durasi_pengalaman" class="form-control input-spesialisasi"
                value="{{ $user->durasi_pengalaman }}">
        </div>
        <div class="form-element gender">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <input readonly type="text" id="jenis_kelamin" class="form-control input-text"
                value="{{ $user->jenis_kelamin }}">
        </div>

        @php
            $layanan = [];
            if ($user->chat) {
                $layanan[] = 'Pesan';
            }
            if ($user->voice_chat) {
                $layanan[] = 'Panggilan Suara';
            }
            if ($user->video_call) {
                $layanan[] = 'Panggilan Video';
            }
        @endphp

        <div class="form-element jenis_layanan">
            <label for="jenis_layanan" class="form-label">Jenis Layanan</label>
            <input readonly type="text" id="jenis_layanan" class="form-control input-text"
                value="{{ implode(', ', $layanan) ?: 'Tidak ada layanan' }}">
        </div>

        {{-- 5. Tombol keluar yang aman menggunakan form POST --}}
        <div class="button-exit d-flex justify-content-center">
            <form action="{{ route('lawyer.profile.exit') }}" method="POST"
                onsubmit="return confirm('Apakah Anda yakin ingin keluar?');">
                @csrf
                <button type="submit">Keluar Akun</button>
            </form>
        </div>

    </main>
</x-layout_lawyer>
