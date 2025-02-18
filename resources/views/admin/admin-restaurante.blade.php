<head>
    <meta charset="UTF-8">
    <title>Administrar Restaurantes</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Agregar los scripts de Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
<div class="mt-5 m-2">
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modal-crear">Crear restaurante</button>
    <h2>Administrar Restaurantes</h2>
</div>

<table class="table">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio Medio</th>
            <th>Imagen</th>
            <th>Ubicación</th>
            <th>Horario</th>
            <th>Contacto</th>
            <th>Web</th>
            <th>Etiquetas</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="listaRestaurantes">
        @foreach($restaurantes as $restaurante)
            <tr>
                <td>{{ $restaurante->nombre }}</td>
                <td>{{ $restaurante->descripcion }}</td>
                <td>{{ $restaurante->precio_medio }}</td>
                <td>
                    @if($restaurante->img)
                        <img src="{{ asset('img/' . $restaurante->img) }}" width="50">
                    @endif
                </td>
                <td>{{ $restaurante->lugar }}</td>
                <td>{{ $restaurante->horario }}</td>
                <td>{{ $restaurante->contacto }}</td>
                <td>{{ $restaurante->web }}</td>
                <td>{{ $restaurante->etiquetas->pluck('nombre')->join(', ') }}</td>
                <td>
                    <button class="editarBtn" data-id="{{ $restaurante->id }}">Editar</button>
                    <button class="eliminarBtn" data-id="{{ $restaurante->id }}">Eliminar</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal para Crear Restaurante -->
<div class="modal fade" id="modal-crear" tabindex="-1" aria-labelledby="modalCrearLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCrearLabel">Crear Nuevo Restaurante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formCrearRestaurante" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Restaurante</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="precio_medio" class="form-label">Precio Medio (€)</label>
                        <input type="number" step="0.01" class="form-control" id="precio_medio" name="precio_medio">
                    </div>
                    <div class="mb-3">
                        <label for="img" class="form-label">Imagen</label>
                        <input type="file" class="form-control" id="img" name="img" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="lugar" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="lugar" name="lugar">
                    </div>
                    <div class="mb-3">
                        <label for="horario" class="form-label">Horario</label>
                        <input type="text" class="form-control" id="horario" name="horario">
                    </div>
                    <div class="mb-3">
                        <label for="contacto" class="form-label">Contacto</label>
                        <input type="text" class="form-control" id="contacto" name="contacto">
                    </div>
                    <div class="mb-3">
                        <label for="web" class="form-label">Sitio Web</label>
                        <input type="url" class="form-control" id="web" name="web">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Etiquetas</label>
                        <div class="etiquetas-container">
                            @foreach($etiquetas as $etiqueta)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="etiquetas[]" 
                                           value="{{ $etiqueta->id }}" id="crear_etiqueta_{{ $etiqueta->id }}">
                                    <label class="form-check-label" for="crear_etiqueta_{{ $etiqueta->id }}">
                                        {{ $etiqueta->nombre }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Crear Restaurante</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Editar Restaurante -->
<div class="modal fade" id="modal-editar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarLabel">Editar Restaurante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarRestaurante" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="editRestauranteId" name="id">
                    <div class="mb-3">
                        <label for="editNombre" class="form-label">Nombre del Restaurante</label>
                        <input type="text" class="form-control" id="editNombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDescripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="editDescripcion" name="descripcion" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editPrecioMedio" class="form-label">Precio Medio (€)</label>
                        <input type="number" step="0.01" class="form-control" id="editPrecioMedio" name="precio_medio">
                    </div>
                    <div class="mb-3">
                        <label for="editImg" class="form-label">Imagen</label>
                        <input type="file" class="form-control" id="editImg" name="img" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="editLugar" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="editLugar" name="lugar">
                    </div>
                    <div class="mb-3">
                        <label for="editHorario" class="form-label">Horario</label>
                        <input type="text" class="form-control" id="editHorario" name="horario">
                    </div>
                    <div class="mb-3">
                        <label for="editContacto" class="form-label">Contacto</label>
                        <input type="text" class="form-control" id="editContacto" name="contacto">
                    </div>
                    <div class="mb-3">
                        <label for="editWeb" class="form-label">Sitio Web</label>
                        <input type="url" class="form-control" id="editWeb" name="web">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Etiquetas</label>
                        <div class="etiquetas-container">
                            @foreach($etiquetas as $etiqueta)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="etiquetas[]" 
                                           value="{{ $etiqueta->id }}" id="edit_etiqueta_{{ $etiqueta->id }}">
                                    <label class="form-check-label" for="edit_etiqueta_{{ $etiqueta->id }}">
                                        {{ $etiqueta->nombre }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar Restaurante</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script  src="{{ asset('js/crud-restaurantes.js') }}"></script>

</body>
</html>
