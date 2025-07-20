<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    @stack('css')
    @stack('js')
    <meta name="user-nik" content="{{ Auth::guard('lawyer')->user()->nik_pengacara }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/navbar_lawyer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/footer.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+KR:ital,wght@0,100..900;1,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body class="h-full">
    <div class="min-h-full">
    <x-navbar_lawyer :pengacara=$pengacara/>
        <main>
            {{ $slot }}
        </main>
    </div>
    <x-footer/>
</body>

</html>
