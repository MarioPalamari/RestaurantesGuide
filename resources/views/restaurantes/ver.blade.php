<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title id="restauranteNombre"></title>
    <link rel="stylesheet" href="{{ asset('css/verrestaurante.css') }}">
</head>

<body>

    <header class="header">
        <nav class="nav">
            <div class="logo"><img src="{{ asset('img/logo.png') }}" alt="Logo"></div>
            <div class="nav-links">
                <p id="usuarioNombre">{{ session('nombre') }}</p>
                <a href="{{ route('logout') }}">Salir</a>
            </div>
        </nav>
        <div class="header-content">
            <h1 id="bienvenidaRestaurante"></h1>
            <p>Conoce más de nosotros</p>
        </div>
    </header>

    <div class="container">
        <div class="info">
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
        </div>
    </div>

    <div id="modalValoracion" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Deja tu valoración</h2>
            <form id="frmopinar" onsubmit="event.preventDefault(); opinarform();">
                @csrf
                <p class="clasificacion">
                    <input id="radio1" type="radio" name="estrellas" value="5"><!--
                    --><label for="radio1">★</label><!--
                    --><input id="radio2" type="radio" name="estrellas" value="4"><!--
                    --><label for="radio2">★</label><!--
                    --><input id="radio3" type="radio" name="estrellas" value="3"><!--
                    --><label for="radio3">★</label><!--
                    --><input id="radio4" type="radio" name="estrellas" value="2"><!--
                    --><label for="radio4">★</label><!--
                    --><input id="radio5" type="radio" name="estrellas" value="1"><!--
                    --><label for="radio5">★</label>
                </p>
                <textarea name="comentario" placeholder="Escribe tu comentario..."></textarea>
                <button type="submit">Enviar Opinión</button>
            </form>
        </div>
    </div>
</body>

</html>
<script src="{{ asset('js/restaurante.js') }}"></script>
