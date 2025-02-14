document.addEventListener("DOMContentLoaded", function() {
    let editUserModal = document.getElementById("editUserModal");

    // **Abrir Modal de Edición y Llenar Datos**
    editUserModal.addEventListener("show.bs.modal", function(event) {
        let button = event.relatedTarget;
        let userId = button.getAttribute("data-id");
        let nombre = button.getAttribute("data-nombre");
        let email = button.getAttribute("data-email");
        let rol_id = button.getAttribute("data-rol_id");

        document.getElementById("editNombre").value = nombre;
        document.getElementById("editEmail").value = email;
        document.getElementById("editRol").value = rol_id;

        let form = document.getElementById("editUserForm");
        form.setAttribute("data-id", userId);
    });

    // **Actualizar Usuario con AJAX**
    document.getElementById("editUserForm").addEventListener("submit", function(event) {
        event.preventDefault();

        let userId = this.getAttribute("data-id");
        let formData = new FormData(this);

        fetch(`/admin/users/update/${userId}`, {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let row = document.querySelector(`button[data-id='${userId}']`).closest("tr");
                row.innerHTML = `
                    <td>${data.user.nombre}</td>
                    <td>${data.user.email}</td>
                    <td>${data.user.rol}</td>
                    <td>
                        <button class="btn btn-warning btn-edit" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editUserModal" 
                            data-id="${data.user.id}"
                            data-nombre="${data.user.nombre}" 
                            data-email="${data.user.email}"
                            data-rol_id="${data.user.rol_id}">
                            Editar
                        </button>
                        <button class="btn btn-danger btn-delete" data-id="${data.user.id}">Eliminar</button>
                    </td>
                `;
                document.querySelector("#editUserModal .btn-close").click();
            }
        })
        .catch(error => console.error("Error:", error));
    });

    // **Crear Usuario con AJAX**
    document.querySelector("#createUserModal form").addEventListener("submit", function(event) {
        event.preventDefault();

        let formData = new FormData(this);

        fetch("/admin/users/store", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let newRow = document.createElement("tr");
                newRow.innerHTML = `
                    <td>${data.user.nombre}</td>
                    <td>${data.user.email}</td>
                    <td>${data.user.rol}</td>
                    <td>
                        <button class="btn btn-warning btn-edit" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editUserModal" 
                            data-id="${data.user.id}"
                            data-nombre="${data.user.nombre}" 
                            data-email="${data.user.email}"
                            data-rol_id="${data.user.rol_id}">
                            Editar
                        </button>
                        <button class="btn btn-danger btn-delete" data-id="${data.user.id}">Eliminar</button>
                    </td>
                `;
                document.querySelector("tbody").appendChild(newRow);
                document.querySelector("#createUserModal .btn-close").click();
                document.querySelector("#createUserModal form").reset();
            }
        })
        .catch(error => console.error("Error:", error));
    });

    // **Eliminar Usuario con AJAX**
    document.addEventListener("click", function(event) {
        if (event.target.classList.contains("btn-delete")) {
            let userId = event.target.getAttribute("data-id");

            if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
                fetch(`/admin/users/destroy/${userId}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        event.target.closest("tr").remove();
                    }
                })
                .catch(error => console.error("Error:", error));
            }
        }
    });
});

mostrarusers();

function mostrarusers() {
    var resultado = document.getElementById("resultadousuarios");
    var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
    // var form = document.getElementById("formnewuser");
    var formData = new FormData(form);
    // var formData = new FormData();

    fetch("/datosusuarios", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (!response.ok) throw new Error("Error al cargar los datos");
            return response.json();
        })
        .then(data => {
            resultado.innerHTML = ""; // Limpiar contenido anterior
            console.log(data);
            data.restaurantes.data.forEach(usuario => {
                let mostrarusuariosHTML = ""
                mostrarusuariosHTML += '<tr>';
                mostrarusuariosHTML += '<td>' + usuario.nombre + '</td>';
                mostrarusuariosHTML += '<td>' + user.email + '</td>';
                mostrarusuariosHTML += '<td>'+ $user.rol.nombre +'</td>';
                mostrarusuariosHTML += '<td>';
                mostrarusuariosHTML += '<button class="btn btn-warning btn-edit">Editar</button>';
                mostrarusuariosHTML += '<form action="" method="POST" style="display:inline">';
                mostrarusuariosHTML += '@csrf';
                mostrarusuariosHTML += '@method("DELETE")';
                mostrarusuariosHTML += '<button type="submit" class="btn btn-danger">Eliminar</button>';
                mostrarusuariosHTML += '</form>';
                mostrarusuariosHTML += '</td>';
                mostrarusuariosHTML += '</tr>';

                resultado.innerHTML += mostrarusuariosHTML;
            });
        })
        .catch(error => console.error("Hubo un error:", error));
}