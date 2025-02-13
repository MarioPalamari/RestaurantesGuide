<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Saborea Madrid | restaurantes</title>
    <link rel="stylesheet" href="{{ asset('css/restaurante.css') }}">
</head>

<body>
    <h1>Restaurantes</h1>
    <div class="contenedor">
        <div></div>

        <!-- Filtros -->
        <div class="filtros">
            <form action="" method="post">
                @csrf
                @method('post')
                <!-- Filtro de Precio -->
                <div class="filtro-item">
                    <label for="precio">Precio medio de la carta</label>
                    <input type="text" name="precio" id="precio" placeholder="Ej. 20-40">
                </div>

                <!-- Filtro de Tipo de Cocina -->
                <div class="filtro-item">
                    <label for="tipo_cocina">Tipo de cocina</label>
                    <input type="text" name="tipo_cocina" id="tipo_cocina" placeholder="Ej. Mexicana">
                </div>

                <!-- Filtro de Valoración -->
                <div class="filtro-item">
                    <label for="valoracion">Valoración de los usuarios</label>
                    <input type="text" name="valoracion" id="valoracion" placeholder="Ej. 4-5">
                </div>

                <!-- Botón de Búsqueda -->
                <div class="filtro-submit">
                    <input type="submit" value="Buscar">
                </div>

                <!-- Enlace para borrar filtros -->
                <div class="filtro-borrar">
                    <a href="#">✖ Borrar filtros</a>
                </div>
            </form>
        </div>

        <!-- Restaurantes -->
        <div class="restaurantes">
            @foreach ($restaurantes as $restaurante)
                <div class="restaurante">
                    <div class="img-container">
                        <img src="{{ asset('img/' . $restaurante->img) }}" alt="" class="img-restaurante">
                        <div class="nombre-restaurante">
                            <h3>{{ $restaurante->nombre }}</h3>
                        </div>
                    </div>

                    <form action="{{ route('restaurante.ver', $cadena = str_replace(' ', '-', $restaurante->nombre)) }}"
                        method="post" class="form-restaurante">
                        @csrf
                        @method('post')
                        <input type="hidden" name="id_restaurante" value="{{ $restaurante->id }}">
                        <button type="submit" class="btn-restaurante">
                            <div class="detalle-restaurante">
                                <p>{{ $restaurante->descripcion }}</p>
                                {{-- ✰ --}}
                                <p>Valoración:
                                    {{ $restaurante->media_valoracion == 0 ? '-- ✰' : $restaurante->media_valoracion . '★' }}
                                </p>
                                <p>Precio medio: {{ $restaurante->precio_medio }}€</p>
                                {{-- <p>{{$restaurante->etiquetas}}</p> --}}
                            </div>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Mostrar el paginador -->
    {{-- <div class="pagination">
        {{ $restaurantes->links('vendor.pagination.default') }}
    </div> --}}
</body>

</html>
