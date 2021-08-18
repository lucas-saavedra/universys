<?php
require '../includes/db.php';
session_start();
$time = $_POST['appt'];
$sol = $_POST['fecha'];
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

$query_no_docente = "SELECT id from no_docente where persona_id = '$usuario_id'";
$result_no_docente = mysqli_query($conexion, $query_no_docente);
$array = mysqli_fetch_assoc($result_no_docente);
$no_docente_id = $array['id'];

$query_jornada_no_docente = "SELECT *FROM jornada_no_docente WHERE no_docente_id='$no_docente_id'";
$result_jornada_no_docente = mysqli_query($conexion, $query_jornada_no_docente);
while ($row_jornada_no_docente = mysqli_fetch_array($result_jornada_no_docente)) {
        $jornada = $row_jornada_no_docente['jornada_id'];

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

                                $query_exis_marcacion = "SELECT *from marcacion_no_docente WHERE no_docente_id='$no_docente_id' AND fecha = '$fecha' AND hora_registro >= ADDTIME('$time', '-00:20:00') AND hora_registro <= ADDTIME('$time', '00:30:00')";
                                $result_exis_marcacion = mysqli_query($conexion, $query_exis_marcacion);
                                if (mysqli_num_rows($result_exis_marcacion) == 0) {

                                        $query_marcacion = "INSERT into marcacion_no_docente(no_docente_id, fecha, hora_registro,  dia, estado) VALUES ('$no_docente_id', now(),'$time',  $fecha_dia, 'entrada')";
                                        $result_marcacion = mysqli_query($conexion, $query_marcacion);

                                        $query_asistencia = "INSERT INTO asistencia_no_docente(detalle_jornada_id , no_docente_id , fecha , hora_inicio , hora_fin , dia) VALUES ('$detalle_id' , '$no_docente_id' , now() , '$hora_inicio' , '$hora_fin' , '$fecha_dia')";
                                        $result_asistencia = mysqli_query($conexion, $query_asistencia);
                                } else {
                                        echo "Ya realizo esta marcación...";
                                }
                        }
                }
        }
}
?>