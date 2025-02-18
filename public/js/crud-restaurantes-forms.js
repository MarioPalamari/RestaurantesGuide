document.addEventListener("DOMContentLoaded", function () {
    // Obtener los elementos del formulario CREAR
    const nombre = document.getElementById("nombre");
    const descripcion = document.getElementById("descripcion");
    const precioMedio = document.getElementById("precio_medio");
    const lugar = document.getElementById("lugar");
    const horario = document.getElementById("horario");
    const contacto = document.getElementById("contacto");
    const web = document.getElementById("web");
    const formCrear = document.getElementById("formCrearRestaurante");
    const btnCrear = document.getElementById("btnCrearRestaurante");

    // Obtener los elementos del formulario EDITAR
    const editNombre = document.getElementById("editNombre");
    const editDescripcion = document.getElementById("editDescripcion");
    const editPrecioMedio = document.getElementById("editPrecioMedio");
    const editLugar = document.getElementById("editLugar");
    const editHorario = document.getElementById("editHorario");
    const editContacto = document.getElementById("editContacto");
    const editWeb = document.getElementById("editWeb");
    const formEditar = document.getElementById("formEditarRestaurante");
    const btnEditar = document.getElementById("btnEditarRestaurante");

    function mostrarError(id, mensaje) {
        const errorSpan = document.getElementById(id);
        errorSpan.textContent = mensaje;
    }

    function limpiarError(id) {
        const errorSpan = document.getElementById(id);
        errorSpan.textContent = "";
    }

    function validarCampoTexto(input, idError, mensajeVacio, minLength = 3) {
        const value = input.value.trim();
        if (value === "") {
            mostrarError(idError, mensajeVacio);
            input.style.borderColor = "red";
            return false;
        } else if (value.length < minLength) {
            mostrarError(idError, `Debe tener al menos ${minLength} caracteres`);
            input.style.borderColor = "red";
            return false;
        } else {
            limpiarError(idError);
            input.style.borderColor = "";
            return true;
        }
    }

    function validarNumero(input, idError, mensajeVacio, min = 0) {
        const value = input.value.trim();
        if (value === "") {
            mostrarError(idError, mensajeVacio);
            input.style.borderColor = "red";
            return false;
        } else if (parseFloat(value) < min) {
            mostrarError(idError, `Debe ser un número válido mayor o igual a ${min}`);
            input.style.borderColor = "red";
            return false;
        } else {
            limpiarError(idError);
            input.style.borderColor = "";
            return true;
        }
    }

    function validarURL(input, idError) {
        const value = input.value.trim();
        const regex = /^(https?:\/\/)?([\w\d-]+\.)+[\w]{2,}(:\d+)?(\/.*)?$/;
        if (value !== "" && !regex.test(value)) {
            mostrarError(idError, "Debe ser una URL válida");
            input.style.borderColor = "red";
            return false;
        } else {
            limpiarError(idError);
            input.style.borderColor = "";
            return true;
        }
    }

    function validarFormularioCrear() {
        return (
            validarCampoTexto(nombre, "nombreError", "El nombre no puede estar vacío") &&
            validarCampoTexto(descripcion, "descripcionError", "La descripción no puede estar vacía", 10) &&
            validarNumero(precioMedio, "precioMedioError", "El precio medio no puede estar vacío", 1) &&
            validarCampoTexto(lugar, "lugarError", "La ubicación no puede estar vacía") &&
            validarCampoTexto(horario, "horarioError", "El horario no puede estar vacío") &&
            validarCampoTexto(contacto, "contactoError", "El contacto no puede estar vacío") &&
            validarURL(web, "webError")
        );
    }

    function validarFormularioEditar() {
        return (
            validarCampoTexto(editNombre, "editNombreError", "El nombre no puede estar vacío") &&
            validarCampoTexto(editDescripcion, "editDescripcionError", "La descripción no puede estar vacía", 10) &&
            validarNumero(editPrecioMedio, "editPrecioMedioError", "El precio medio no puede estar vacío", 1) &&
            validarCampoTexto(editLugar, "editLugarError", "La ubicación no puede estar vacía") &&
            validarCampoTexto(editHorario, "editHorarioError", "El horario no puede estar vacío") &&
            validarCampoTexto(editContacto, "editContactoError", "El contacto no puede estar vacío") &&
            validarURL(editWeb, "editWebError")
        );
    }

    function actualizarEstadoBotonCrear() {
        btnCrear.disabled = !validarFormularioCrear();
    }

    function actualizarEstadoBotonEditar() {
        btnEditar.disabled = !validarFormularioEditar();
    }

    // Eventos "onblur" individuales para validaciones en tiempo real - CREAR
    nombre.addEventListener("blur", () => { validarCampoTexto(nombre, "nombreError", "El nombre no puede estar vacío"); actualizarEstadoBotonCrear(); });
    descripcion.addEventListener("blur", () => { validarCampoTexto(descripcion, "descripcionError", "La descripción no puede estar vacía", 10); actualizarEstadoBotonCrear(); });
    precioMedio.addEventListener("blur", () => { validarNumero(precioMedio, "precioMedioError", "El precio medio no puede estar vacío", 1); actualizarEstadoBotonCrear(); });
    lugar.addEventListener("blur", () => { validarCampoTexto(lugar, "lugarError", "La ubicación no puede estar vacía"); actualizarEstadoBotonCrear(); });
    horario.addEventListener("blur", () => { validarCampoTexto(horario, "horarioError", "El horario no puede estar vacío"); actualizarEstadoBotonCrear(); });
    contacto.addEventListener("blur", () => { validarCampoTexto(contacto, "contactoError", "El contacto no puede estar vacío"); actualizarEstadoBotonCrear(); });
    web.addEventListener("blur", () => { validarURL(web, "webError"); actualizarEstadoBotonCrear(); });

    // Eventos "onblur" individuales para validaciones en tiempo real - EDITAR
    editNombre.addEventListener("blur", () => { validarCampoTexto(editNombre, "editNombreError", "El nombre no puede estar vacío"); actualizarEstadoBotonEditar(); });
    editDescripcion.addEventListener("blur", () => { validarCampoTexto(editDescripcion, "editDescripcionError", "La descripción no puede estar vacía", 10); actualizarEstadoBotonEditar(); });
    editPrecioMedio.addEventListener("blur", () => { validarNumero(editPrecioMedio, "editPrecioMedioError", "El precio medio no puede estar vacío", 1); actualizarEstadoBotonEditar(); });
    editLugar.addEventListener("blur", () => { validarCampoTexto(editLugar, "editLugarError", "La ubicación no puede estar vacía"); actualizarEstadoBotonEditar(); });
    editHorario.addEventListener("blur", () => { validarCampoTexto(editHorario, "editHorarioError", "El horario no puede estar vacío"); actualizarEstadoBotonEditar(); });
    editContacto.addEventListener("blur", () => { validarCampoTexto(editContacto, "editContactoError", "El contacto no puede estar vacío"); actualizarEstadoBotonEditar(); });
    editWeb.addEventListener("blur", () => { validarURL(editWeb, "editWebError"); actualizarEstadoBotonEditar(); });
    document.querySelectorAll(".btn-close").forEach(button => {
        button.addEventListener("click", function () {
            limpiarErroresFormulario(formCrear, btnCrear);
            limpiarErroresFormulario(formEditar, btnEditar);
        });
    });
    function limpiarErroresFormulario(form, boton) {
        boton.disabled = false;
        if (!form) return;
    
        // Limpiar todos los mensajes de error
        form.querySelectorAll("span[id$='Error']").forEach(span => {
            span.textContent = "";
        });
    
        // Restaurar estilos de los inputs y textareas
        form.querySelectorAll("input, textarea").forEach(input => {
            input.style.borderColor = "";
        });
    
        // Deshabilitar el botón hasta que se ingrese nueva información
        if (boton) {
            boton.disabled = true;
        }
    }
    
});
