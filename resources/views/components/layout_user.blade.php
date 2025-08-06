<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>{{ $title }}</title>
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    @stack('css')
    @stack('js')
    <meta name="user-nik" content="{{ Auth::guard('web')->user()->nik_pengguna }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/navbar_user.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/footer.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Serif+KR:ital,wght@0,100..900;1,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="h-full">
    <a href="#main-content" class="skip-to-content">Lewati ke Konten Utama</a>
    <x-navbar_user :pengguna=$pengguna />
    <div style="min-height: 80vh">
        {{-- <a href="#main-navigation" class="skip-to-content">Lompat ke Navigasi</a> --}}
        @foreach (auth()->user()->unreadNotifications as $notif)
            <div class="alert alert-info mb-2 notification-item" data-id="{{ $notif->id }}">
                {{ $notif->data['message'] }}
                {{ $notif->data['pesan'] }}
            </div>
        @endforeach
        {{ $slot }}
        <a href="#main-navigation" class="skip-to-content">Lompat Kembali ke Navigasi</a>
    </div>
    <x-footer />
    <script>
        setTimeout(() => {
            document.querySelectorAll('.notification-item').forEach(el => {
                const id = el.dataset.id;

                // Hapus dari UI
                el.remove();

                // Kirim request hapus ke controller
                fetch('/delete-notification/' + id, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });
            });
        }, 3000);
    </script>
    @stack('scripts')
</body>

</html>
