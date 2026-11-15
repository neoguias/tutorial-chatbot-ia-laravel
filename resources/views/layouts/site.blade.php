<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | Radios</title>
    <meta name="description" content="@yield('description')">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>
<body>
    <header class="site-header">
        <a href="{{ route('home') }}" class="brand">Radios</a>
        <nav>
            <a href="{{ route('services') }}">Servicios</a>
            <a href="{{ route('prices') }}">Precios</a>
            <a href="{{ route('contact') }}">Contacto</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="site-footer">
        <p>Radios · {{ config('shop.address') }} · {{ config('shop.phone') }}</p>
    </footer>

    @include('larachat::widget')
</body>
</html>
