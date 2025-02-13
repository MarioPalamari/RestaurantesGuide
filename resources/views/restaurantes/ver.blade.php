<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ $restaurante->nombre }}</title>
    <link rel="stylesheet" href="{{ asset('css/restaurante.css') }}">
</head>

<body>
    <div class="contenedor">
        <!-- Columna izquierda -->
        <div class="columna izquierda">
            <p>Ofrece una experiencia centrada en la cocina tradicional española. Con un ambiente familiar y cercano,
                se especializa en arroces y tapas, elaborados con ingredientes frescos que realzan los sabores locales.
                Su entorno relajado y acogedor lo convierte en una opción ideal para quienes desean disfrutar de una
                comida
                tranquila en un espacio que refleja la esencia de la tradición gastronómica regional. La calidad en el
                servicio
                y la calidez en la atención hacen de este lugar una elección destacada para cualquier ocasión.</p>

            <img src="{{ asset('img/' . $restaurante->img) }}" alt="Arroz y Cañas">
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
    {{-- <h1>{{ $restaurante->nombre }}</h1>
    <div>
        <div>
            <p>{{ $restaurante->descripcion }}</p>
            <img src="{{ asset('img/' . $restaurante->img) }}" alt="">
        </div>
        <div>
            info
        </div>
    </div> --}}
</body>

</html>
