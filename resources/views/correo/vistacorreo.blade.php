<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{-- FUENTE --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
</head>

<body>
    <h1 style="color: #e4a60e">Saborea Madrid</h1>
    <p>Hola <b><span style="background-color: #e4a60e">{{ ucfirst($gerente) }}</span></b>
        le informamos que hemos modificado los siguientes datos:</p>
    <p><b>Nombre</b>: <span style="background-color: #e4a60e">{{ $nombre }}</span></p>
    <p><b>Descripcion</b>: <span style="background-color: #e4a60e">{{ $descripcion }}</span></p>
    <p><b>Precio medio</b>: <span style="background-color: #e4a60e">{{ $precio_medio }}€</span></p>
    <p><b>lugar</b>: <span style="background-color: #e4a60e">{{ $lugar }}</span></p>
    <p><b>Horario</b>: <span style="background-color: #e4a60e">{{ $horario }}</span></p>
    <p><b>Contacto</b>: <span style="background-color: #e4a60e">{{ $contacto }}</span></p>
    <p><b>Web</b>: <span style="background-color: #e4a60e">{{ $web }}</span></p>
</body>

</html>
