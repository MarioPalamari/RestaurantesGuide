<head>
    <meta charset="UTF-8">
    <title>Administrar Restaurantes</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Administrar Restaurantes</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio Medio</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="listaRestaurantes"></tbody>
    </table>

    <h3>Nuevo Restaurante</h3>
    <form id="formRestaurante" method="POST" enctype="multipart/form-data">
    <input type="text" id="nombre" name="nombre" placeholder="Nombre del restaurante" required>
    <input type="text" id="descripcion" name="descripcion" placeholder="Descripción">
    <input type="number" id="precio_medio" name="precio_medio" placeholder="Precio medio">
    <input type="file" id="img" name="img">
    <button type="submit">Crear Restaurante</button>
    </form>






    <script  src="{{ asset('js/crud-restaurantes.js') }}">
</script>
</body>
</html>
