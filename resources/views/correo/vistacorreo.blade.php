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
    <h1>Saborea Madrid</h1>
    <p>Hola {{ $gerente }} le informamos que hemos modificado los siguientes datos:</p>
    <p>Nombre: {{ $nombre }}</p>
    <p>Descripcion: {{ $descripcion }}</p>
    <p>Precio medio: {{ $precio_medio }}</p>
    <p>lugar: {{ $lugar }}</p>
    <p>Horario: {{ $horario }}</p>
    <p>Contacto: {{ $contacto }}</p>
    <p>Web: {{ $web }}</p>
    <p>img</p>
    <img src="{{ asset('img/parrilla.jpg') }}" alt="">
</body>

</html>
