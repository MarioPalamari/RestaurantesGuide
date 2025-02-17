window.onload = function () {
    cargarRestaurantes();
};

function cargarRestaurantes() {
    // Obtener el CSRF token del meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch("/restaurantes/listar")
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
                        <button class="eliminarBtn" data-id="${restaurante.id}">Eliminar</button>
                    </td>
                `;
                lista.appendChild(row);
            });

            // Agregar el evento de eliminación para los botones generados dinámicamente
            document.querySelectorAll('.eliminarBtn').forEach(button => {
                button.addEventListener('click', function () {
                    const id = button.getAttribute('data-id');
                    eliminarRestaurante(id, csrfToken);
                });
            });
        })
}

function eliminarRestaurante(id, csrfToken) {
    if (confirm("¿Estás seguro de eliminar este restaurante?")) {
        fetch(`/restaurantes/eliminar/${id}`, {
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
            })
    }
    cargarRestaurantes();

}

document.getElementById("formRestaurante").addEventListener("submit", function(event) {
    event.preventDefault();  // Evita el comportamiento de enviar el formulario de manera tradicional

    let formData = new FormData();
    
    // Obtener los valores de los campos de texto
    const nombre = document.getElementById("nombre").value;
    const descripcion = document.getElementById("descripcion").value;
    const precio_medio = document.getElementById("precio_medio").value;
    
    // Verificar si los campos obligatorios tienen valor
    if (!nombre) {
        alert("El nombre del restaurante es obligatorio.");
        return;
    }
    
    // Añadir los campos al FormData
    formData.append("nombre", nombre);
    formData.append("descripcion", descripcion);
    formData.append("precio_medio", precio_medio);

    // Verificar si la imagen fue seleccionada antes de agregarla al FormData
    const img = document.getElementById("img").files[0];
    if (img) {
        formData.append("img", img);
    }

    // Realizar la solicitud con FormData
    fetch("/restaurantes/crear", {
        method: "POST",  // Usar POST
        body: formData,  // Enviar los datos con FormData
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')  // Añadir el token CSRF
        }
    })
    .then(response => response.json())
    .then(data => {
        alert(data.mensaje);
        document.getElementById("formRestaurante").reset();  // Resetear el formulario después de la creación
        cargarRestaurantes();  // Recargar los restaurantes (si tienes esa función)
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hubo un error al crear el restaurante');
    });
});

