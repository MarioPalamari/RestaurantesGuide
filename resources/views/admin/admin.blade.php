<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="{{ asset('css/crud-style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" href="{{ asset('/img/logo.png') }}" type="image/png">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-black justify-content-between">
        <a style="padding-left: 1%;">
            <img src="{{ asset('img/logo2.png') }}" alt="Logo"  class="d-inline-block align-top">
        </a>
        <h3 class="text-white">Bienvenido, Administrador</h3>
        <a style="padding-right: 1%;"href="{{ route('logout') }}">
            <img src="{{ asset('img/logout.png') }}" alt="Logo"  class="d-inline-block align-top pr-5">
        </a>
    </nav>
    <div class="container-menu mt-5">
        <section>
            <a class="image-container" href="{{ route('admin.users.index') }}">
                <img src="{{ asset('img/usuario-fondo.png') }}" alt="usuario" id="usuario">
                <div class="text-overlay">Ir a Usuarios</div>
            </a>
            <a class="image-container" href="{{ route('admin-restaurante') }}">
                <img src="{{ asset('img/restaurante-fondo.png') }}" alt="restaurante" id="restaurante">
                <div class="text-overlay">Ir a restaurante</div>
            </a>
        </section>
    </div>
</body>
</html>