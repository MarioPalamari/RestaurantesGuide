mostrarrestaurantes();

function mostrarrestaurantes() {
    var resultado = document.getElementById("restaurantes");
    var csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
    var form = document.getElementById("formnewuser");
    var formData = new FormData(form);
    fetch("/mostrarrestaurantes", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (!response.ok) throw new Error("Error al cargar los datos");
            return response.json();
        })
        .then(data => {
            resultado.innerHTML = ""; // Limpiar contenido anterior
            console.log(resultado);
            data.restaurantes.data.forEach(restaurante => {
                let restauranteHTML = ""
                restauranteHTML += '<div class="restaurante">';
                restauranteHTML += '    <div class="img-container">';
                restauranteHTML += '        <img src="/img/' + restaurante.img + '" alt="' + restaurante.nombre + '" class="img-restaurante">';
                restauranteHTML += '        <div class="nombre-restaurante">';
                restauranteHTML += '            <h3>' + restaurante.nombre + '</h3 > ';
                restauranteHTML += '        </div>';
                restauranteHTML += '</div>';
                restauranteHTML += '    <form action="/restaurantes/' + restaurante.nombre.replace(/\s+/g, '-') + ' " method="post" class="form-restaurante">';
                restauranteHTML += '        <input type="hidden" name="_token" value="' + csrfToken + '">';
                restauranteHTML += '        <input type="hidden" name="id_restaurante" value="' + restaurante.id + '">';
                restauranteHTML += '        <button type="submit" class="btn-restaurante">';
                restauranteHTML += '            <div class="detalle-restaurante">';
                restauranteHTML += '                <p>' + restaurante.descripcion + '</p>';
                restauranteHTML += '                <p>Valoración: ' + (restaurante.media_valoracion == 0 ? '-- ✰' : restaurante.media_valoracion + ' ★') + '</p>';
                restauranteHTML += '                <p>Precio medio: ' + restaurante.precio_medio + '€</p>';
                restauranteHTML += '                <p>' + restaurante.etiquetas || "Sin etiquetas" + '</p > ';
                restauranteHTML += '            </div>';
                restauranteHTML += '        </button>';
                restauranteHTML += '    </form>';
                restauranteHTML += '</div>';

                resultado.innerHTML += restauranteHTML;
            });
        })
}


function borrarfiltros() {
    document.getElementById("formnewuser").reset();
    mostrarrestaurantes();
}