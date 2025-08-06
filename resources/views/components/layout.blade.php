<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <x-slot:title>HaLaw</x-slot:title>
    @vite(['resources/sass/app.scss'])
    @stack('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/navbar_sebelum_login.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/footer.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Serif+KR:ital,wght@0,100..900;1,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body class="h-full">
    <div class="min-h-full">
        <a href="#main-content" class="skip-to-content">Lewati ke Konten Utama</a>
        <x-navbar_sebelum_login />
        {{-- <main> --}}
            {{ $slot }}
        {{-- </main> --}}
    </div>
    <x-footer />
    @vite(['resources/js/app.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbarToggler = document.querySelector('.navbar-toggler');
            const navbarMenu = document.querySelector('.navbar-collapse');

            if (navbarToggler && navbarMenu) {
                navbarToggler.addEventListener('click', function() {
                    navbarMenu.classList.toggle('show');
                });
            }
        });
    </script>
</body>

</html>
