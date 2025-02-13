<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saborea Madrid - Destacados</title>
    <link rel="stylesheet" href="{{asset('css/index-style.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- Enlace que envuelve todo el contenido, sin estilos de enlace visibles -->
    <a href="#" class="text-decoration-none d-block text-dark" id="loginLink">
        <!-- Sección de Hero -->
        <div class="hero-section text-center text-white py-5">
            <p class="head text-uppercase">Bienvenido a Saborea Madrid</p>
            <h1 class="display-4 fw-bold text-uppercase">¿Qué quieres saborear hoy?</h1>
            <div class="separador"></div>
            <p class="lead">Los mejores planes y ofertas para disfrutar Madrid</p>
        </div>

        <!-- Sección de Destacados -->
        <div class="container mt-5">
            <h2 class="text-center fw-bold mb-4 text-uppercase">¿Qué hay de nuevo en Saborea Madrid?</h2>
            <div class="separador"></div>
            <h2 class="text-center fw-bold mb-4 text-uppercase">Destacados</h2>
            <div class="separador"></div>
            <div class="row">
                @foreach ($restaurantesMejorValorados as $restaurante)
                    <div class="col-md-4">
                        <div class="card bg-dark text-white border-0 shadow-lg">
                            <img class="card-img" src="{{ asset('img/' . ($restaurante->img ?? 'ruta_por_defecto.jpg')) }}" alt="Imagen de {{ $restaurante->nombre }}">
                            <div class="card-img-overlay d-flex align-items-center justify-content-center">
                                <h5 class="card-title text-center p-2">{{ $restaurante->nombre }}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Botón para ver más -->
            <div class="text-center mt-4 mb-3">
                <a href="#" class="btn btn-warning fw-bold px-4 py-2 rounded-0 text-uppercase">¿Quieres ver más?</a>
            </div>
        </div>
        </a>
    <script src="{{asset('js/script-register.js')}}"></script>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
