<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="{{ asset('css/crud-style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-black justify-content-between">
        <a style="padding-left: 1%;">
            <img src="{{ asset('img/logo2.png') }}" alt="Logo"  class="d-inline-block align-top">
        </a>
        <h3 class="text-white">Gestión de restaurantes</h3>
        <a style="padding-right: 1%;"href="{{ route('logout') }}">
            <img src="{{ asset('img/logout.png') }}" alt="Logo"  class="d-inline-block align-top pr-5">
        </a>
    </nav>
    <div class="mt-5 pr-2 ml-2">
    <div class="m-3 d-flex justify-content-between">
        <button class="btn btn-warning fw-bold px-4 py-2 rounded-0 text-uppercase" data-bs-toggle="modal" data-bs-target="#modal-crear">Crear Restaurante</button>
        <a class="icon-back" href="{{ route('admin.admin') }}"><img src="{{ asset('img/go_back.png') }}" class="icon-back" alt=""></a>
    </div>
    <div class="m-3">
        <!-- Filtros -->
    <div class="row mb-3">
            <div class="col-md-3">
                <label for="filtroNombre">Nombre</label>
                <input type="text" id="filtroNombre" class="form-control" placeholder="Filtrar por nombre">
            </div>
            <div class="col-md-3">
                <label for="filtroLugar">Ubicación</label>
                <input type="text" id="filtroLugar" class="form-control" placeholder="Filtrar por ubicación">
            </div>
            <div class="col-md-5">
                <div class="d-flex align-items-end" style="gap:20px;">
                    <div class="flex-grow-1 me-2">
                        <label for="myMultiselect">Etiquetas</label>
                        <div id="myMultiselect" class="multiselect">
                            <div id="mySelectLabel" class="selectBox" onclick="toggleCheckboxArea()">
                                <select class="form-select">
                                    <option>Seleccionar etiquetas</option>
                                </select>
                                <div class="overSelect"></div>
                            </div>
                            <div id="mySelectOptions">
                                @foreach($etiquetas as $etiqueta)
                                    <label for="etiqueta_{{ $etiqueta->id }}">
                                        <input type="checkbox" id="etiqueta_{{ $etiqueta->id }}" onchange="checkboxStatusChange()" value="{{ $etiqueta->nombre }}" />
                                        {{ $etiqueta->nombre }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div>
                        <button id="limpiarFiltros" class="btn btn-warning fw-bold px-4 py-2 rounded-0 text-uppercase">
                            Limpiar Filtros
                        </button>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="m-3">
        <table class="table">
            <thead>
                <tr>
                    <th>
                        Nombre
                        <button class="btn btn-sm btn-sort" data-column="nombre" data-order="asc">▲</button>
                        <button class="btn btn-sm btn-sort" data-column="nombre" data-order="desc">▼</button>
                    </th>
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
                <!-- La lista se cargará dinámicamente -->
            </tbody>
        </table>
    </div>
    </div>
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
                        <input type="text" class="form-control" id="nombre" name="nombre" >
                        <span id="nombreError" class="text-danger"></span>
                    </div>
                    
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                        <span id="descripcionError" class="text-danger"></span>
                    </div>

                    <div class="mb-3">
                        <label for="precio_medio" class="form-label">Precio Medio (€)</label>
                        <input type="number" step="0.01" class="form-control" id="precio_medio" name="precio_medio">
                        <span id="precioMedioError" class="text-danger"></span>
                    </div>

                    <div class="mb-3">
                        <label for="img" class="form-label">Imagen</label>
                        <input type="file" class="form-control" id="img" name="img" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label for="lugar" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="lugar" name="lugar">
                        <span id="lugarError" class="text-danger"></span>
                    </div>

                    <div class="mb-3">
                        <label for="horario" class="form-label">Horario</label>
                        <input type="text" class="form-control" id="horario" name="horario">
                        <span id="horarioError" class="text-danger"></span>
                    </div>

                    <div class="mb-3">
                        <label for="contacto" class="form-label">Contacto</label>
                        <input type="text" class="form-control" id="contacto" name="contacto">
                        <span id="contactoError" class="text-danger"></span>
                    </div>

                    <div class="mb-3">
                        <label for="web" class="form-label">Sitio Web</label>
                        <input type="url" class="form-control" id="web" name="web">
                        <span id="webError" class="text-danger"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Etiquetas</label>
                        <div class="etiquetas-container">
                            @foreach($etiquetas as $etiqueta)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="etiquetas[]" value="{{ $etiqueta->id }}" id="crear_etiqueta_{{ $etiqueta->id }}">
                                    <label class="form-check-label" for="crear_etiqueta_{{ $etiqueta->id }}">
                                        {{ $etiqueta->nombre }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <span id="etiquetasError" class="text-danger"></span>
                    </div>

                    <button type="submit"id="btnCrearRestaurante" class="btn btn-primary">Crear Restaurante</button>
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
                    <input type="text" class="form-control" id="editNombre" name="nombre" >
                    <span id="editNombreError" class="text-danger"></span>
                </div>

                <div class="mb-3">
                    <label for="editDescripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="editDescripcion" name="descripcion" rows="3"></textarea>
                    <span id="editDescripcionError" class="text-danger"></span>
                </div>

                <div class="mb-3">
                    <label for="editPrecioMedio" class="form-label">Precio Medio (€)</label>
                    <input type="number" step="0.01" class="form-control" id="editPrecioMedio" name="precio_medio">
                    <span id="editPrecioMedioError" class="text-danger"></span>
                </div>

                <div class="mb-3">
                    <label for="editImg" class="form-label">Imagen</label>
                    <input type="file" class="form-control" id="editImg" name="img" accept="image/*">
                </div>

                <div class="mb-3">
                    <label for="editLugar" class="form-label">Ubicación</label>
                    <input type="text" class="form-control" id="editLugar" name="lugar">
                    <span id="editLugarError" class="text-danger"></span>
                </div>

                <div class="mb-3">
                    <label for="editHorario" class="form-label">Horario</label>
                    <input type="text" class="form-control" id="editHorario" name="horario">
                    <span id="editHorarioError" class="text-danger"></span>
                </div>

                <div class="mb-3">
                    <label for="editContacto" class="form-label">Contacto</label>
                    <input type="text" class="form-control" id="editContacto" name="contacto">
                    <span id="editContactoError" class="text-danger"></span>
                </div>

                <div class="mb-3">
                    <label for="editWeb" class="form-label">Sitio Web</label>
                    <input type="url" class="form-control" id="editWeb" name="web">
                    <span id="editWebError" class="text-danger"></span>
                </div>

                <div class="mb-3">
                    <label class="form-label">Etiquetas</label>
                    <div class="etiquetas-container">
                        @foreach($etiquetas as $etiqueta)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="etiquetas[]" value="{{ $etiqueta->id }}" id="edit_etiqueta_{{ $etiqueta->id }}">
                                <label class="form-check-label" for="edit_etiqueta_{{ $etiqueta->id }}">
                                    {{ $etiqueta->nombre }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <span id="editEtiquetasError" class="text-danger"></span>
                </div>

                <button type="submit" id="btnEditarRestaurante" class="btn btn-primary">Actualizar Restaurante</button>
            </form>

                </div>
            </div>
        </div>
    </div>
    <script  src="{{ asset('js/crud-restaurantes-forms.js') }}"></script>
    <script  src="{{ asset('js/crud-restaurantes.js') }}"></script>

</body>
</html>
