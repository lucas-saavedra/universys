<?php 
require('../includes/db.php');

$query_marcaciones = "select m1.hora_registro as hora_inicio, m2.hora_registro as hora_fin, 
m2.docente_id, m2.detalle_jornada_id, m1.fecha, m1.dia_id from 
(select * from marcacion where estado ='entrada') as m1 inner join (select * from marcacion where estado ='salida')
 as m2 on m1.fecha=m2.fecha and m1.docente_id=m2.docente_id and m1.detalle_jornada_id = m2.detalle_jornada_id";

$consulta = mysqli_query($conexion, $query_marcaciones);


while ($asistencia = mysqli_fetch_assoc($consulta)){

    echo'<br>';
    print_r($asistencia);

    $hora_inicio = $asistencia['hora_inicio'];
    $hora_fin = $asistencia['hora_fin'];
    $docente_id = $asistencia['docente_id'];
    $fecha = $asistencia['fecha'];
    $dia_id=$asistencia['dia_id'];
    $det_jornada_id=$asistencia['detalle_jornada_id'];

    $query2 = "INSERT INTO asistencias(hora_inicio, hora_fin, docente_id, fecha, dia_id, det_jornada_id) 
    values ('$hora_inicio', '$hora_fin', $docente_id, '$fecha', $dia_id, $det_jornada_id)";

    $insert = mysqli_query($conexion,$query2);
}