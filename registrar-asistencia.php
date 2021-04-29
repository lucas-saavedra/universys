<?php
require 'database.php';
session_start();

$usuario_id = $_SESSION['usuario_id'];

// $det_jornada_actual = "SELECT detalle_jornada.id as det_jornada_id, detalle_jornada.hora_inicio,detalle_jornada.hora_fin FROM
// jornada inner join detalle_jornada ON jornada.id = detalle_jornada.id_jornada WHERE 
// now() >= fecha_inicio and
// now() <=fecha_fin and
// WEEKDAY(now()) = detalle_jornada.dia AND 
// '10:00:00' >= ADDTIME(detalle_jornada.hora_inicio, '-00:15:00') AND 
// '10:00:00' <= ADDTIME(detalle_jornada.hora_inicio, '00:15:00')";

// $consulta = mysqli_query($conexion, $det_jornada_actual);
// if (mysqli_num_rows($consulta) == 0){
//         echo 'Actualmente no tiene horarios asignados';
//         exit();
// }

// $array = mysqli_fetch_assoc($consulta);
// $det_jornada_id = $array['det_jornada_id'];

$query = "select docentes.id from docentes, usuarios where usuario_id = '$usuario_id'";
$consulta = mysqli_query($conexion, $query);
$array = mysqli_fetch_assoc($consulta);
$id_docente = $array['id'];


$query2 = "INSERT into marcacion(fecha, hora_registro, docente_id, dia_id, estado) VALUES (now(),
 '11:10:00', '$id_docente', WEEKDAY(now()), 'entrada')";


if (mysqli_query($conexion, $query2)) {
        $last_id = mysqli_insert_id($conexion);
        echo "New record created successfully. Last inserted ID is: " . $last_id;
        echo "<br>";
        $consulta = mysqli_query($conexion, "SELECT * FROM marcacion where id=$last_id");

        $marcacion_insertada = mysqli_fetch_assoc($consulta);
        $hora_registro = $marcacion_insertada['hora_registro'];

        if ($marcacion_insertada['estado'] == 'entrada'){
                $det_jornada_actual_query = "SELECT detalle_jornada.id as det_jornada_id, detalle_jornada.hora_inicio,detalle_jornada.hora_fin FROM
                jornada inner join detalle_jornada ON jornada.id = detalle_jornada.id_jornada WHERE 
                now() >= fecha_inicio and
                now() <=fecha_fin and
                WEEKDAY(now()) = detalle_jornada.dia AND 
                '$hora_registro' >= ADDTIME(detalle_jornada.hora_inicio, '-00:15:00') AND 
                '$hora_registro' <= ADDTIME(detalle_jornada.hora_inicio, '00:15:00')"; 

                $det_jornada_actual = mysqli_query($conexion,$det_jornada_actual_query);
                $det_jornada_id = mysqli_fetch_assoc($det_jornada_actual)['det_jornada_id'];

                mysqli_query($conexion, "UPDATE marcacion SET detalle_jornada_id=$det_jornada_id WHERE id=$last_id");

                echo "La marcacion es una entrada y se ha actualizado con la id $det_jornada_id";
        }
        else{
                $det_jornada_actual_query = "SELECT detalle_jornada.id as det_jornada_id, detalle_jornada.hora_inicio,detalle_jornada.hora_fin FROM
                jornada inner join detalle_jornada ON jornada.id = detalle_jornada.id_jornada WHERE 
                now() >= fecha_inicio and
                now() <=fecha_fin and
                WEEKDAY(now()) = detalle_jornada.dia AND 
                '$hora_registro' >= ADDTIME(detalle_jornada.hora_fin, '-00:15:00') AND 
                '$hora_registro' <= ADDTIME(detalle_jornada.hora_fin, '00:15:00')"; 

                $det_jornada_actual = mysqli_query($conexion,$det_jornada_actual_query);
                $det_jornada_id = mysqli_fetch_assoc($det_jornada_actual)['det_jornada_id'];

                mysqli_query($conexion, "UPDATE marcacion SET detalle_jornada_id=$det_jornada_id WHERE id=$last_id");

                echo "La marcacion es una salida y se ha actualizado con la id $det_jornada_id";
        }

} else {
        echo "Error: " . $query2 . "<br>" . mysqli_error($conexion);
}

$marcaciones_entrada = mysqli_query($conexion, 
"SELECT * FROM marcaciones where estado='entrada' and docente_id=$id_docente");

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