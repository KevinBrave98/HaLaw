<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets/images/logo_putih.png') }}" alt="Bootstrap" width="auto" height="77">
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="navbar-navbox me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('lawyer.dashboard') }}">Dasbor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Konsultasi</a>
                </li>
                <li class="nav-item penarikan-pendapatan">
                    <a class="nav-link " href="#">Penarikan Pendapatan</a>
                </li>
                <div class="profil-wrapper d-flex align-items-center">
                    <li class="nav-item m-0">
                        <a class="nav-link" href="{{ route('lawyer.profile.show') }}">Profil</a>
                    </li>
                    <div class="container-profil">
                        <a class="navbar-brand" href="#">
                             {{-- @if ($pengacara->foto_pengacara)
                                <img src="{{ asset('storage/'. $pengacara->foto_pengacara) }}" alt="foto_pengacara" class="rounded-circle" width="45" height="45">
                            @else --}}
                                <img src="{{ asset('assets/images/lawyer1.jpeg') }}" alt="foto_pengacara_default" class="rounded-circle" width="45" height="45">
                            {{-- @endif --}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
</nav>
