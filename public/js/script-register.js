document.getElementById('loginLink').addEventListener('click', function(event) {
    event.preventDefault();  // Prevenir la acción predeterminada del enlace
    // Mostrar SweetAlert2
    Swal.fire({
        title: "¿Para ver más, tienes que iniciar sesión?",
        showDenyButton: true,
        confirmButtonText: "Iniciar sesión",
        denyButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirigir al login si el usuario confirma
            window.location.href = "/login";
        } else if (result.isDenied) {
            // Informar si no se guarda nada
        }
    });
});