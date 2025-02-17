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

    // **Actualizar Usuario con AJAX**
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
                return response.text().then(text => {
                    throw new Error(text);
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                mostrarusers();
                document.querySelector("#editUserModal .btn-close").click();
            } else {
                alert(data.message || "Hubo un error al actualizar el usuario");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Hubo un error en la solicitud. Ver la consola para más detalles.");
        });
    });

    // **Crear Usuario con AJAX**
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
                return response.text().then(text => {
                    throw new Error(text);
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                mostrarusers();
                document.querySelector("#createUserModal .btn-close").click();
                this.reset();
            } else {
                alert(data.message || "Hubo un error al crear el usuario");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Hubo un error en la solicitud. Ver la consola para más detalles.");
        });
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
        resultado.innerHTML = ""; // Limpiar contenido anterior
        data.usuarios.forEach(usuario => {
            let mostrarusuariosHTML = `
                <tr>
                    <td>${usuario.nombre}</td>
                    <td>${usuario.email}</td>
                    <td>${usuario.rol.nombre}</td>
                    <td>
                        <button class="btn btn-warning btn-edit" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editUserModal" 
                            data-id="${usuario.id}"
                            data-nombre="${usuario.nombre}" 
                            data-email="${usuario.email}"
                            data-rol_id="${usuario.rol_id}">
                            Editar
                        </button>
                        <button class="btn btn-danger btn-delete" data-id="${usuario.id}">Eliminar</button>
                    </td>
                </tr>`;
            resultado.innerHTML += mostrarusuariosHTML;
        });
    })
    .catch(error => console.error("Hubo un error:", error));
}

document.getElementById('createUserModal').addEventListener('show.bs.modal', function() {
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