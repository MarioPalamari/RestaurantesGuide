document.addEventListener('DOMContentLoaded', function() {
    cargarRestaurantes();
    
    // Event listeners para aplicar filtros automáticamente
    document.getElementById('filtroNombre').addEventListener('input', aplicarFiltros);
    document.getElementById('filtroLugar').addEventListener('input', aplicarFiltros);
    
    const checkboxes = document.querySelectorAll('#mySelectOptions input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', aplicarFiltros);
    });

    // Configurar evento de limpiar filtros
    document.getElementById('limpiarFiltros').addEventListener('click', function(e) {
        e.preventDefault();
        limpiarFiltros();
    });
});

// Cargar los restaurantes desde el servidor
function cargarRestaurantes() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch("/restaurantes-admin/listar")
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('listaRestaurantes');
            tbody.innerHTML = '';

            data.restaurantes.forEach(restaurante => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${restaurante.nombre}</td>
                    <td>${restaurante.descripcion}</td>
                    <td>${restaurante.precio_medio}</td>
                    <td>${restaurante.img ? `<img src="/img/${restaurante.img}" width="50">` : ''}</td>
                    <td>${restaurante.lugar}</td>
                    <td>${restaurante.horario}</td>
                    <td>${restaurante.contacto}</td>
                    <td>${restaurante.web}</td>
                    <td>${restaurante.etiquetas.map(etiqueta => etiqueta.nombre).join(', ')}</td>
                    <td class="text-center">
                        <button class="editarBtn btn btn-warning fw-bold rounded-0 text-uppercase mb-1" data-id="${restaurante.id}">Editar</button>
                        <button class="eliminarBtn btn bg-black text-white fw-bold rounded-0 text-uppercase btn-delete" data-id="${restaurante.id}">Eliminar</button>
                    </td>
                `;
                tbody.appendChild(row);
            });

            // Agregar eventos a los botones de editar y eliminar
            document.querySelectorAll('.editarBtn').forEach(button => {
                button.addEventListener('click', () => {
                    cargarRestauranteParaEditar(button.dataset.id);
                });
            });

            document.querySelectorAll('.eliminarBtn').forEach(button => {
                button.addEventListener('click', () => {
                    eliminarRestaurante(button.dataset.id, csrfToken);
                });
            });
        });
}

// Función para reiniciar completamente los checkboxes de un modal
function reiniciarCheckboxes(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.querySelectorAll('input[name="etiquetas[]"]').forEach(checkbox => {
            checkbox.checked = false;
        });
    }
}

// Reiniciar el formulario de creación al abrir el modal
document.getElementById('modal-crear').addEventListener('show.bs.modal', function () {
    document.getElementById("formCrearRestaurante").reset();
    reiniciarCheckboxes('modal-crear');
});

// Función para cargar un restaurante para editar
function cargarRestauranteParaEditar(id) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/restaurantes-admin/listar/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.restaurante) {
                // Reiniciar el formulario de edición
                document.getElementById("formEditarRestaurante").reset();
                reiniciarCheckboxes('modal-editar');

                // Rellenar campos del formulario
                document.getElementById("editRestauranteId").value = data.restaurante.id;
                document.getElementById("editNombre").value = data.restaurante.nombre;
                document.getElementById("editDescripcion").value = data.restaurante.descripcion;
                document.getElementById("editPrecioMedio").value = data.restaurante.precio_medio;
                document.getElementById("editLugar").value = data.restaurante.lugar;
                document.getElementById("editHorario").value = data.restaurante.horario;
                document.getElementById("editContacto").value = data.restaurante.contacto;
                document.getElementById("editWeb").value = data.restaurante.web;

                // Seleccionar las etiquetas actuales
                setTimeout(() => {
                    if (data.restaurante.etiquetas_transformadas) {
                        // Primero desmarcar todos los checkboxes
                        document.querySelectorAll('#modal-editar input[name="etiquetas[]"]').forEach(checkbox => {
                            checkbox.checked = false;
                        });

                        // Luego marcar solo los seleccionados
                        data.restaurante.etiquetas_transformadas.forEach(etiqueta => {
                            if (etiqueta.selected) {
                                const checkbox = document.querySelector(`#modal-editar input[name="etiquetas[]"][value="${etiqueta.id}"]`);
                                if (checkbox) {
                                    checkbox.checked = true;
                                }
                            }
                        });
                    }
                }, 100); // Esperar 100ms antes de marcar los checkboxes

                const modalEditar = new bootstrap.Modal(document.getElementById('modal-editar'));
                modalEditar.show();
            }
        });
}

// Eliminar restaurante
function eliminarRestaurante(id, csrfToken) {
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
            fetch(`/restaurantes-admin/eliminar/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.mensaje) {
                    Swal.fire(
                        '¡Eliminado!',
                        'El restaurante ha sido eliminado.',
                        'success'
                    );
                    cargarRestaurantes();
                } else {
                    Swal.fire(
                        'Error',
                        'Hubo un problema al eliminar el restaurante.',
                        'error'
                    );
                }
            })
            .catch(error => {
                Swal.fire(
                    'Error',
                    'Hubo un problema al eliminar el restaurante: ' + error.message,
                    'error'
                );
            });
        }
    });
}

// Verificar si el formulario existe antes de agregar el event listener
const createForm = document.getElementById('formCrearRestaurante');
if (createForm) {
    createForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        let formData = new FormData(this);

        fetch("/restaurantes-admin/crear", {
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
            if (data.mensaje) {
                Swal.fire(
                    '¡Creado!',
                    'El restaurante ha sido creado exitosamente.',
                    'success'
                );
                cargarRestaurantes();
                document.querySelector("#modal-crear .btn-close").click();
                this.reset();
            }
        })
        .catch(error => {
            Swal.fire(
                'Error',
                'Hubo un problema al crear el restaurante: ' + error.message,
                'error'
            );
        });
    });
}

// Verificar si el formulario de edición existe antes de agregar el event listener
const editForm = document.getElementById('formEditarRestaurante');
if (editForm) {
    editForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        let restauranteId = document.getElementById('editRestauranteId').value;
        let formData = new FormData(this);

        fetch(`/restaurantes-admin/actualizar/${restauranteId}`, {
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
            if (data.mensaje) {
                Swal.fire(
                    '¡Actualizado!',
                    'El restaurante ha sido actualizado exitosamente.',
                    'success'
                );
                cargarRestaurantes();
                document.querySelector("#modal-editar .btn-close").click();
            }
        })
        .catch(error => {
            Swal.fire(
                'Error',
                'Hubo un problema al actualizar el restaurante: ' + error.message,
                'error'
            );
        });
    });
}

function mostrarRestaurantes(restaurantes) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const tbody = document.getElementById('listaRestaurantes');
    tbody.innerHTML = '';

    restaurantes.forEach(restaurante => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${restaurante.nombre}</td>
            <td>${restaurante.descripcion}</td>
            <td>${restaurante.precio_medio}</td>
            <td>${restaurante.img ? `<img src="/img/${restaurante.img}" width="50">` : ''}</td>
            <td>${restaurante.lugar}</td>
            <td>${restaurante.horario}</td>
            <td>${restaurante.contacto}</td>
            <td>${restaurante.web}</td>
            <td>${restaurante.etiquetas.map(etiqueta => etiqueta.nombre).join(', ')}</td>
            <td class="text-center">
                <button class="btn btn-warning fw-bold rounded-0 text-uppercase mb-1 btn-edit editarBtn"  data-id="${restaurante.id}">Editar</button>
                <button class="btn bg-black text-white fw-bold rounded-0 text-uppercase btn-delete eliminarBtn" data-id="${restaurante.id}">Eliminar</button>
            </td>
        `;
        tbody.appendChild(row);
    });

    
    // Agregar eventos a los botones de editar y eliminar
    document.querySelectorAll('.editarBtn').forEach(button => {
        button.addEventListener('click', () => {
            cargarRestauranteParaEditar(button.dataset.id);
        });
    });

    document.querySelectorAll('.eliminarBtn').forEach(button => {
        button.addEventListener('click', () => {
            eliminarRestaurante(button.dataset.id, csrfToken);
        });
    });
}

function aplicarFiltros(sortColumn = null, sortOrder = null) {
    const nombre = document.getElementById('filtroNombre').value;
    const lugar = document.getElementById('filtroLugar').value;
    const etiquetas = Array.from(document.querySelectorAll('#mySelectOptions input[type="checkbox"]:checked'))
        .map(checkbox => {
            const label = checkbox.closest('label');
            return label ? label.textContent.trim() : '';
        });

    let url = `/restaurantes-admin/listar?nombre=${nombre}&lugar=${lugar}`;
    
    if (etiquetas.length > 0) {
        url += `&etiquetas=${etiquetas.join(',')}`;
    }

    if (sortColumn && sortOrder) {
        url += `&sort_column=${sortColumn}&sort_order=${sortOrder}`;
    }

    fetch(url, {
        method: "GET",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        mostrarRestaurantes(data.restaurantes);
    })
    .catch(error => {
        console.error("Error:", error);
        alert('Hubo un error al aplicar los filtros');
    });
}

function limpiarFiltros() {
    // Limpiar los valores de los filtros
    document.getElementById('filtroNombre').value = '';
    document.getElementById('filtroLugar').value = '';
    
    // Desmarcar todas las etiquetas
    const checkboxes = document.querySelectorAll('#mySelectOptions input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
    
    // Actualizar el texto del dropdown
    checkboxStatusChange();
    
    // Aplicar los filtros automáticamente
    aplicarFiltros();
}

// Verificar si el elemento existe antes de agregar el event listener
const aplicarFiltrosBtn = document.getElementById('aplicarFiltros');
if (aplicarFiltrosBtn) {
    aplicarFiltrosBtn.addEventListener('click', aplicarFiltros);
}

// Verificar si el elemento existe antes de agregar el event listener
const limpiarFiltrosBtn = document.getElementById('limpiarFiltros');
if (limpiarFiltrosBtn) {
    limpiarFiltrosBtn.addEventListener('click', limpiarFiltros);
}

// Verificar si el elemento existe antes de agregar el event listener
const mySelectLabel = document.getElementById('mySelectLabel');
if (mySelectLabel) {
    mySelectLabel.addEventListener('click', toggleCheckboxArea);
}

// Verificar si el elemento existe antes de agregar el event listener
const checkboxes = document.querySelectorAll('#mySelectOptions input[type="checkbox"]');
if (checkboxes.length > 0) {
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', checkboxStatusChange);
    });
}

// Event listeners para los botones de ordenación
document.addEventListener("click", function(event) {
    if (event.target.classList.contains("btn-sort")) {
        const column = event.target.getAttribute("data-column");
        const order = event.target.getAttribute("data-order");
        
        // Obtener los valores actuales de los filtros
        const nombre = document.getElementById('filtroNombre').value;
        const lugar = document.getElementById('filtroLugar').value;
        const etiquetas = Array.from(document.querySelectorAll('#mySelectOptions input[type="checkbox"]:checked'))
            .map(checkbox => checkbox.value);

        // Construir la URL con los parámetros
        let url = `/restaurantes-admin/listar?nombre=${nombre}&lugar=${lugar}`;
        
        if (etiquetas.length > 0) {
            url += `&etiquetas=${etiquetas.join(',')}`;
        }
        
        url += `&sort_column=${column}&sort_order=${order}`;

        fetch(url, {
            method: "GET",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => {
            if (!response.ok) throw new Error("Error en la respuesta del servidor");
            return response.json();
        })
        .then(data => {
            mostrarRestaurantes(data.restaurantes);
        })
        .catch(error => {
            console.error("Error:", error);
            Swal.fire(
                'Error',
                'Hubo un problema al ordenar los restaurantes',
                'error'
            );
        });
    }
});

// Función para mostrar/ocultar el área de checkboxes
function toggleCheckboxArea(onlyHide = false) {
    var checkboxes = document.getElementById("mySelectOptions");
    if (!checkboxes) return; // Verificar si el elemento existe

    var displayValue = checkboxes.style.display;

    if (displayValue != "block" && !onlyHide) {
        checkboxes.style.display = "block";
    } else {
        checkboxes.style.display = "none";
    }
}

// Función para actualizar el texto del selector cuando cambian los checkboxes
function checkboxStatusChange() {
    var multiselect = document.getElementById("mySelectLabel");
    if (!multiselect) return; // Verificar si el elemento existe

    var multiselectOption = multiselect.getElementsByTagName('option')[0];
    if (!multiselectOption) return; // Verificar si el elemento existe

    var values = [];
    var checkboxes = document.getElementById("mySelectOptions");
    if (!checkboxes) return; // Verificar si el elemento existe

    var checkedCheckboxes = checkboxes.querySelectorAll('input[type=checkbox]:checked');

    checkedCheckboxes.forEach(item => {
        const label = item.closest('label');
        if (label) {
            values.push(label.textContent.trim());
        }
    });

    var dropdownValue = "Seleccionar etiquetas";
    if (values.length > 0) {
        dropdownValue = values.join(', ');
    }

    multiselectOption.innerText = dropdownValue;
}

// Event listeners para el selector de etiquetas
document.addEventListener("DOMContentLoaded", function() {
    const selectLabel = document.getElementById("mySelectLabel");
    if (selectLabel) {
        selectLabel.addEventListener("click", function() {
            toggleCheckboxArea();
        });
    }

    const checkboxes = document.querySelectorAll('#mySelectOptions input[type="checkbox"]');
    if (checkboxes.length > 0) {
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener("change", checkboxStatusChange);
        });
    }

    // Cerrar el área de checkboxes al hacer clic fuera
    document.addEventListener("click", function(event) {
        const selectBox = document.querySelector(".selectBox");
        const mySelectOptions = document.getElementById("mySelectOptions");

        if (selectBox && mySelectOptions) {
            if (!selectBox.contains(event.target) && !mySelectOptions.contains(event.target)) {
                toggleCheckboxArea(true);
            }
        }
    });
});
