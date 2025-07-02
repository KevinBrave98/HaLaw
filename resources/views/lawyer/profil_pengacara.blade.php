@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/profil_pengacara.css') }}">
@endpush
<x-layout_lawyer :title="'Profil Pengacara'">
    <div class="d-flex justify-content-between bagian-atas">
        <div class="sapaan-foto d-flex flex-column">
            <h1 class="fs-3">Halo, {{ $user->nama_pengacara }}</h1>
            <img id="preview-foto" class="foto-profil-preview"
                src="{{ $user->foto_pengacara ? asset('storage/' . $user->foto_pengacara) : asset('assets/images/foto-profil-default.jpg') }}"
                alt="foto profil">
        </div>
        <div class="d-flex justify-content-center">
            <button type="button" class="button-edit"
                onclick="window.location.href='{{ route('lawyer.profile.edit') }}'">Ubah Profil</button>
        </div>
    </div>

    <div class="form-profil d-flex align-item-center">
        <div class="form-element nama">
            <label for="" class="form-label">Nama Lengkap</label>
            <input readonly type="text" class="form-control input-nama" value="{{ $user->nama_pengacara }}">
        </div>
        <div class="form-element nik">
            <label for="" class="form-label">NIK</label>
            <input readonly type="text" class="form-control input-nik" value="{{ $user->nik_pengacara }}">
        </div>
        <div class="form-element email">
            <label for="" class="form-label">Email</label>
            <input readonly type="email" class="form-control input-email" value="{{ $user->email }}">
        </div>
        <div class="form-element telepon">
            <label for="" class="form-label">Nomor Telepon</label>
            <input readonly type="text" class="form-control input-telepon" value="{{ $user->nomor_telepon }}">
        </div>
        <div class="form-element lokasi">
            <label for="" class="form-label">Lokasi Tempat Kerja</label>
            <input readonly type="text" class="form-control input-lokasi" value="{{ $user->lokasi }}">
        </div>
        <div class="form-element tarifJasa">
            <label for="" class="form-label">Tarif jasa</label>
            <input readonly type="text" class="form-control input-tarifJasa" value="{{ $user->tarif_jasa }}">
        </div>
        <div class="form-element spesialisasi">
            <label for="" class="form-label">Spesialisasi</label>
            <input readonly type="text" class="form-control input-spesialisasi" id="savedSpecialties"
                value="{{ $user->spesialisasi }}">
        </div>

        <div class="form-element pendidikan">
            <label for="" class="form-label">Informasi Pendidikan</label>
            <textarea readonly class="form-control input-pendidikan" rows="4">{{ $user->pendidikan }}</textarea>
        </div>
        <div class="form-element pengalaman">
            <label for="" class="form-label">Pengalaman Kerja</label>
            <textarea readonly class="form-control input-pendidikan" rows="8">{{ $user->pengalaman_bekerja }}</textarea>
        </div>
        <div class="form-element durasi_kerja">
            <label for="" class="form-label">Durasi Pengalaman Kerja</label>
            <input readonly type="text" class="form-control input-spesialisasi" id="savedSpecialties"
                oninput="tambahTahun(this)" value="{{ $user->durasi_pengalaman }}">
        </div>
        <div class="form-element gender">
            <label for="" class="form-label">Jenis Kelamin</label>
            <input readonly type="text" class="form-control input-text" value="{{ $user->jenis_kelamin }}">
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
            <label for="" class="form-label">Jenis Layanan</label>
            <input readonly type="text" class="form-control input-text" value="{{ implode(', ', $layanan) }}">
        </div>
        <div class="button-exit d-flex justify-content-center">
            <button onclick="window.location.href='{{ route('lawyer.profile.exit') }}'">Keluar Akun</button>
        </div>

    </div>
</x-layout_lawyer>
