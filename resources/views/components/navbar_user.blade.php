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
                    <a class="nav-link" href="#">Dasbor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Konsultasi</a>
                </li>
                <li class="nav-item kamus">
                    <a class="nav-link " href="#">Kamus Hukum</a>
                </li>
                <div class="profil-wrapper d-flex align-items-center">
                    <li class="nav-item m-0">
                        <a class="nav-link" href="#">Profil</a>
                    </li>
                    <div class="container-profil">
                        <a class="navbar-brand" href="#">
                            @if ($pengguna->foto_pengguna)
                                <img src="{{ asset('storage/'. $pengguna->foto_pengguna) }}" alt="foto_pengguna" class="rounded-circle" width="45" height="45">
                            @else
                                <img src="{{ asset('assets/images/lawyer1.jpeg') }}" alt="foto_pengguna_default" class="rounded-circle" width="45" height="45">
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
</nav>
