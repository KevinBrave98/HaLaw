<nav class="navbar navbar-dark navbar-expand-lg" id="main-navigation">
    <div class="container-fluid">
        {{-- Logo/Brand --}}
        <a class="navbar-brand" href="{{ route('dashboard.view') }}">
            <img src="{{ asset('assets/images/logo_putih.png') }}" alt="Logo HaLaw" width="auto" height="70">
        </a>

        {{-- Tombol untuk Tampilan Mobile (Toggler) --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Ganti Navigasi">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Konten Navbar yang Bisa Dicollape --}}
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            {{-- SEMUA item navigasi digabung dalam satu UL dengan ms-auto --}}
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('dashboard.user') ? 'active' : '' }}" href="{{ route('dashboard.view') }}">Dasbor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('konsultasi.berlangsung') ? 'active' : '' }}" href="{{ route('konsultasi.berlangsung') }}">Konsultasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('kamus') ? 'active' : '' }}" href="{{ route('kamus') }}">Kamus Hukum</a>
                </li>
                 <div class="profil-wrapper d-flex align-items-center">
                    <li class="nav-item m-0">
                        <a class="nav-link" href="{{ route('profile.show') }}">Profil</a>
                    </li>
                    <div class="container-profil">
                        <a class="navbar-brand" href="{{ route('profile.show') }}">
                            @if ($pengguna->foto_pengguna)
                                <img src="{{ asset('storage/'. $pengguna->foto_pengguna) }}" alt="foto_pengguna" class="rounded-circle" width="45" height="45">
                            @else
                                <img src="{{ asset('assets/images/foto-profil-default.jpg') }}" alt="foto_pengguna" class="rounded-circle" width="45" height="45">
                            @endif
                        </a>
                    </div>
                </div>
            </ul>

        </div>
    </div>
</nav>
