<?php
require '../includes/db.php';
session_start();
$time = $_POST['appt'];
$sol = $_POST['fecha'];
$agente = $_SESSION['agente'];
$usuario_id = $_SESSION['agente_id'];


echo "registro su entrada a las: ", $time;
?>
<br>
<?php
$fecha = date("Y-n-j", $sol);


$query_fecha_dia = "select weekday ('$fecha')";
$result_fecha_dia = mysqli_query($conexion, $query_fecha_dia);
while ($row_fecha_dia = mysqli_fetch_array($result_fecha_dia)) {
        $fecha_dia = $row_fecha_dia[0];
}

?>
<br>
<?php

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

$query_docente = "SELECT id from docente where persona_id = '$usuario_id'";
$result_docente = mysqli_query($conexion, $query_docente);
$array = mysqli_fetch_assoc($result_docente);
$docente_id = $array['id'];

$query_jornada_mesa = "SELECT *FROM jornada_docente_mesa WHERE docente_id='$docente_id'";
$result_jornada_mesa = mysqli_query($conexion, $query_jornada_mesa);
while ($row_jornada_mesa = mysqli_fetch_array($result_jornada_mesa)) {
        $mesa = $row_jornada_mesa['mesa_examen_id'];


        $query_mesa_examen = "SELECT *FROM mesa_examen WHERE id='$mesa'";
        $result_mesa_examen = mysqli_query($conexion, $query_mesa_examen);
        while ($row_mesa_examen = mysqli_fetch_array($result_mesa_examen)) {
                $jornada = $row_mesa_examen['jornada_id'];



                $query_fecha = "SELECT *FROM jornada WHERE id='$jornada'";
                $result_fecha = mysqli_query($conexion, $query_fecha);
                $row_fecha = mysqli_fetch_assoc($result_fecha);
                $fecha_inicio = $row_fecha['fecha_inicio'];
                $fecha_fin    = $row_fecha['fecha_fin'];



                if (strtotime($fecha_inicio) < strtotime($fecha) and strtotime($fecha_fin) > strtotime($fecha)) {
                        $query_detalle_jornada = "SELECT *from detalle_jornada WHERE jornada_id = '$jornada' AND dia='$fecha_dia' AND '$time' >= ADDTIME(hora_inicio, '-00:20:00') AND '$time' <= ADDTIME(hora_inicio, '00:30:00')";
                        $result_detalle_jornada = mysqli_query($conexion, $query_detalle_jornada);
                        if (mysqli_num_rows($result_detalle_jornada) == 0) {
                        } else {
                                while ($row_detalle_jornada = mysqli_fetch_array($result_detalle_jornada)) {
                                        $detalle_id = $row_detalle_jornada['id'];
                                        $hora_inicio = $row_detalle_jornada['hora_inicio'];
                                        $hora_fin = $row_detalle_jornada['hora_fin'];
?>
                                        <br>
                                        <?php

                                        $query_exis_marcacion = "SELECT *from marcacion_docente WHERE docente_id='$docente_id' AND fecha = '$fecha' AND hora_registro >= ADDTIME('$time', '-00:20:00') AND hora_registro <= ADDTIME('$time', '00:30:00')";
                                        $result_exis_marcacion = mysqli_query($conexion, $query_exis_marcacion);
                                        if (mysqli_num_rows($result_exis_marcacion) == 0) {

                                                $query_marcacion = "INSERT into marcacion_docente(docente_id, fecha, hora_registro,  dia, estado) VALUES ('$docente_id', now(),'$time',  $fecha_dia, 'entrada')";
                                                $result_marcacion = mysqli_query($conexion, $query_marcacion);

                                                $query_asistencia = "INSERT INTO asistencia_docente(detalle_jornada_id , docente_id , fecha , hora_inicio , hora_fin , dia) VALUES ('$detalle_id' , '$docente_id' , now() , '$hora_inicio' , '$hora_fin' , '$fecha_dia')";
                                                $result_asistencia = mysqli_query($conexion, $query_asistencia);
                                        } else {
                                                echo "Ya realizo esta marcación...";
                                        }
                                }
                        }
                }
        }
}
$last_id = mysqli_insert_id($conexion);


if ($last_id == 0) {

        $query_jornada = "SELECT *FROM jornada_docente WHERE docente_id='$docente_id'";
        $result_jornada = mysqli_query($conexion, $query_jornada);
        while ($row_jornada = mysqli_fetch_array($result_jornada)) {
                $jornada = $row_jornada['jornada_id'];


                $query_fecha = "SELECT *FROM jornada WHERE id='$jornada'";
                $result_fecha = mysqli_query($conexion, $query_fecha);
                $row_fecha = mysqli_fetch_assoc($result_fecha);
                $fecha_inicio = $row_fecha['fecha_inicio'];
                $fecha_fin    = $row_fecha['fecha_fin'];

                if (strtotime($fecha_inicio) < strtotime($fecha) and strtotime($fecha_fin) > strtotime($fecha)) {

                        $query_detalle_jornada = "SELECT *from detalle_jornada WHERE jornada_id = '$jornada' AND dia='$fecha_dia' AND '$time' >= ADDTIME(hora_inicio, '-00:20:00') AND '$time' <= ADDTIME(hora_inicio, '00:30:00')";
                        $result_detalle_jornada = mysqli_query($conexion, $query_detalle_jornada);
                        if (mysqli_num_rows($result_detalle_jornada) == 0) {
                        } else {
                                while ($row_detalle_jornada = mysqli_fetch_array($result_detalle_jornada)) {
                                        $detalle_id = $row_detalle_jornada['id'];
                                        $hora_inicio = $row_detalle_jornada['hora_inicio'];
                                        $hora_fin = $row_detalle_jornada['hora_fin'];
                                        echo $hora_inicio, ' ', $hora_fin;
                                        ?>
                                        <br>
<?php

                                        $query_exis_marcacion = "SELECT *from marcacion_docente WHERE docente_id='$docente_id' AND fecha = '$fecha' AND hora_registro >= ADDTIME('$time', '-00:20:00') AND hora_registro <= ADDTIME('$time', '00:30:00')";
                                        $result_exis_marcacion = mysqli_query($conexion, $query_exis_marcacion);
                                        if (mysqli_num_rows($result_exis_marcacion) == 0) {

                                                $query_marcacion = "INSERT into marcacion_docente(docente_id, fecha, hora_registro,  dia, estado) VALUES ('$docente_id', now(),'$time',  $fecha_dia, 'entrada')";
                                                $result_marcacion = mysqli_query($conexion, $query_marcacion);

                                                $query_asistencia = "INSERT INTO asistencia_docente(detalle_jornada_id , docente_id , fecha , hora_inicio , hora_fin , dia) VALUES ('$detalle_id' , '$docente_id' , now() , '$hora_inicio' , '$hora_fin' , '$fecha_dia')";
                                                $result_asistencia = mysqli_query($conexion, $query_asistencia);
                                        } else {
                                                echo "Ya realizo esta marcación...";
                                        }
                                }
                        }
                }
        }
}
      

/*
if (mysqli_query($conexion, $query2)) {
        $last_id = mysqli_insert_id($conexion);
        echo "New record created successfully. Last inserted ID is: " . $last_id;
        echo "<br>";
        $consulta = mysqli_query($conexion, "SELECT * FROM marcacion_docente where id=$last_id");

        $marcacion_insertada = mysqli_fetch_assoc($consulta);
        $hora_registro = $marcacion_insertada['hora_registro'];

        if ($marcacion_insertada['estado'] == 'entrada'){
                $det_jornada_actual_query = "SELECT detalle_jornada.id as det_jornada_id, detalle_jornada.hora_inicio,detalle_jornada.hora_fin FROM
                jornada inner join detalle_jornada ON jornada.id = detalle_jornada.id_jornada 
                inner join cargo on cargo.id = detalle_jornada.cargo_id WHERE 
                docente_id = $id_docente and
                now() >= fecha_inicio and
                now() <=fecha_fin and
                WEEKDAY(now()) = detalle_jornada.dia AND 
                '$hora_registro' >= ADDTIME(detalle_jornada.hora_inicio, '-00:15:00') AND 
                '$hora_registro' <= ADDTIME(detalle_jornada.hora_inicio, '00:30:00')"; 

                $det_jornada_actual = mysqli_query($conexion,$det_jornada_actual_query);
                $det_jornada_id = mysqli_fetch_assoc($det_jornada_actual)['det_jornada_id'];

                mysqli_query($conexion, "UPDATE marcacion SET detalle_jornada_id=$det_jornada_id WHERE id=$last_id");

                echo "La marcacion es una entrada y se ha actualizado con la id $det_jornada_id";
        }
        else{
                $det_jornada_actual_query = "SELECT detalle_jornada.id as det_jornada_id, detalle_jornada.hora_inicio,detalle_jornada.hora_fin FROM
                jornada inner join detalle_jornada ON jornada.id = detalle_jornada.id_jornada 
                inner join cargo on cargo.id = detalle_jornada.cargo_id WHERE 
                docente_id = $id_docente and 
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
"SELECT * FROM marcaciones where estado='entrada' and docente_id=$id_docente");*/

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