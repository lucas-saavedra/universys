<?php 
require('database.php');

$query = "SELECT * from marcacion where estado='entrada'";
$consulta = mysqli_query($conexion, $query);



while ($entradas = mysqli_fetch_assoc($consulta)){
    echo'<br>';
    print_r($entradas);

    $hora_registro = $entradas['hora_registro'];
    $docente_id = $entradas['docente_id'];

    $query2 = "INSERT INTO asistencias(hora_inicio, docente_id) values ($hora_registro, $docente_id)";

    $insert = mysqli_query($conexion,$query2);
}

$query = "SELECT * FROM marcacion where estado='salida'";
$consulta = mysqli_query($conexion, $query);
echo '****************************************';
while ($salidas = mysqli_fetch_assoc($consulta)){
    echo'<br>';
    print_r($salidas);
}