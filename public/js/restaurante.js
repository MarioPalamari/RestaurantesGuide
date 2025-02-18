mostrarinforestaurante();

function mostrarinforestaurante() {
    var form = document.getElementById("frmopinar");
    var formData = new FormData(form);
    fetch("/mostrarinforestaurante", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        if (response.status === 401) {
            window.location.href = '/login';
            return;
        }
        if (!response.ok) throw new Error("Error al cargar los datos");
        return response.json();
    })
    .then(data => {
        if (data.error) {
            throw new Error(data.error);
        }
        const restaurante = data.restaurante[0];
        document.getElementById('restauranteNombre').textContent = restaurante.nombre;
        document.getElementById('bienvenidaRestaurante').textContent = `Bienvenido a ${restaurante.nombre}`;
        document.getElementById('nombreRestaurante').textContent = restaurante.nombre;
        document.getElementById('descripcionRestaurante').innerHTML = restaurante.descripcion;
        document.getElementById('imgRestaurante').src = '/img/' + restaurante.img;
        document.getElementById('mediaValoracion').textContent = restaurante.media_valoracion;
        document.getElementById('totalValoraciones').textContent = restaurante.total_valoracion;
        document.getElementById('direccionRestaurante').textContent = `📍 ${restaurante.lugar}`;
        document.getElementById('extraInfoRestaurante').textContent = `➕ ${restaurante.horario ?? '--'}`;
        document.getElementById('telefonoRestaurante').textContent = `📞 ${restaurante.contacto}`;
        document.getElementById('webRestaurante').textContent = restaurante.web;
        document.getElementById('webRestaurante').href = restaurante.web;


        const mostrarredsocial = document.getElementById('mostrarredsocial');
        mostrarredsocial.textContent = '';
        data.redsocial.forEach(red => {
            let contenidored = ''
            // contenidored += '<p>'
            contenidored += '<a style="margin: 4px" href="' + red.url + '"><img style="border-radius:10px; width="1000"; height="40"" src="/img/redes/' + red.platforma + '.png" alt="' + red.platforma + '" style="width:42px;height:42px;">'
            // contenidored += '</p>'
            mostrarredsocial.innerHTML += contenidored;
        })

        // Opiniones
        const opinionesContainer = document.getElementById('opiniones');
        opinionesContainer.innerHTML = '';
        data.valoraciones.forEach(val => {
            let contenido = ''
            contenido += '<div class="opinion">'
            contenido += '<h3>' + val.nombre + ' - <span class="stars">' + "⭐".repeat(val.valoracion) + '</span></h3>'
            contenido += '<p class="fecha">' + new Date(val.created_at).toLocaleDateString() + '</p>'
            contenido += '<p class="texto-opinion">' + val.comentario + '</p>'

            if (val.id_usuarios == data.id) {
                contenido += '<div class="form-opinar">'
                contenido += '<form id="editaropinar' + val.id + '" method="post" onsubmit="event.preventDefault(); editaropinar(this);">';
                contenido += '    <input type="hidden" name="id" value="' + val.id + '">';
                contenido += '<button>Editar</button>'

                contenido += '</form>';
                contenido += '<form id="eliminaropinion' + val.id + '" method="post" onsubmit="event.preventDefault(); eliminaropinion(this);">';
                contenido += '    <input type="hidden" name="id" value="' + val.id + '">';
                contenido += '<button>Eliminar</button>'
                contenido += '</form>';
                contenido += '</div>'
            }
            contenido += '<div>'
            opinionesContainer.innerHTML += contenido;
        });
    })
    .catch(error => {
        console.error('Error:', error);
        if (error.message === 'Usuario no autenticado') {
            window.location.href = '/login';
        } else {
            alert('Error al cargar los datos del restaurante');
        }
    });
}
const modal = document.getElementById("modalValoracion");
const btnAbrir = document.getElementById("abrirModal");
const btnCerrar = document.querySelector(".close");

btnAbrir.addEventListener("click", function (event) {
    event.preventDefault();
    modal.style.display = "flex";
    inputIdOpinar.value = "";
});

btnCerrar.addEventListener("click", function () {
    modal.style.display = "none";
    formOpinar.reset();
    inputIdOpinar.value = "";
});

function opinarform() {
    var form = document.getElementById("frmopinar");
    var formData = new FormData(form);
    fetch("/opinar", {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        if (response.status === 401) {
            window.location.href = '/login';
            return;
        }
        if (!response.ok) throw new Error("Error al enviar la opinión");
        return response.text();
    })
    .then(data => {
        form.reset();
        modal.style.display = "none";
        mostrarinforestaurante();
    })
    .catch(error => {
        console.error('Error:', error);
        if (error.message === 'Usuario no autenticado') {
            window.location.href = '/login';
        } else {
            alert('Error al enviar la opinión');
        }
    });
}

function eliminaropinion(form) {
    // var form = document.getElementById("eliminaropinion");
    var formdata = new FormData(form);
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    formdata.append('_token', csrfToken);
    fetch("/eliminaropinion", {
        method: "POST",
        body: formdata
    }).then(response => {
        if (!response.ok) throw new Error("Error al cargar los datos");
        return response.text();
    })
        .then(data => {
            mostrarinforestaurante();
        })
}

function editaropinar(form) {
    // var form = document.getElementById("eliminaropinion");
    var formdata = new FormData(form);
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    formdata.append('_token', csrfToken);
    fetch("/editaropinar", {
        method: "POST",
        body: formdata
    }).then(response => {
        if (!response.ok) throw new Error("Error al cargar los datos");
        return response.json();
    })
        .then(data => {
            console.log(data)
            modal.style.display = "flex";
            inputIdOpinar.value = data.id;
            document.getElementById("inputComentario").value = data.comentario;
            let valoracionRedondeada = Math.round(data.valoracion);
            document.getElementById(`estrella${valoracionRedondeada}`).checked = true;
        })
}