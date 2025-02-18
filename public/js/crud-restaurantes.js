document.addEventListener('DOMContentLoaded', function() {
    cargarRestaurantes();
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
                    <td>
                        <button class="editarBtn" data-id="${restaurante.id}">Editar</button>
                        <button class="eliminarBtn" data-id="${restaurante.id}">Eliminar</button>
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
    if (confirm("¿Estás seguro de eliminar este restaurante?")) {
        fetch(`/restaurantes-admin/eliminar/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `_method=DELETE&_token=${csrfToken}`,
        })
        .then(response => response.json())
        .then(data => {
            alert(data.mensaje);
            cargarRestaurantes(); // Recargar la lista de restaurantes después de la eliminación
        });
    }
}

// Manejar la creación de restaurante
document.getElementById("formCrearRestaurante").addEventListener("submit", function(event) {
    event.preventDefault();

    let formData = new FormData();
    formData.append("nombre", document.getElementById("nombre").value);
    formData.append("descripcion", document.getElementById("descripcion").value);
    formData.append("precio_medio", document.getElementById("precio_medio").value);
    formData.append("lugar", document.getElementById("lugar").value);
    formData.append("horario", document.getElementById("horario").value);
    formData.append("contacto", document.getElementById("contacto").value);
    formData.append("web", document.getElementById("web").value);
    
    // Agregar etiquetas seleccionadas
    const checkboxes = document.querySelectorAll('input[name="etiquetas[]"]:checked');
    checkboxes.forEach(checkbox => {
        formData.append("etiquetas[]", checkbox.value);
    });

    const img = document.getElementById("img").files[0];
    if (img) formData.append("img", img);

    fetch("/restaurantes-admin/crear", {
        method: "POST",
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        alert(data.mensaje);
        cargarRestaurantes();
        document.getElementById("formCrearRestaurante").reset();
        
        // Cerrar el modal de creación
        const modalCrear = bootstrap.Modal.getInstance(document.getElementById('modal-crear'));
        modalCrear.hide();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hubo un error al crear el restaurante');
    });
});

// Manejar la actualización de restaurante
document.getElementById("formEditarRestaurante").addEventListener("submit", function(event) {
    event.preventDefault();

    let formData = new FormData();
    formData.append("id", document.getElementById("editRestauranteId").value);
    formData.append("nombre", document.getElementById("editNombre").value);
    formData.append("descripcion", document.getElementById("editDescripcion").value);
    formData.append("precio_medio", document.getElementById("editPrecioMedio").value);
    formData.append("lugar", document.getElementById("editLugar").value);
    formData.append("horario", document.getElementById("editHorario").value);
    formData.append("contacto", document.getElementById("editContacto").value);
    formData.append("web", document.getElementById("editWeb").value);
    
    // Agregar etiquetas seleccionadas
    const checkboxes = document.querySelectorAll('input[name="etiquetas[]"]:checked');
    checkboxes.forEach(checkbox => {
        formData.append("etiquetas[]", checkbox.value);
    });

    const img = document.getElementById("editImg").files[0];
    if (img) formData.append("img", img);

    fetch("/restaurantes-admin/actualizar/" + document.getElementById("editRestauranteId").value, {
        method: "POST",
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => { throw new Error(text) });
        }
        return response.json();
    })
    .then(data => {
        alert(data.mensaje);
        cargarRestaurantes();
        
        // Cerrar el modal de edición
        const modalEditar = bootstrap.Modal.getInstance(document.getElementById('modal-editar'));
        modalEditar.hide();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hubo un error al actualizar el restaurante: ' + error.message);
    });
});
