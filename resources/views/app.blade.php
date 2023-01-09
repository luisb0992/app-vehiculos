<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    {{--  <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">  --}}
    {{--  <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Shadows+Into+Light&display=swap" rel="stylesheet">  --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead

    {{--  fav icon  --}}
    <link rel="shortcut icon" href="{{ Vite::asset('resources/img/favicon/favicon-16x16.png') }}" type="image/x-icon">

    {{--  banner e iconos  --}}
    <meta name="banner-app" content="{{ Vite::asset('resources/img/app/banner.webp') }}">
    <meta name="icon-app" content="{{ Vite::asset('resources/img/favicon/favicon-32x32.png') }}">
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>
