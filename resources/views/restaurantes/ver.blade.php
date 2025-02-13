<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title> {{ $restaurante->nombre }}</title> --}}
    <link rel="stylesheet" href="{{ asset('css/restaurante.css') }}">
</head>

<body>
    <div class="contenedor">
        <!-- Columna izquierda -->
        <div class="columna izquierda">
            <h1>{{ $restaurante->nombre }}</h1>
            <p>{{ $restaurante->descripcion }}</p>
            <img src="{{ asset('img/' . $restaurante->img) }}" alt="{{ 'Foto de ' . $restaurante->nombre }}">
        </div>

        <!-- Columna derecha -->
        <div class="columna derecha">
            <div class="rating">
                <div class="rating-box">
                    <span class="rating-number">9,8</span>
                    <span class="rating-text">Sobre <br> 10</span>
                </div>
                <div class="opiniones">
                    <span class="opiniones-numero">245</span>
                    <span class="opiniones-texto">Opiniones</span>
                    <a href="#" class="opinar">¿Quieres opinar?</a>
                </div>
            </div>

            <p>📍 Calle de Francia, 6, Pozuelo de Alarcón</p>
            <p>➕ --</p>
            <p>📞 913 52 99 94</p>
            <p>🌐 <a href="#">latxitxarreria.com</a></p>
        </div>
    </div>
    {{ $valoreaciones }}
    @foreach ($valoreaciones as $valoreacion)
        <div style="background-color:grey">
            {{-- <p>{{ $valoreacion->nombre }}</p> --}}
            <p> {{ $valoreacion->comentario }}</p>
            <p>{{ $valoreacion->valoracion }}</p>
        </div>
    @endforeach
</body>

</html>
