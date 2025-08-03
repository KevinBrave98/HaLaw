<nav class="navbar navbar-dark navbar-expand-lg">
    <div class="container-fluid">
        {{-- Logo/Brand --}}
        <a class="navbar-brand" href="{{ route('lawyer.dashboard') }}">
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
                    <a class="nav-link {{ Route::is('lawyer.dashboard') ? 'active' : '' }}" href="{{ route('lawyer.dashboard') }}">Dasbor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('lawyer.konsultasi.berlangsung') ? 'active' : '' }}" href="{{ route('lawyer.konsultasi.berlangsung') }}">Konsultasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('lawyer.penarikan.pendapatan') ? 'active' : '' }}" href="{{ route('lawyer.penarikan.pendapatan') }}">Penarikan Pendapatan</a>
                </li>
                 <div class="profil-wrapper d-flex align-items-center">
                    <li class="nav-item m-0">
                        <a class="nav-link" {{ Route::is('lawyer.profile.show') ? 'active' : '' }}" href="{{ route('lawyer.profile.show')}}">Profil</a>
                    </li>
                    <div class="container-profil">
                        <a class="navbar-brand" href="{{ route('lawyer.profile.show') }}">
                            @if ($pengacara->foto_pengacara)
                                <img src="{{ asset('storage/'. $pengacara->foto_pengacara) }}" alt="foto_pengacara" class="rounded-circle" width="45" height="45">
                            @else
                                <img src="{{ asset('assets/images/foto-profil-default.jpg') }}" alt="foto_pengacara" class="rounded-circle" width="45" height="45">
                            @endif
                        </a>
                    </div>
                </div>
            </ul>

        </div>
    </div>
</nav>
