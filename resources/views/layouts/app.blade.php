<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'González & Salazar')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<header class="site-header">
    <div class="top-bar">
        <div class="social-links">
            <a href="mailto:contacto@gonzalezsalazar.cr" aria-label="Correo electrónico">✉</a>
            <a href="#" aria-label="Instagram">◎</a>
            <a href="#" aria-label="Facebook">f</a>
            <a href="#" aria-label="X">𝕏</a>
        </div>

        <div class="user-links">
            <span>Iniciar sesión</span>
            <span>Español</span>
            <span class="cart-icon">□</span>
        </div>
    </div>

    <div class="brand">
        <a href="{{ route('home') }}" class="brand-link">
            <img
                src="{{ asset('images/icono-gonzalez-salazar.png') }}"
                alt="Logo González & Salazar"
                class="brand-logo-image"
            >
            <span class="brand-name">González & Salazar</span>
            <span class="brand-subtitle">Catálogo de vinos y champanes</span>
        </a>
    </div>

    <nav class="main-nav">
        <a href="{{ route('categories.wine') }}">Vino</a>
        <a href="{{ route('categories.champagne') }}">Champán</a>
        <a href="{{ route('productos.index') }}">Catálogo</a>
    </nav>
</header>

<main>
    @if (session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
</main>

<footer class="site-footer">
    <div>
        <h3>González & Salazar</h3>
        <p>La mejor selección de vinos y champanes de Costa Rica.</p>
    </div>

    <div>
        <h4>Enlaces útiles</h4>
        <a href="{{ route('home') }}#ultimos">Últimos productos</a>
        <a href="{{ route('home') }}#blog">Blog</a>
        <a href="{{ route('home') }}#historia">Historia</a>
        <a href="{{ route('productos.index') }}">Administrar catálogo</a>
    </div>

    <div>
        <h4>Soporte</h4>
        <p>Contacto</p>
        <p>Preguntas frecuentes</p>
        <p>Políticas del sitio</p>
    </div>
</footer>
</body>
</html>