<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">

    @if ($attributes->has('title'))
        <title>{{ $attributes->get('title') . ' - ' . config('app.name', 'Laravel') }}</title>
    @else
        <title>{{ config('app.name', 'Laravel') }}</title>
    @endif

    <!-- Fonts -->
    @env(['production'])
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        {{-- <link href="https://fonts.googleapis.com/css2?family=Libre+Caslon+Text:wght@400;700&display=swap" rel="stylesheet"> --}}
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    @endenv

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    @env(['production'])
        <!-- Alpine Plugins -->
        <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
        <script defer src="https://unpkg.com/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
        <!-- Alpine Core -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @endenv
    @env(['local'])
        <!-- Alpine Plugins -->
        <script defer src="{{ asset('js/alpine-collapse.min.js') }}"></script>
        <script defer src="{{ asset('js/alpine-persist.min.js') }}"></script>
        <!-- Alpine Core -->
        <script defer src="{{ asset('js/alpine-core.min.js') }}"></script>
    @endenv

    @bukStyles

    @stack('head')

</head>

<body class="relative font-sans antialiased text-gray-default bg-primary-100">

{{ $slot }}

@bukScripts

@stack('footer')
</body>

</html>
