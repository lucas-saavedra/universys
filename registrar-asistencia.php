<?php
require 'database.php';
session_start();

$usuario_id = $_SESSION['usuario_id'];

$det_jornada = "SELECT detalle_jornada.id as det_jornada_id, detalle_jornada.hora_inicio,detalle_jornada.hora_fin FROM
jornada inner join detalle_jornada ON jornada.id = detalle_jornada.id_jornada WHERE 
now() >= fecha_inicio and
now() <=fecha_fin and
WEEKDAY(now()) = detalle_jornada.dia";
$consulta = mysqli_query($conexion, $det_jornada);
$array = mysqli_fetch_assoc($consulta);
$det_jornada_id = $array['det_jornada_id'];

$query = "select docentes.id from docentes, usuarios where usuario_id = '$usuario_id'";
$consulta = mysqli_query($conexion, $query);
$array = mysqli_fetch_assoc($consulta);
$id_docente = $array['id'];


$query2 = "INSERT into marcacion(fecha,hora_registro,docente_id, dia_id,detalle_jornada_id, estado) VALUES (now(),
 CURRENT_TIME(), '$id_docente', WEEKDAY(now()), $det_jornada_id, 'entrada')";

if (mysqli_query($conexion, $query2)) {
        $last_id = mysqli_insert_id($conexion);
        echo "New record created successfully. Last inserted ID is: " . $last_id;
} else {
        echo "Error: " . $query2 . "<br>" . mysqli_error($conexion);
}

/* $q= 'SELECT TIMEDIFF(marcacion.hora_inicio,detalle_jornada.hora_fin) as cont FROM marcacion,detalle_jornada';
$consulta = mysqli_query($conexion,$q);
$con = mysqli_query($conexion,$q);
while ($row = mysqli_fetch_assoc($consulta)) {
  
        echo "Row1";
        echo $row['cont'];
        echo "<br>"; */
/*     
} */






// $q = "select id from docentes where usuario_id = '$usuario_id'";

// $consulta = mysqli_query($conexion,$q);
// $array = mysqli_fetch_assoc($consulta);

// $q = "INSERT into marcacion(fecha,hora_inicio,hola_fin,docente_id) VALUES ('2021-04-20', '10:15:00', '10:30:00', 3)"

// if(mysqli_num_rows($consulta) > 0){
//     $_SESSION['username']= $usuario;
//     $_SESSION['usuario_id']= $array['id'];
//     header("location: index.php");
// }else{
//     echo 'Datos incorrectos';
// }