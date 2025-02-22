<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>Saborea Madrid | Restaurantes</title>

    <!-- Estilos -->
    <link rel="stylesheet" href="{{ asset('css/restaurante.css') }}">
    <link rel="icon" href="{{ asset('/img/logo.png') }}" type="image/png">
</head>

<body>
    <header class="header">
        <!-- Navegación -->
        <nav class="nav">
            <div class="logo"><img src="{{ asset('img/logo.png') }}" alt="a"></div>
            <div class="nav-links">
                <p style="margin: 0; padding-right: 10px;">{{ session('nombre') }}</p>
                <a href="{{ route('logout') }}"><img src="{{ asset('img/logout.png') }}" alt="Logo"
                        class="d-inline-block align-top"></a>
            </div>
        </nav>

        <!-- Contenido del Header -->
        <div class="header-content">
            <h1>Bienvenido a Saborea Madrid</h1>
            <p>¿Qué me apetece hoy?</p>
        </div>
    </header>

    <div class="contenedor">
        <!-- Filtros -->
        <div class="filtros">
            <form id="formnewuser" method="post" onsubmit="event.preventDefault(); mostrarrestaurantes();">
                @csrf
                @method('post')
                <div class="filtro-item">
                    <label for="precio">Precio medio de la carta</label>
                    <input type="text" name="precio" id="precio" placeholder="Ej. 20-40">
                </div>
                <div class="filtro-item">
                    <label for="tipo_cocina">Tipo de cocina</label>
                    <input type="text" name="tipo_cocina" id="tipo_cocina" placeholder="Ej. Mexicana">
                </div>
                <div class="filtro-item">
                    <label for="valoracion">Valoración de los usuarios</label>
                    <input type="text" name="valoracion" id="valoracion" placeholder="Ej. 4-5">
                </div>
                <div class="filtro-submit">
                    <input type="submit" value="BUSCAR">
                </div>
                <div class="filtro-borrar">
                    <button onclick="borrarfiltros();">✖ Borrar filtros</button>
                    {{-- <a href="{{ route('restaurantes') }}">✖ Borrar filtros</a> --}}
                </div>
            </form>
        </div>

        <!-- Restaurantes -->
        <div>
            <div class="breadcamp">
                <ul class="breadcrumb">
                    <li></li>
                    <li>Restaurantes</li>
                </ul>
            </div>
            <div class="restaurantes" id="restaurantes"></div>
        </div>
    </div>

</body>

</html>
<script src="{{ asset('js/restaurantes.js') }}"></script>
