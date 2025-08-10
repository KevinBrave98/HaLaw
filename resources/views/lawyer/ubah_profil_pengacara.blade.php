@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/ubah_profil_pengguna.css') }}">
@endpush

<x-layout_lawyer :title="'Ubah Profil'">
    {{-- 1. Menggunakan <header> untuk struktur yang lebih baik --}}
    <header class="d-flex justify-content-between bagian-atas">
        <a class="button-back" href="{{ route('lawyer.profile.show') }}" aria-label="Kembali ke halaman profil">
            <img src="{{ asset('assets/images/icon-back.png') }}" alt="Tombol kembali">
        </a>
        <div class="sapaan-foto d-flex flex-column">
            {{-- Menggunakan h2 karena h1 kemungkinan besar ada di layout utama --}}
            <h2 class="fs-3">Halo, {{ $user->nama_pengacara }}</h2>
            <img id="preview-foto" class="foto-profil-preview"
                src="{{ $user->foto_pengacara ? asset('storage/' . $user->foto_pengacara) : asset('assets/images/foto-profil-default.jpg') }}"
                {{-- 2. Alt text yang lebih deskriptif --}} alt="Foto profil {{ $user->nama_pengacara }}">
        </div>
        <div class="d-flex align-item-center justify-content-center">
            {{-- Tombol ini bisa dihilangkan jika tidak ada fungsionalitas khusus --}}
            <button type="button" class="button-edit">Ubah Profil</button>
        </div>
    </header>

    @if ($errors->any())
        {{-- 3. Menambahkan role="alert" untuk aksesibilitas --}}
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 4. Form utama dengan atribut yang benar --}}
    <form action="{{ route('lawyer.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Gunakan PUT/PATCH untuk update --}}

        <main class="form-profil d-flex align-item-center">
            <div class="form-element foto">
                <label for="foto_pengacara" class="form-label">Foto Profil</label>
                <input type="file" name="foto_pengacara" class="form-control" id="foto_pengacara">
            </div>

            <div class="form-element nama">
                <label for="nama_pengacara" class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_pengacara" id="nama_pengacara" class="form-control input-text"
                    value="{{ old('nama_pengacara', $user->nama_pengacara) }}">
            </div>

            <div class="form-element nik">
                <label for="nik_pengacara" class="form-label">NIK</label>
                <input type="text" id="nik_pengacara" class="form-control input-text"
                    value="{{ $user->nik_pengacara }}" readonly>
            </div>

            <div class="form-element email">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control input-text"
                    value="{{ old('email', $user->email) }}">
            </div>

            <div class="form-element telepon">
                <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                <input type="text" name="nomor_telepon" id="nomor_telepon" class="form-control input-text"
                    value="{{ old('nomor_telepon', $user->nomor_telepon) }}">
            </div>

            <div class="form-element alamat">
                <label for="lokasi" class="form-label">Lokasi Tempat Kerja</label>
                <input type="text" name="lokasi" id="lokasi" class="form-control input-text"
                    value="{{ old('lokasi', $user->lokasi) }}">
            </div>

            <div class="form-element tarifJasa">
                <label for="tarif_jasa" class="form-label">Tarif Jasa</label>
                <input type="text" name="tarif_jasa" id="tarif_jasa" class="form-control input-text"
                    value="{{ old('tarif_jasa', $user->tarif_jasa) }}">
            </div>

            @php
                // Ambil spesialisasi yang sudah dimiliki user ke dalam array untuk pengecekan.
                // 'spesialisasi' dari old() adalah array dari form, 'spesialisasis' adalah nama relasi.
                $userSpesialisasi = old('spesialisasi', $user->spesialisasis->pluck('nama_spesialisasi')->toArray());
            @endphp

            <fieldset class="form-element spesialisasi">
                <legend class="form-label">Spesialisasi Hukum</legend>

                <div class="custom-checkbox">
                    <input class="form-check-input" type="checkbox" name="spesialisasi[]" value="Hukum Perdata"
                        id="perdata" {{ in_array('Hukum Perdata', $userSpesialisasi) ? 'checked' : '' }}>
                    <label class="form-check-label" for="perdata">Hukum Perdata</label>
                </div>
                <div class="custom-checkbox">
                    <input class="form-check-input" type="checkbox" name="spesialisasi[]" value="Hukum Pidana"
                        id="pidana" {{ in_array('Hukum Pidana', $userSpesialisasi) ? 'checked' : '' }}>
                    <label class="form-check-label" for="pidana">Hukum Pidana</label>
                </div>
                <div class="custom-checkbox">
                    <input class="form-check-input" type="checkbox" name="spesialisasi[]" value="Hukum Keluarga"
                        id="keluarga" {{ in_array('Hukum Keluarga', $userSpesialisasi) ? 'checked' : '' }}>
                    <label class="form-check-label" for="keluarga">Hukum Keluarga</label>
                </div>
                <div class="custom-checkbox">
                    <input class="form-check-input" type="checkbox" name="spesialisasi[]" value="Hukum Perusahaan"
                        id="perusahaan" {{ in_array('Hukum Perusahaan', $userSpesialisasi) ? 'checked' : '' }}>
                    <label class="form-check-label" for="perusahaan">Hukum Perusahaan</label>
                </div>
                <div class="custom-checkbox">
                    <input class="form-check-input" type="checkbox" name="spesialisasi[]"
                        value="Hukum Hak Kekayaan Intelektual" id="haki"
                        {{ in_array('Hukum Hak Kekayaan Intelektual', $userSpesialisasi) ? 'checked' : '' }}>
                    <label class="form-check-label" for="haki">Hukum Hak Kekayaan Intelektual</label>
                </div>
                <div class="custom-checkbox">
                    <input class="form-check-input" type="checkbox" name="spesialisasi[]" value="Hukum Pajak"
                        id="pajak" {{ in_array('Hukum Pajak', $userSpesialisasi) ? 'checked' : '' }}>
                    <label class="form-check-label" for="pajak">Hukum Pajak</label>
                </div>
                <div class="custom-checkbox">
                    <input class="form-check-input" type="checkbox" name="spesialisasi[]" value="Hukum Kepailitan"
                        id="kepailitan" {{ in_array('Hukum Kepailitan', $userSpesialisasi) ? 'checked' : '' }}>
                    <label class="form-check-label" for="kepailitan">Hukum Kepailitan</label>
                </div>
                <div class="custom-checkbox">
                    <input class="form-check-input" type="checkbox" name="spesialisasi[]"
                        value="Hukum Lingkungan Hidup" id="lingkungan"
                        {{ in_array('Hukum Lingkungan Hidup', $userSpesialisasi) ? 'checked' : '' }}>
                    <label class="form-check-label" for="lingkungan">Hukum Lingkungan Hidup</label>
                </div>
                <div class="custom-checkbox">
                    <input class="form-check-input" type="checkbox" name="spesialisasi[]"
                        value="Hukum Kepentingan Publik" id="publik"
                        {{ in_array('Hukum Kepentingan Publik', $userSpesialisasi) ? 'checked' : '' }}>
                    <label class="form-check-label" for="publik">Hukum Kepentingan Publik</label>
                </div>
                <div class="custom-checkbox">
                    <input class="form-check-input" type="checkbox" name="spesialisasi[]"
                        value="Hukum Ketenagakerjaan" id="ketenagakerjaan"
                        {{ in_array('Hukum Ketenagakerjaan', $userSpesialisasi) ? 'checked' : '' }}>
                    <label class="form-check-label" for="ketenagakerjaan">Hukum Ketenagakerjaan</label>
                </div>
                <div class="custom-checkbox">
                    <input class="form-check-input" type="checkbox" name="spesialisasi[]"
                        value="Hukum Tata Usaha Negara" id="tun"
                        {{ in_array('Hukum Tata Usaha Negara', $userSpesialisasi) ? 'checked' : '' }}>
                    <label class="form-check-label" for="tun">Hukum Tata Usaha Negara</label>
                </div>
                <div class="custom-checkbox">
                    <input class="form-check-input" type="checkbox" name="spesialisasi[]" value="Hukum Imigrasi"
                        id="imigrasi" {{ in_array('Hukum Imigrasi', $userSpesialisasi) ? 'checked' : '' }}>
                    <label class="form-check-label" for="imigrasi">Hukum Imigrasi</label>
                </div>

                {{-- Opsi untuk spesialisasi lainnya --}}
                <div class="custom-checkbox">
                    <input class="form-check-input" type="checkbox" value="Lainnya" id="others">
                    <label class="form-check-label" for="others">Lainnya</label>
                </div>
                <input type="text" class="form-control input-text spesialisasi-lainnya mt-2"
                    id="spesialisasiLainnya" name="spesialisasi_lainnya"
                    placeholder="Tulis spesialisasi lainnya di sini">

            </fieldset>

            <div class="form-element pendidikan">
                <label for="pendidikan" class="form-label">Informasi Pendidikan</label>
                <textarea name="pendidikan" id="pendidikan" class="form-control input-pendidikan" rows="4">{{ old('pendidikan', $user->pendidikan) }}</textarea>
            </div>

            <div class="form-element pengalaman">
                <label for="pengalaman_bekerja" class="form-label">Pengalaman Kerja</label>
                <textarea name="pengalaman_bekerja" id="pengalaman_bekerja" class="form-control input-pendidikan" rows="8">{{ old('pengalaman_bekerja', $user->pengalaman_bekerja) }}</textarea>
            </div>

            <div class="form-element durasi_kerja">
                <label for="durasi_pengalaman" class="form-label">Durasi Pengalaman Kerja</label>
                <input type="text" name="durasi_pengalaman" id="durasi_pengalaman"
                    class="form-control input-text" value="{{ old('durasi_pengalaman', $user->durasi_pengalaman) }}">
            </div>

            <fieldset class="form-element gender">
                <legend class="form-label">Jenis Kelamin</legend>
                <div class="d-flex justify-content-between">
                    <div class="form-radio">
                        <input class="form-check-input square-radio" type="radio" name="jenis_kelamin"
                            id="laki" value="Laki-Laki"
                            {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-Laki' ? 'checked' : '' }}>
                        <label class="form-check-label" for="laki">Laki-Laki</label>
                    </div>
                    <div class="form-radio">
                        <input class="form-check-input square-radio" type="radio" name="jenis_kelamin"
                            id="perempuan" value="Perempuan"
                            {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }}>
                        <label class="form-check-label" for="perempuan">Perempuan</label>
                    </div>
                    <div class="form-radio">
                        <input class="form-check-input square-radio" type="radio" name="jenis_kelamin"
                            id="Memilih Tidak Menjawab" value="Memilih Tidak Menjawab"
                            {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Memilih Tidak Menjawab' ? 'checked' : '' }}>
                        <label class="form-check-label" for="Memilih Tidak Menjawab">Memilih Tidak Menjawab</label>
                    </div>
                </div>
            </fieldset>

            <fieldset class="form-element layanan">
                <legend class="form-label">Jenis Layanan</legend>
                <div class="d-flex justify-content-between">
                    <div class="custom-checkbox">
                        <input type="checkbox" name="chat" id="pesan" value="1"
                            {{ old('chat', $user->chat) ? 'checked' : '' }}>
                        <label class="form-check-label" for="pesan">Pesan</label>
                    </div>
                    <div class="custom-checkbox">
                        <input type="checkbox" name="voice_chat" id="panggilan_suara" value="1"
                            {{ old('voice_chat', $user->voice_chat) ? 'checked' : '' }}>
                        <label class="form-check-label" for="panggilan_suara">Panggilan Suara</label>
                    </div>
                    <div class="custom-checkbox">
                        <input type="checkbox" name="video_call" id="panggilan_video" value="1"
                            {{ old('video_call', $user->video_call) ? 'checked' : '' }}>
                        <label class="form-check-label" for="panggilan_video">Panggilan Video</label>
                    </div>
                </div>
            </fieldset>

            <div class="button-save d-flex justify-content-center">
                <button type="submit">Simpan Perubahan</button>
            </div>
        </main>
    </form>
</x-layout_lawyer>
