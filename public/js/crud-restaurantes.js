window.onload = function () {
    cargarRestaurantes();
};

// Cargar los restaurantes desde el servidor
function cargarRestaurantes() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch("/restaurantes-admin/listar")
        .then(response => response.json())
        .then(data => {
            const lista = document.getElementById("listaRestaurantes");
            lista.innerHTML = ""; // Limpiar la tabla antes de agregar nuevos datos

            data.forEach(restaurante => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${restaurante.nombre}</td>
                    <td>${restaurante.descripcion}</td>
                    <td>${restaurante.precio_medio}</td>
                    <td>${restaurante.img ? `<img src="img/${restaurante.img}" width="50">` : ''}</td>
                    <td>
                        <button class="editarBtn" data-id="${restaurante.id}">Editar</button>
                        <button class="eliminarBtn" data-id="${restaurante.id}">Eliminar</button>
                    </td>
                `;
                lista.appendChild(row);
            });

            // Evento de edición
            document.querySelectorAll('.editarBtn').forEach(button => {
                button.addEventListener('click', function () {
                    const id = button.getAttribute('data-id');
                    cargarRestauranteParaEditar(id);
                });
            });

            // Evento de eliminación
            document.querySelectorAll('.eliminarBtn').forEach(button => {
                button.addEventListener('click', function () {
                    const id = button.getAttribute('data-id');
                    eliminarRestaurante(id, csrfToken);
                    cargarRestaurantes();
                });
            });
        });
}

// Cargar los datos del restaurante para editar en el formulario
function cargarRestauranteParaEditar(id) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/restaurantes-admin/listar/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.restaurante) {
                // Rellenar los campos con los datos del restaurante
                document.getElementById("editRestauranteId").value = data.restaurante.id;
                document.getElementById("editNombre").value = data.restaurante.nombre;
                document.getElementById("editDescripcion").value = data.restaurante.descripcion;
                document.getElementById("editPrecioMedio").value = data.restaurante.precio_medio;

                // Mostrar el modal de edición
                const modalEditar = new bootstrap.Modal(document.getElementById('modal-editar'));
                modalEditar.show();
            }
        })
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
    const img = document.getElementById("img").files[0];
    if (img){
        formData.append("img", img);
    } 

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
    const id = document.getElementById("editRestauranteId").value;
    formData.append("id", id);
    formData.append("nombre", document.getElementById("editNombre").value);
    formData.append("descripcion", document.getElementById("editDescripcion").value);
    formData.append("precio_medio", document.getElementById("editPrecioMedio").value);
    const img = document.getElementById("editImg").files[0];
    if (img) formData.append("img", img);

    fetch(`/restaurantes-admin/actualizar/${id}`, {
        method: "post",
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        alert(data.mensaje);
        cargarRestaurantes();
        document.getElementById("formEditarRestaurante").reset();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hubo un error al actualizar el restaurante');
    });
});
