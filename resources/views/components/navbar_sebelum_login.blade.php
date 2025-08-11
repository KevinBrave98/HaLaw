<nav class="navbar navbar-dark navbar-expand-lg">
    <div class="container-fluid">
        {{-- Logo/Brand --}}
        <a class="navbar-brand" href="{{ route('dashboard.view') }}">
            <img src="{{ asset('assets/images/logo_putih.png') }}" alt="Logo HaLaw" width="auto" height="70">
        </a>

        {{-- Tombol untuk Tampilan Mobile (Toggler) --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Konten Navbar yang Bisa Dicollape --}}
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            {{-- SEMUA item navigasi digabung dalam satu UL dengan ms-auto --}}
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('dashboard.view') ? 'active' : '' }}" href="{{ route('dashboard.view') }}">Dasbor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login.show') }}">Konsultasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('kamus') ? 'active' : '' }}" href="{{ route('kamus') }}">Kamus Hukum</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link daftar" href="{{ route('register.show') }}">Daftar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link masuk" href="{{ route('login.show') }}">Masuk</a>
                </li>
            </ul>

        </div>
    </div>
</nav>