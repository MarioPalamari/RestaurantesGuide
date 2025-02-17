const modal = document.getElementById("modalValoracion");
const btnAbrir = document.getElementById("abrirModal");
const btnCerrar = document.querySelector(".close");

btnAbrir.addEventListener("click", function (event) {
    event.preventDefault();
    modal.style.display = "flex";
});

btnCerrar.addEventListener("click", function () {
    modal.style.display = "none";
});

function opinarform() {
    var form = document.getElementById("frmopinar");
    var formData = new FormData(form);
    fetch("/opinar", {
        method: "POST",
        body: formData
    }).then(response => {
        if (!response.ok) throw new Error("Error al cargar los datos");
        return response.text();
    })
        .then(data => {
            form.reset()
            modal.style.display = "none";
            mostrarinforestaurante();
        })
}

mostrarinforestaurante();

function mostrarinforestaurante() {
    var form = document.getElementById("frmopinar");
    var formData = new FormData(form);
    fetch("/mostrarinforestaurante", {
        method: "POST",
        body: formData
    }).then(response => {
        if (!response.ok) throw new Error("Error al cargar los datos");
        return response.json();
    })
        .then(data => {
            console.log(data.restaurante);
            console.log(data.valoraciones);

            // Restaurante data
            const restaurante = data.restaurante[0]; // Solo asumimos un restaurante
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

            // Opiniones
            const opinionesContainer = document.getElementById('opiniones');
            opinionesContainer.innerHTML = ''; // Limpiar opiniones previas
            data.valoraciones.forEach(val => {
                const opinionElement = document.createElement('div');
                opinionElement.classList.add('opinion');
                opinionElement.innerHTML = `
                <h3>${val.nombre} - <span class="stars">${'⭐'.repeat(val.valoracion)}</span></h3>
                <p class="fecha">${new Date(val.created_at).toLocaleDateString()}</p>
                <p>${val.comentario}</p>
            `;
                opinionesContainer.appendChild(opinionElement);
            });
        })
}