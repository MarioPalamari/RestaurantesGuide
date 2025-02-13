<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <link rel="stylesheet" href="{{asset('css/styles-form.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container d-flex flex-row w-100 justify-content-center align-items-center form-container">
    <div class="container-todo  d-flex flex-row w-100">
        <div class="col-6 d-flex justify-content-center align-items-center" style="gap:30px;">
            <img src="{{asset('img/logo.png')}}" alt="" style="width: 200px;">
        </div>
        <div class="col-6 d-flex">
            <form method="POST" action="{{ route('register') }}" style="width: 80%;">
                @csrf
                @method('POST')
                <div class="mb-3">
                    <h2>REGISTRATE</h2>
                    <label for="nombre" class="form-label">Nombre: </label>
                    <br>
                    <input type="text" name="nombre"  class="form-control" placeholder="Introduzca aqui el nombre">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email: </label>
                    <br>
                    <input type="email" name="email"  class="form-control"  placeholder="Introduzca aquí el email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña: </label>
                    <br>
                    <input type="password" name="password"  class="form-control" placeholder="Introduzca aquí la contraseña">
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar contraseña: </label>
                    <br>
                    <input type="password" name="password_confirmation"  class="form-control"  placeholder="Repita aquí la contraseña">
                </div>
                <div class="mb-3 d-flex flex-column justify-content-between text-center">
                    <button type="submit" class="btn-form text-uppercase mb-2">Registrarse</button>
                    <span class="fw-bold">¿YA TIENES CUENTA? <a href="{{route('login') }}" class="text-decoration-none">INICIA SESIÓN</a></span>
                </div>
                <br>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>{{ $errors->first() }}</strong>
                    </div>
                @endif
            </form>
        </div>            
    </div>

       
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="{{asset('js/script-register.js')}}"></script>
</body>
</html>
