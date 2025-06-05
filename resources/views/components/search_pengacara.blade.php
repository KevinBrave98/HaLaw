<div class="position-relative d-flex mx-4 my-3 flex-column justify-content-center align-items-center search-container">
    <div class="d-flex flex-row w-100 justify-content-center align-items-center position-relative">
        <input type="text" placeholder="Cari Pengacara" class="w-100 p-3 rounded border-0 input-pengacara">
        <div class="d-flex m-0 icon-container gap-2">
            <div class="rounded filter-search d-flex align-items-center justify-content-center" id="filter-icon">
                <img src="{{ asset('assets/images/filter-icon.png') }}" alt="filter" class="filter-icon">
            </div>
            <div class="rounded filter-search d-flex align-items-center justify-content-center" id="search-icon">
                <img src="{{ asset('assets/images/search-icon.png') }}" alt="search" class="search-icon">
                <p class="px-2 m-0">Cari</p>
            </div>
        </div>
    </div>
    <div class="hide more-filter position-absolute d-flex flex-column w-100 top-100 start-0 justify-content-evenly">
        <div class="d-flex flex-column justify-content-evenly p-4 filter-section">
            <h2 class="m-0 text-start">Jenis Kelamin</h1>
                <div class="d-flex flex-row mt-3 gap-5 mb-5">
                    <div class="d-flex align-items-center radio-container">
                        <input type="radio" name="jenis_kelamin" id="laki-laki" value="laki-laki">
                        <label class="search_label" for="laki-laki">Laki-Laki</label>
                    </div>
                    <div class="d-flex align-items-center radio-container">
                        <input type="radio" name="jenis_kelamin" id="perempuan" value="perempuan">
                        <label class="search_label" for="perempuan">Perempuan</label>
                    </div>
                </div>
                <hr>
        </div>

        <div class="d-flex flex-column justify-content-evenly p-4 filter-section">
            <h2 class="m-0 text-start">Spesialisasi</h1>
                <div
                    class="position-relative w-50 d-flex flex-row align-items-center mt-3 gap-5 mb-5 select-specialization">
                    <select>
                        <option value="0">Test 1</option>
                        <option value="1">Test 2</option>
                        <option value="2">Test 3</option>
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
                        <input type="checkbox" name="jenis_layanan" id="chat" value="chat">
                        <label class="search_label" for="chat">Chat</label>
                        <span></span>
                    </div>
                    <div class="d-flex align-items-center checkbox-container">
                        <input type="checkbox" name="jenis_layanan" id="voice_call" value="voice_call">
                        <label class="search_label" for="voice_call">Voice Call</label>
                        <span></span>
                    </div>
                    <div class="d-flex align-items-center checkbox-container">
                        <input type="checkbox" name="jenis_layanan" id="video_call" value="video_call">
                        <label class="search_label" for="video_call">Video Call</label>
                        <span></span>
                    </div>
                </div>
                <hr>
        </div>
        <div class="d-flex flex-column justify-content-evenly p-4 filter-section">
            <h2 class="m-0 text-start">Batas Harga (Rp)</h1>
                <div class="d-flex flex-column align-items-center mt-3 mb-5 price-container">
                    <div class="price-input d-flex justify-content-between align-items-center w-100">
                        <div class="price-field d-flex flex-column">
                            <p class="m-0 w-25">Min</p>
                            <input type="number" class="input-min" value="50000">
                        </div>
                        <div class="price-field d-flex flex-column">
                            <p class="m-0 w-25">Max</p>
                            <input type="number" class="input-max" value="200000">
                        </div>
                    </div>
                    <div class="d-flex w-100 align-items-center justify-content-center position-relative">
                        <div class="slider w-100 mt-4 d-flex">
                            <div class="progress"></div>
                        </div>
                        <div class="range-input">
                            <input type="range" class="range-min" min="0" max="10000" value="2500"
                                step="100">
                            <input type="range" class="range-max" min="0" max="10000" value="7500"
                                step="100">
                        </div>
                    </div>
                </div>
                <hr>
        </div>
    </div>
</div>
