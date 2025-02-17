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
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createRestauranteModal">Crear restaurante</button>
    <h2>Administrar Restaurantes</h2>
</div>

<table class="table">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio Medio</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="listaRestaurantes"></tbody>
</table>

<!-- Modal para Crear Restaurante -->
<div class="modal fade" id="createRestauranteModal" tabindex="-1" aria-labelledby="createRestauranteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRestauranteModalLabel">Nuevo Restaurante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formCrearRestaurante" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="nombre">Nombre del Restaurante</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre del restaurante" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="descripcion">Descripción</label>
                        <input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Descripción">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="precio_medio">Precio Medio</label>
                        <input type="text" id="precio_medio" name="precio_medio" class="form-control" placeholder="Precio medio">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="img">Imagen</label>
                        <input type="file" id="img" name="img" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Crear Restaurante</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Editar Restaurante -->
<div id="modal-editar" class="modal fade" id="editRestauranteModal" tabindex="-1" aria-labelledby="editRestauranteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRestauranteModalLabel">Editar Restaurante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="formEditarRestaurante" method="POST" enctype="multipart/form-data">
                @csrf
                @method('post')  <!-- Esto hace que la solicitud sea un PUT -->
                <input type="hidden" id="editRestauranteId" name="id">
                <div class="mb-3">
                    <label class="form-label" for="editNombre">Nombre del Restaurante</label>
                    <input type="text" id="editNombre" name="nombre" class="form-control" placeholder="Nombre del restaurante" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="editDescripcion">Descripción</label>
                    <input type="text" id="editDescripcion" name="descripcion" class="form-control" placeholder="Descripción">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="editPrecioMedio">Precio Medio</label>
                    <input type="text" id="editPrecioMedio" name="precio_medio" class="form-control" placeholder="Precio medio">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="editImg">Imagen</label>
                    <input type="file" id="editImg" name="img" class="form-control">
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
