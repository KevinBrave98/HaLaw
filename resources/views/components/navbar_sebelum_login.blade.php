<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard.view') }}">
                <img src="{{ asset('assets/images/logo_putih.png') }}" alt="Bootstrap" width="auto" height="77">
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="navbar-navbox me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard.sebelum_login') }}">Dasbor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login.show') }}">Konsultasi</a>
                </li>
                <li class="nav-item kamus">
                    <a class="nav-link " href="{{ route('kamus') }}">Kamus Hukum</a>
                </li>
                <div class="profil-wrapper d-flex align-items-center">
                    <li class="nav-item m-0">
                        <a class="nav-link daftar" href="{{ route('register.show') }}">Daftar</a>
                    </li>
                    <li class="nav-item m-0">
                        <a class="nav-link masuk" href="{{ route('login.show') }}">Masuk</a>
                    </li>
                </div>
            </div>
        </div>
</nav>



