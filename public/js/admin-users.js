document.addEventListener("DOMContentLoaded", function() {
    let editUserModal = document.getElementById("editUserModal");

    // **Abrir Modal de Edición y Llenar Datos**
    editUserModal.addEventListener("show.bs.modal", function(event) {
        let button = event.relatedTarget;
        let userId = button.getAttribute("data-id");
        let nombre = button.getAttribute("data-nombre");
        let email = button.getAttribute("data-email");
        let rol_id = button.getAttribute("data-rol_id");
        let restaurante_id = button.getAttribute("data-restaurante_id");

        document.getElementById("editNombre").value = nombre;
        document.getElementById("editEmail").value = email;
        document.getElementById("editRol").value = rol_id;
        document.getElementById("editRestaurante").value = restaurante_id || '';

        // Cargar los roles en el select
        fetch("/datosusuarios")
            .then(response => response.json())
            .then(data => {
                let select = document.getElementById("editRol");
                select.innerHTML = ""; // Limpiar opciones anteriores
                
                data.roles.forEach(rol => {
                    let option = document.createElement("option");
                    option.value = rol.id;
                    option.text = rol.nombre;
                    if (rol.id == rol_id) {
                        option.selected = true;
                    }
                    select.appendChild(option);
                });
            });

        let form = document.getElementById("editUserForm");
        form.setAttribute("data-id", userId);
    });

    // **Actualizar Usuario con SweetAlert**
    document.getElementById("editUserForm").addEventListener("submit", function(event) {
        event.preventDefault();

        let userId = this.getAttribute("data-id");
        let formData = new FormData(this);

        fetch(`/admin/users/update/${userId}`, {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Accept": "application/json"
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                Swal.fire(
                    '¡Actualizado!',
                    'El usuario ha sido actualizado.',
                    'success'
                );
                mostrarusers();
                document.querySelector("#editUserModal .btn-close").click();
            }
        })
        .catch(error => {
            if (error.errors) {
                // Limpiar errores anteriores
                document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
                document.querySelectorAll('.form-control').forEach(el => el.classList.remove('is-invalid'));

                // Mostrar errores en los campos correspondientes
                for (let field in error.errors) {
                    let errorMessage = error.errors[field][0];
                    let inputField = document.querySelector(`[name="${field}"]`);
                    let errorContainer = document.getElementById(`edit${field.charAt(0).toUpperCase() + field.slice(1)}Error`);

                    if (inputField && errorContainer) {
                        inputField.classList.add('is-invalid');
                        errorContainer.textContent = errorMessage;
                    }
                }
            } else {
                Swal.fire(
                    'Error',
                    'Hubo un problema al actualizar el usuario.',
                    'error'
                );
            }
        });
    });

    // **Crear Usuario con SweetAlert**
    document.querySelector("#createUserModal form").addEventListener("submit", function(event) {
        event.preventDefault();

        let formData = new FormData(this);

        fetch("/admin/users/store", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Accept": "application/json"
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                Swal.fire(
                    '¡Creado!',
                    'El usuario ha sido creado exitosamente.',
                    'success'
                );
                mostrarusers();
                document.querySelector("#createUserModal .btn-close").click();
                this.reset();
            }
        })
        .catch(error => {
            if (error.errors) {
                // Limpiar errores anteriores
                document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
                document.querySelectorAll('.form-control').forEach(el => el.classList.remove('is-invalid'));

                // Mostrar errores en los campos correspondientes
                for (let field in error.errors) {
                    let errorMessage = error.errors[field][0];
                    let inputField = document.querySelector(`[name="${field}"]`);
                    let errorContainer = document.getElementById(`${field}Error`);

                    if (inputField && errorContainer) {
                        inputField.classList.add('is-invalid');
                        errorContainer.textContent = errorMessage;
                    }
                }
            } else {
                Swal.fire(
                    'Error',
                    'Hubo un problema al crear el usuario.',
                    'error'
                );
            }
        });
    });

    // **Eliminar Usuario con SweetAlert**
    document.addEventListener("click", function(event) {
        if (event.target.classList.contains("btn-delete")) {
            let userId = event.target.getAttribute("data-id");

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/users/destroy/${userId}`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                '¡Eliminado!',
                                'El usuario ha sido eliminado.',
                                'success'
                            );
                            event.target.closest("tr").remove();
                        } else {
                            Swal.fire(
                                'Error',
                                'Hubo un problema al eliminar el usuario.',
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        Swal.fire(
                            'Error',
                            'Hubo un problema al eliminar el usuario.',
                            'error'
                        );
                        console.error("Error:", error);
                    });
                }
            });
        }
    });

    mostrarusers();
});

function mostrarusers() {
    var resultado = document.getElementById("resultadousuarios");
    
    fetch("/datosusuarios", {
        method: "GET",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        if (!response.ok) throw new Error("Error al cargar los datos");
        return response.json();
    })
    .then(data => {
        console.log("Datos recibidos:", data);
        mostrarUsuarios(data.usuarios);
    })
    .catch(error => {
        console.error("Hubo un error:", error);
        manejarError("Error al cargar los usuarios");
    });
}

document.getElementById('createUserModal').addEventListener('show.bs.modal', function() {
    verificarFormularioCrear();
    fetch("/datosusuarios")
        .then(response => response.json())
        .then(data => {
            let select = document.getElementById("createRol");
            select.innerHTML = ""; // Limpiar opciones anteriores
            
            data.roles.forEach(rol => {
                let option = document.createElement("option");
                option.value = rol.id;
                option.text = rol.nombre;
                select.appendChild(option);
            });
        });
});

function aplicarFiltros() {
    let nombre = document.getElementById('filtroNombre').value;
    let email = document.getElementById('filtroEmail').value;
    let rol_id = document.getElementById('filtroRol').value;

    fetch(`/datosusuarios?nombre=${nombre}&email=${email}&rol_id=${rol_id}`, {
        method: "GET",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        mostrarUsuarios(data.usuarios);
    })
    .catch(error => console.error("Error:", error));
}

function mostrarUsuarios(usuarios) {
    console.log("Usuarios a mostrar:", usuarios);
    let resultado = document.getElementById("resultadousuarios");
    resultado.innerHTML = ""; // Limpiar contenido anterior

    usuarios.forEach(usuario => {
        let restaurante = usuario.gerente_restaurante && usuario.gerente_restaurante.restaurante 
            ? usuario.gerente_restaurante.restaurante.nombre 
            : 'N/A';

        let mostrarusuariosHTML = `
            <tr>
                <td>${usuario.nombre}</td>
                <td>${usuario.email}</td>
                <td>${usuario.rol.nombre}</td>
                <td>${restaurante}</td>
                <td class="d-flex justify-content-center gap-1">
                    <button class="btn btn-warning btn-edit fw-bold rounded-0 text-uppercase" 
                        data-bs-toggle="modal" 
                        data-bs-target="#editUserModal" 
                        data-id="${usuario.id}"
                        data-nombre="${usuario.nombre}" 
                        data-email="${usuario.email}"
                        data-rol_id="${usuario.rol_id}"
                        data-restaurante_id="${usuario.gerente_restaurante ? usuario.gerente_restaurante.id_restaurante : ''}">
                        Editar
                    </button>
                    <button class="btn bg-black text-white btn-delete fw-bold rounded-0 text-uppercase" data-id="${usuario.id}">Eliminar</button>
                </td>
            </tr>`;
        resultado.innerHTML += mostrarusuariosHTML;
    });
}

document.getElementById('aplicarFiltros').addEventListener('click', aplicarFiltros);

// Llamar a la función cuando se cargue la página
document.addEventListener("DOMContentLoaded", function() {
    aplicarFiltros();
});

function limpiarFiltros() {
    // Limpiar los campos de filtro
    document.getElementById('filtroNombre').value = '';
    document.getElementById('filtroEmail').value = '';
    document.getElementById('filtroRol').value = '';

    // Recargar la lista de usuarios sin filtros
    aplicarFiltros();
}

document.getElementById('limpiarFiltros').addEventListener('click', limpiarFiltros);

// **Manejo de errores con SweetAlert**
function manejarError(mensaje) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: mensaje,
    });
}

// **Ordenación**
document.addEventListener("click", function(event) {
    if (event.target.classList.contains("btn-sort")) {
        let column = event.target.getAttribute("data-column");
        let order = event.target.getAttribute("data-order");

        // Obtener los valores actuales de los filtros
        let nombre = document.getElementById('filtroNombre').value;
        let email = document.getElementById('filtroEmail').value;
        let rol_id = document.getElementById('filtroRol').value;

        // Aplicar filtros y ordenación
        fetch(`/datosusuarios?nombre=${nombre}&email=${email}&rol_id=${rol_id}&sort_column=${column}&sort_order=${order}`, {
            method: "GET",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            mostrarUsuarios(data.usuarios);
        })
        .catch(error => console.error("Error:", error));
    }
});

// **Validaciones onBlur**
function validarNombre(nombre) {
    const regex = /^[a-zA-Z0-9\s]+$/; // Letras, números y espacios
    return regex.test(nombre);
}

function validarEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Formato de email válido
    return regex.test(email);
}

function validarPassword(password) {
    const regex = /^(?=.*\d).{6,}$/; // Al menos 6 caracteres y un número
    return regex.test(password);
}

// **Validar campo nombre**
document.querySelector('input[name="nombre"]')?.addEventListener('keyup', function() {
    const errorContainer = document.getElementById('nombreError');
    if (!validarNombre(this.value)) {
        this.classList.add('is-invalid');
        errorContainer.textContent = 'El nombre solo puede contener letras, números y espacios.';
    } else {
        this.classList.remove('is-invalid');
        errorContainer.textContent = '';
    }
    verificarFormularioCrear();
});

// **Validar campo email**
document.querySelector('input[name="email"]')?.addEventListener('keyup', function() {
    const errorContainer = document.getElementById('emailError');
    if (!validarEmail(this.value)) {
        this.classList.add('is-invalid');
        errorContainer.textContent = 'Ingresa un email válido.';
    } else {
        this.classList.remove('is-invalid');
        errorContainer.textContent = '';
    }
    verificarFormularioCrear();
});

// **Validar campo contraseña**
document.querySelector('input[name="password"]')?.addEventListener('keyup', function() {
    const errorContainer = document.getElementById('passwordError');
    if (!validarPassword(this.value)) {
        this.classList.add('is-invalid');
        errorContainer.textContent = 'La contraseña debe tener al menos 6 caracteres y un número.';
    } else {
        this.classList.remove('is-invalid');
        errorContainer.textContent = '';
    }
    verificarFormularioCrear();
});

// **Validar campo nombre en edición**
document.querySelector('#editUserModal input[name="nombre"]')?.addEventListener('keyup', function() {
    const errorContainer = document.getElementById('editNombreError');
    if (!validarNombre(this.value)) {
        this.classList.add('is-invalid');
        errorContainer.textContent = 'El nombre solo puede contener letras, números y espacios.';
    } else {
        this.classList.remove('is-invalid');
        errorContainer.textContent = '';
    }
    verificarFormularioEditar();
});

// **Validar campo email en edición**
document.querySelector('#editUserModal input[name="email"]')?.addEventListener('keyup', function() {
    const errorContainer = document.getElementById('editEmailError');
    if (!validarEmail(this.value)) {
        this.classList.add('is-invalid');
        errorContainer.textContent = 'Ingresa un email válido.';
    } else {
        this.classList.remove('is-invalid');
        errorContainer.textContent = '';
    }
    verificarFormularioEditar();
});

// **Validar campo contraseña en edición**
document.querySelector('#editUserModal input[name="password"]')?.addEventListener('keyup', function() {
    const errorContainer = document.getElementById('editPasswordError');
    if (this.value && !validarPassword(this.value)) {
        this.classList.add('is-invalid');
        errorContainer.textContent = 'La contraseña debe tener al menos 6 caracteres y un número.';
    } else {
        this.classList.remove('is-invalid');
        errorContainer.textContent = '';
    }
    verificarFormularioEditar();
});

// **Verificar si el formulario de creación es válido**
function verificarFormularioCrear() {
    const nombre = document.querySelector('input[name="nombre"]').value;
    const email = document.querySelector('input[name="email"]').value;
    const password = document.querySelector('input[name="password"]').value;
    const botonCrear = document.querySelector('#createUserForm button[type="submit"]');

    const esValido = validarNombre(nombre) && validarEmail(email) && validarPassword(password);
    botonCrear.disabled = !esValido;
}

// **Verificar si el formulario de edición es válido**
function verificarFormularioEditar() {
    const nombre = document.querySelector('#editUserModal input[name="nombre"]').value;
    const email = document.querySelector('#editUserModal input[name="email"]').value;
    const password = document.querySelector('#editUserModal input[name="password"]').value;
    const botonEditar = document.querySelector('#editUserForm button[type="submit"]');

    const esValido = validarNombre(nombre) && validarEmail(email) && (password === '' || validarPassword(password));
    botonEditar.disabled = !esValido;
}

// **Abrir Modal de Creación**
document.getElementById('createUserModal').addEventListener('show.bs.modal', function() {
    verificarFormularioCrear();
});

// **Abrir Modal de Edición**
document.getElementById('editUserModal').addEventListener('show.bs.modal', function() {
    verificarFormularioEditar();
});