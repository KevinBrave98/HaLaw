<div class="position-relative d-flex mx-4 my-3 flex-column justify-content-center align-items-center search-container">
    <form class="w-100" action="{{ route('dashboard.search.lawyer') }}" method="POST" id="search_pengacara">
        @csrf
        <div class="d-flex flex-row w-100 justify-content-center align-items-center position-relative">
            <input name ="nama_pengacara" type="text" placeholder="Cari Pengacara"
                class="w-100 p-3 rounded border-0 input-pengacara">
            <div class="d-flex m-0 icon-container gap-2">
                <div class="rounded filter-search d-flex align-items-center justify-content-center" id="filter-icon">
                    <img src="{{ asset('assets/images/filter-icon.png') }}" alt="filter" class="filter-icon">
                </div>
            </div>
        </div>
        <div class="hide more-filter position-absolute d-flex flex-column w-100 top-100 start-0 justify-content-evenly">
            <div class="d-flex flex-column justify-content-evenly p-4 filter-section">
                <h2 class="m-0 text-start">Jenis Kelamin</h1>
                    <div class="d-flex flex-row mt-3 gap-5 mb-5">
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
            </div>

            <div class="d-flex flex-column justify-content-evenly p-4 filter-section">
                <h2 class="m-0 text-start">Spesialisasi</h1>
                    <div
                        class="position-relative w-50 d-flex flex-row align-items-center mt-3 gap-5 mb-5 select-specialization">
                        <select name="spesialisasi">
                            <option value=""></option>
                            <option value="Hukum Perdata">Hukum Perdata</option>
                            <option value="Hukum Pidana">Hukum Pidana</option>
                            <option value="Hukum Keluarga">Hukum Keluarga</option>
                            <option value="Hukum Perusahaan">Hukum Perusahaan</option>
                            <option value="Hukum Hak Kekayaan Intelektual">Hukum Hak Kekayaan Intelektual</option>
                            <option value="Hukum Pajak">Hukum Oajak</option>
                            <option value="Hukum Kepailitan">Hukum Kepailitan</option>
                            <option value="Hukum Lingkungan Hidup">Hukum Lingkungan Hidup</option>
                            <option value="Hukum Kepentingan Publik">Hukum Kepentingan Publik</option>
                            <option value="Hukum Ketenagakerjaan">Hukum Ketenagakerjaan</option>
                            <option value="Hukum Tata Usaha Negara">Hukum Tata Usaha Negara</option>
                            <option value="Hukum Imigrasi">Hukum Imigrasi</option>
                        </select>
                        <img src="{{ asset('assets/images/icon-dropdown.png') }}" alt="dropdown" srcset=""
                            id="dropdown-icon" class="position-relative">
                    </div>
                    <hr>
            </div>

            <div class="d-flex flex-column justify-content-evenly p-4 filter-section">
                <h2 class="m-0 text-start">Jenis Layanan</h1>
                    <div class="d-flex flex-row mt-3 gap-5 mb-5">
                        <div class="d-flex align-items-center checkbox-container">
                            <input type="checkbox" name="jenis_layanan[]" id="chat" value="chat">
                            <label class="search_label" for="chat">Chat</label>
                            <span></span>
                        </div>
                        <div class="d-flex align-items-center checkbox-container">
                            <input type="checkbox" name="jenis_layanan[]" id="voice_call" value="voice_call">
                            <label class="search_label" for="voice_chat">Voice Chat</label>
                            <span></span>
                        </div>
                        <div class="d-flex align-items-center checkbox-container">
                            <input type="checkbox" name="jenis_layanan[]" id="video_call" value="video_call">
                            <label class="search_label" for="video_call">Video Call</label>
                            <span></span>
                        </div>
                    </div>
                    <hr>
            </div>
            <div class="d-flex flex-column justify-content-evenly p-4 filter-section">
                <h2 class="m-0 text-start">Batas Harga (Rp)</h1>
                    <div class="d-flex flex-column align-items-center mt-3 mb-5 price-container">
                        <div class="price-input d-flex justify-content-between align-items-center w-100 mb-4">
                            <div class="price-field d-flex flex-column">
                                <p class="m-0 w-25">Min</p>
                                <input type="number" class="input-min" value="{{ $hargaMin }}">
                            </div>
                            <div class="price-field d-flex flex-column">
                                <p class="m-0 w-25">Max</p>
                                <input type="number" class="input-max" value="{{ $hargaMax }}">
                            </div>
                        </div>
                        <div
                            class="d-flex flex-column w-100 align-items-center justify-content-center position-relative">
                            <div class="slider w-100 d-flex">
                                <div class="progress"></div>
                            </div>
                            <div class="range-input w-100">
                                <input type="range" name="min_price" class="range-min" min="{{ $hargaMin }}" max="{{ $hargaMax }}" value="{{ $hargaMin }}"
                                    step="1000">
                                <input type="range" name="max_price" class="range-max" min="{{ $hargaMin }}" max="{{ $hargaMax }}"
                                    value="{{ $hargaMax }}" step="1000">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-25 p-2 submit-filter">Tampilkan</button>
            </div>
        </div>
    </form>
</div>
