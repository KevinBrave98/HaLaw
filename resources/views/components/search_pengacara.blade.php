<div class="position-relative d-flex mx-4 my-3 flex-column justify-content-center align-items-center search-container">
    <form class="w-100" action="{{ route('dashboard.search.lawyer') }}" method="POST" id="search_pengacara">
        @csrf
        <div class="d-flex flex-row w-100 justify-content-center align-items-center position-relative">

            {{-- Menambahkan <label> yang tersembunyi untuk aksesibilitas --}}
            <label for="nama_pengacara" class="visually-hidden">Cari Pengacara</label>
            <input name="nama_pengacara" type="text" placeholder="Cari Pengacara"
                class="w-100 p-3 rounded border-0 input-pengacara" id="nama_pengacara">

            <div class="d-flex m-0 icon-container gap-2">
                {{-- Mengubah <div> yang bisa diklik menjadi <button> agar aksesibel oleh keyboard --}}
                <button type="button" class="rounded filter-search d-flex align-items-center justify-content-center"
                    id="filter-icon" aria-label="Buka Opsi Filter">
                    <img src="{{ asset('assets/images/filter-icon.png') }}" alt="" class="filter-icon"
                        aria-hidden="true">
                </button>
            </div>
        </div>

        <div class="hide more-filter position-absolute d-flex flex-column w-100 top-100 start-0 justify-content-evenly">

            {{-- Menggunakan <fieldset> untuk mengelompokkan input yang berhubungan --}}
            <fieldset class="d-flex flex-column justify-content-evenly p-4 filter-section">
                {{-- Menggunakan <legend> sebagai judul untuk fieldset, ini lebih semantik daripada <h2> --}}
                <legend class="m-0 h2 text-start">Jenis Kelamin</legend>
                <div class="radio-outer d-flex flex-row mt-3 gap-5 mb-5">
                    <div class="d-flex align-items-center radio-container">
                        <input type="radio" name="jenis_kelamin" id="laki-laki" value="Laki-laki">
                        <label class="search_label" for="laki-laki">Laki-Laki</label>
                    </div>
                    <div class="d-flex align-items-center radio-container">
                        <input type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan">
                        <label class="search_label" for="perempuan">Perempuan</label>
                    </div>
                </div>
                <hr>
            </fieldset>

            <fieldset class="d-flex flex-column justify-content-evenly p-4 filter-section">
                <legend class="m-0 h2 text-start">Spesialisasi</legend>
                <div
                    class="position-relative w-50 d-flex flex-row align-items-center mt-3 gap-5 mb-5 select-specialization">
                    {{-- Menambahkan <label> tersembunyi untuk dropdown --}}
                    <label for="spesialisasi" class="visually-hidden">Pilih Spesialisasi</label>
                    <select name="spesialisasi" id="spesialisasi">
                        <option value=""></option>
                        @foreach ($spesialisasi as $item)
                            <option value="{{ $item->nama_spesialisasi }}">{{ $item->nama_spesialisasi }}</option>
                        @endforeach
                        {{-- Opsi lainnya di sini --}}
                    </select>
                    {{-- Ikon hanya dekoratif, disembunyikan dari screen reader dengan alt="" dan aria-hidden="true" --}}
                    <img src="{{ asset('assets/images/icon-dropdown.png') }}" alt="" aria-hidden="true"
                        id="dropdown-icon" class="position-relative">
                </div>
                <hr>
            </fieldset>

            <fieldset class="d-flex flex-column justify-content-evenly p-4 filter-section">
                <legend class="m-0 h2 text-start">Jenis Layanan</legend>
                <div class="checkbox-outer d-flex flex-row mt-3 gap-5 mb-5">
                    <div class="d-flex align-items-center checkbox-container">
                        <input type="checkbox" name="jenis_layanan[]" id="chat" value="chat">
                        <label class="search_label" for="chat" aria-label="Pesan">Pesan</label>
                        <span></span>
                    </div>
                    <div class="d-flex align-items-center checkbox-container">
                        <input type="checkbox" name="jenis_layanan[]" id="voice_chat" value="voice_chat">
                        <label class="search_label" for="voice_chat" aria-label="Panggilan Suara">Panggilan
                            Suara</label>
                        <span></span>
                    </div>
                    <div class="d-flex align-items-center checkbox-container">
                        <input type="checkbox" name="jenis_layanan[]" id="video_call" value="video_call">
                        <label class="search_label" for="video_call" aria-label="Panggilan Video">Panggilan
                            Vidio</label>
                        <span></span>
                    </div>
                </div>
                <hr>
            </fieldset>

            <fieldset class="d-flex flex-column justify-content-evenly p-4 filter-section">
                <legend class="m-0 h2 text-start">Batas Harga (Rp)</legend>
                <div class="d-flex flex-column align-items-center mt-3 mb-5 price-container">
                    <div class="price-input d-flex justify-content-between align-items-center w-100 mb-4">
                        <div class="price-field d-flex flex-column">
                            <label for="input-min" class="m-0 w-25">Min</label>

                            {{-- PERBAIKAN: --}}
                            {{-- 1. Ubah type="number" menjadi type="text" agar dibaca sebagai angka utuh --}}
                            {{-- 2. Tambahkan inputmode="numeric" untuk menampilkan keyboard angka di mobile --}}
                            {{-- 3. Tambahkan aria-label yang deskriptif untuk screen reader --}}
                            <input type="text" inputmode="numeric" pattern="[0-9]*" id="input-min" class="input-min"
                                value="{{ $hargaMin }}" aria-label="Harga Minimum">
                        </div>

                        <div class="price-field d-flex flex-column">
                            <label for="input-max" class="m-0 w-25">Max</label>

                            {{-- Terapkan perbaikan yang sama untuk input maksimum --}}
                            <input type="text" inputmode="numeric" pattern="[0-9]*" id="input-max"
                                class="input-max" value="{{ $hargaMax }}" aria-label="Harga Maksimum">
                        </div>
                    </div>
                    <div class="d-flex flex-column w-100 align-items-center justify-content-center position-relative">
                        <div class="slider w-100 d-flex">
                            <div class="progress"></div>
                        </div>
                        <div class="range-input w-100">
                            {{-- Menambahkan label tersembunyi untuk range slider --}}
                            <label for="range-min" class="visually-hidden">Harga Minimum</label>
                            <input type="range" name="min_price" id="range-min" class="range-min"
                                min="{{ $hargaMin }}" max="{{ $hargaMax }}" value="{{ $hargaMin }}"
                                step="1000">
                            <label for="range-max" class="visually-hidden">Harga Maksimum</label>
                            <input type="range" name="max_price" id="range-max" class="range-max"
                                min="{{ $hargaMin }}" max="{{ $hargaMax }}" value="{{ $hargaMax }}"
                                step="1000">
                        </div>
                    </div>
                </div>
                <button type="submit" class="w-25 p-2 submit-filter">Cari</button>
            </fieldset>
        </div>
    </form>
</div>
