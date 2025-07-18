<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('img/logo.svg') }}" type="image/svg+xml">
    <title>{{ $title ?? 'Osiqual' }}</title>
    @vite('resources/css/app.css')
</head>
<body class="text-default-900">

    {{ $slot }}

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script> lucide.createIcons(); </script>
    @stack('scripts')
</body>
</html>
