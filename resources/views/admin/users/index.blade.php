<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>

<div class="container mt-5">
    <h1>Gestión de Usuarios</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createUserModal">Crear Usuario</button>

    <!-- Filtros -->
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="filtroNombre">Nombre</label>
            <input type="text" id="filtroNombre" class="form-control" placeholder="Filtrar por nombre">
        </div>
        <div class="col-md-3">
            <label for="filtroEmail">Email</label>
            <input type="text" id="filtroEmail" class="form-control" placeholder="Filtrar por email">
        </div>
        <div class="col-md-3">
            <label for="filtroRol">Rol</label>
            <select id="filtroRol" class="form-control">
                <option value="">Todos</option>
                @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <button id="aplicarFiltros" class="btn btn-primary mt-4">Aplicar Filtros</button>
            <button id="limpiarFiltros" class="btn btn-secondary mt-4">Limpiar Filtros</button>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>
                    Nombre
                    <button class="btn btn-sm btn-sort" data-column="nombre" data-order="asc">▲</button>
                    <button class="btn btn-sm btn-sort" data-column="nombre" data-order="desc">▼</button>
                </th>
                <th>
                    Email
                    <button class="btn btn-sm btn-sort" data-column="email" data-order="asc">▲</button>
                    <button class="btn btn-sm btn-sort" data-column="email" data-order="desc">▼</button>
                </th>
                <th>
                    Rol
                    <button class="btn btn-sm btn-sort" data-column="rol" data-order="asc">▲</button>
                    <button class="btn btn-sm btn-sort" data-column="rol" data-order="desc">▼</button>
                </th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="resultadousuarios">
        </tbody>
    </table>
</div>

<!-- Modal Crear Usuario -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Crear Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createUserForm" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                        <div class="invalid-feedback" id="nombreError"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                        <div class="invalid-feedback" id="emailError"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                        <div class="invalid-feedback" id="passwordError"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rol</label>
                        <select name="rol_id" class="form-control" required>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->nombre }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="rolError"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Usuario -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" id="editNombre" name="nombre" class="form-control" required>
                        <div class="invalid-feedback" id="editNombreError"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" id="editEmail" name="email" class="form-control" required>
                        <div class="invalid-feedback" id="editEmailError"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña (dejar en blanco para no cambiar)</label>
                        <input type="password" name="password" class="form-control">
                        <div class="invalid-feedback" id="editPasswordError"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rol</label>
                        <select id="editRol" name="rol_id" class="form-control" required>
                        </select>
                        <div class="invalid-feedback" id="editRolError"></div>
                    </div>
                    <button type="submit" class="btn btn-primary" disabled>Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/admin-users.js') }}"></script>

</body>
</html>
