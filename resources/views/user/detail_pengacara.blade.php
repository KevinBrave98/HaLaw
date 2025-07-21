@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/detail_pengacara.css') }}">
@endpush
<x-layout_user :title="'Detail Pengacara'">
    <div class="d-flex bagian-atas d-flex-column justify-content-between align-items-start">
        <a class="button-back" href="{{ route('search.pengacara.view') }}">
            <img src="{{ asset('assets/images/icon-back.png') }}" alt="tombol kembali">
        </a>
        <div class="sapaan-foto d-flex flex-column">
            <h1 class="fs-3">Halo, {{ $pengacara->nama_pengacara }}</h1>
            <img id="preview-foto" class="foto-profil-preview"
                src="{{ $pengacara->foto_pengacara ? asset('storage/' . $pengacara->foto_pengacara) : asset('assets/images/foto-profil-default.jpg') }}"
                alt="foto profil">
        </div>
    </div>

    <div class="form-profil d-flex align-item-center">
        <div class="form-element nama">
            <label for="" class="form-label">Nama Lengkap</label>
            <input readonly type="text" class="form-control input-nama" value="{{ $pengacara->nama_pengacara }}">
        </div>
        <div class="form-element nik">
            <label for="" class="form-label">NIK</label>
            <input readonly type="text" class="form-control input-nik" value="{{ $pengacara->nik_pengacara }}">
        </div>
        <div class="form-element email">
            <label for="" class="form-label">Email</label>
            <input readonly type="email" class="form-control input-email" value="{{ $pengacara->email }}">
        </div>
        <div class="form-element telepon">
            <label for="" class="form-label">Nomor Telepon</label>
            <input readonly type="text" class="form-control input-telepon" value="{{ $pengacara->nomor_telepon }}">
        </div>
        <div class="form-element lokasi">
            <label for="" class="form-label">Lokasi Tempat Kerja</label>
            <input readonly type="text" class="form-control input-lokasi" value="{{ $pengacara->lokasi }}">
        </div>
        <div class="form-element spesialisasi">
            <label for="" class="form-label">Spesialisasi</label>
            <input readonly type="text" class="form-control input-spesialisasi" id="savedSpecialties"
                value="{{ $pengacara->spesialisasi }}">
        </div>

        <div class="form-element pendidikan">
            <label for="" class="form-label">Informasi Pendidikan</label>
            <textarea readonly class="form-control input-pendidikan" rows="4">{{ $pengacara->pendidikan }}</textarea>
        </div>
        <div class="form-element pengalaman">
            <label for="" class="form-label">Pengalaman Kerja</label>
            <textarea readonly class="form-control input-pendidikan" rows="8">{{ $pengacara->pengalaman_bekerja }}</textarea>
        </div>
        <div class="form-element durasi_kerja">
            <label for="" class="form-label">Durasi Pengalaman Kerja</label>
            <input readonly type="text" class="form-control input-spesialisasi" id="savedSpecialties"
                oninput="tambahTahun(this)" value="{{ $pengacara->durasi_pengalaman }}">
        </div>
        <div class="form-element gender">
            <label for="" class="form-label">Jenis Kelamin</label>
            <input readonly type="text" class="form-control input-text" value="{{ $pengacara->jenis_kelamin }}">
        </div>
        @php
            $layanan = [];
            if ($pengacara->chat) {
                $layanan[] = 'Pesan';
            }
            if ($pengacara->voice_chat) {
                $layanan[] = 'Panggilan Suara';
            }
            if ($pengacara->video_call) {
                $layanan[] = 'Panggilan Video';
            }
        @endphp

        <div class="form-element jenis_layanan mb-5">
            <label for="" class="form-label">Jenis Layanan</label>
            <input readonly type="text" class="form-control input-text" value="{{ implode(', ', $layanan) }}">
        </div>
        <div class="d-flex flex-column align-items-center">
            <h4>Tarif Jasa</h4>
            <h2>Rp{{ number_format($pengacara->tarif_jasa, 0, ',', '.') }}</h2>
        </div>
        <div class="button-exit d-flex justify-content-center" style="margin-top: 0px;">
            <button onclick="window.location.href='{{ route('pembayaran.pengacara', ['id' => $pengacara->nik_pengacara]) }}'">Konsultasi Sekarang</button>
        </div>
    </div>
</x-layout_user>
