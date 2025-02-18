<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title id="restauranteNombre"></title>
    <link rel="stylesheet" href="{{ asset('css/verrestaurante.css') }}">
</head>

<body>

    <header class="header">
        <nav class="nav">
            <div class="logo"><img src="{{ asset('img/logo.png') }}" alt="a"></div>
            <div class="nav-links">
                <p>{{ session('nombre') }}</p>
                <a href="{{ route('logout') }}"><img src="{{ asset('img/logout.png') }}" alt="Logo"></a>
            </div>
        </nav>
        <div class="header-content">
            <h1 id="bienvenidaRestaurante"></h1>
            <p>Conoce más de nosotros</p>
        </div>
    </header>

    <div class="container">
        <div class="info">
            <div class="breadcamp">
                <ul class="breadcrumb">
                    <li></li>
                    <li><a href="{{ route('restaurantes.restaurantes') }}">Restaurantes</a></li>
                    <li id="nombreRestaurante">Italy</li>
                </ul>
            </div>
            <h1 id="nombreRestaurante"></h1>
            <p id="descripcionRestaurante"></p>
            <div class="imagenes">
                <img id="imgRestaurante" src="" alt="Foto del restaurante">
            </div>

            <div class="opiniones-section">
                <h2>Opiniones</h2>
                <div id="opiniones"></div>
            </div>
        </div>

        <div class="sidebar">
            <div class="rating-box">
                <div class="rating-value">
                    <span class="rating-number" id="mediaValoracion"></span>
                    <span class="rating-text">Sobre <br> 5</span>
                </div>
                <div class="opiniones-box">
                    <span class="opiniones-numero" id="totalValoraciones"></span><br>
                    <span class="opiniones-texto">Opiniones</span><br>
                    <span class="opinar" id="abrirModal">¿Quieres opinar?</span>
                </div>
            </div>

            <div class="contacto">
                <p id="direccionRestaurante">📍 Dirección</p>
                <p id="extraInfoRestaurante">➕ Información extra</p>
                <p id="telefonoRestaurante">📞 Teléfono</p>
                <p>🌐 <a id="webRestaurante" href="#">Sitio web</a></p>
            </div>

            <div class="contacto" id="mostrarredsocial">

            </div>
        </div>
    </div>

    <div id="modalValoracion" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Deja tu valoración</h2>
            <form id="frmopinar" onsubmit="event.preventDefault(); opinarform();">
                <input type="hidden" id="inputIdOpinar" name="id" value="">
                @csrf
                <p class="clasificacion">
                    <input id="estrella5" type="radio" name="estrellas" value="5"><label
                        for="estrella5">★</label>
                    <input id="estrella4" type="radio" name="estrellas" value="4"><label
                        for="estrella4">★</label>
                    <input id="estrella3" type="radio" name="estrellas" value="3"><label
                        for="estrella3">★</label>
                    <input id="estrella2" type="radio" name="estrellas" value="2"><label
                        for="estrella2">★</label>
                    <input id="estrella1" type="radio" name="estrellas" value="1"><label
                        for="estrella1">★</label>
                </p>
                <textarea id="inputComentario" name="comentario" placeholder="Escribe tu comentario..."></textarea>
                <button type="submit">Enviar Opinión</button>
            </form>
        </div>
    </div>
</body>

</html>
<script src="{{ asset('js/restaurante.js') }}"></script>
