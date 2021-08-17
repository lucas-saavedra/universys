<?php
require '../includes/db.php';
include("../jornada/navbar.php");

$time= $_POST['tiempo'];
$fecha_string= $_POST['fecha'];
$usuario_id = $_SESSION['agente_id'];

$fecha = date("Y-n-j", $fecha_string);

$query_fecha_dia = "select weekday ('$fecha')";
$result_fecha_dia = mysqli_query($conexion,$query_fecha_dia);
while($row_fecha_dia = mysqli_fetch_array($result_fecha_dia)) {
    $fecha_dia= $row_fecha_dia[0];
}


$query_docente = "SELECT id from docente where persona_id = '$usuario_id'";
$result_docente = mysqli_query($conexion, $query_docente);
$array = mysqli_fetch_assoc($result_docente);
$docente_id = $array['id'];

$cont_jornada=0;
$cont_det_jornada=0;

$query_jornada_mesa = "SELECT *FROM jornada_docente_mesa WHERE docente_id='$docente_id'";
$result_jornada_mesa = mysqli_query($conexion,$query_jornada_mesa);
while ($row_jornada_mesa = mysqli_fetch_array($result_jornada_mesa)){
        $mesa = $row_jornada_mesa['mesa_examen_id'];
        
        $query_mesa_examen = "SELECT *FROM mesa_examen WHERE id='$mesa'";
        $result_mesa_examen = mysqli_query($conexion,$query_mesa_examen);
        while ($row_mesa_examen = mysqli_fetch_array($result_mesa_examen)){
                $jornada = $row_mesa_examen['jornada_id'];
                $cont_jornada += 1;
                

                $query_fecha = "SELECT *FROM jornada WHERE id='$jornada'";
                $result_fecha = mysqli_query($conexion,$query_fecha);
                $row_fecha = mysqli_fetch_assoc($result_fecha);
                $fecha_inicio = $row_fecha['fecha_inicio'];
                $fecha_fin    = $row_fecha['fecha_fin'];
                

                if (strtotime($fecha_inicio) < strtotime($fecha) and strtotime($fecha_fin) > strtotime($fecha)){
                        $query_detalle_jornada = "SELECT *from detalle_jornada WHERE jornada_id = '$jornada' AND dia='$fecha_dia' AND '$time' >= ADDTIME(hora_inicio, '-00:20:00') AND '$time' <= ADDTIME(hora_inicio, '00:30:00')";
                        $result_detalle_jornada = mysqli_query($conexion,$query_detalle_jornada);
                        if (mysqli_num_rows($result_detalle_jornada) == 0){
                                $cont_det_jornada += 1;

                             
                        }else{
                                while ($row_detalle_jornada = mysqli_fetch_array($result_detalle_jornada)){
                                        $detalle_id = $row_detalle_jornada['id'];
                                        $hora_inicio = $row_detalle_jornada['hora_inicio'];
                                        $hora_fin = $row_detalle_jornada['hora_fin'];

                                        $query_exis_marcacion = "SELECT *from marcacion_docente WHERE docente_id='$docente_id' AND fecha = '$fecha' AND hora_registro >= ADDTIME('$time', '-00:20:00') AND hora_registro <= ADDTIME('$time', '00:30:00')";
                                        $result_exis_marcacion = mysqli_query($conexion,$query_exis_marcacion);
                                        if (mysqli_num_rows($result_exis_marcacion) == 0){
                                                ?>
                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                        <strong><?php echo "Registro su entrada a las: ",$time; ?></strong>
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                        <?php

                                                $query_marcacion = "INSERT into marcacion_docente(docente_id, fecha, hora_registro,  dia, estado) VALUES ('$docente_id', now(),'$time',  $fecha_dia, 'entrada')";
                                                $result_marcacion = mysqli_query($conexion,$query_marcacion);

                                                $query_asistencia = "INSERT INTO asistencia_docente(detalle_jornada_id , docente_id , fecha , hora_inicio , hora_fin , dia) VALUES ('$detalle_id' , '$docente_id' , now() , '$hora_inicio' , '$hora_fin' , '$fecha_dia')";
                                                $result_asistencia = mysqli_query($conexion,$query_asistencia);


                                        }else{
                                        ?>
                                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                        <strong>Ya realizo esta marcación!</strong>
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                        <?php
                                        }
                                }
                        }
                }
                if ($cont_jornada==$cont_det_jornada){
                        ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>No tiene un horario asignado para esta hora.</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                <?php
                }
        }
}
$last_id = mysqli_insert_id($conexion);
// Sino tiene una marcacion en mesa de examen por que no es fecha de mesa entonces entra para una marcacion de jornada comun 
$cont_jornada=0;
$cont_det_jornada=0;

if ($last_id == 0){

        $query_jornada = "SELECT *FROM jornada_docente WHERE docente_id='$docente_id'";
        $result_jornada = mysqli_query($conexion,$query_jornada);
        while ($row_jornada = mysqli_fetch_array($result_jornada)){
                $jornada = $row_jornada['jornada_id'];
                $cont_jornada += 1;
                

                $query_fecha = "SELECT *FROM jornada WHERE id='$jornada'";
                $result_fecha = mysqli_query($conexion,$query_fecha);
                $row_fecha = mysqli_fetch_assoc($result_fecha);
                $fecha_inicio = $row_fecha['fecha_inicio'];
                $fecha_fin    = $row_fecha['fecha_fin'];
                
                if (strtotime($fecha_inicio) < strtotime($fecha) and strtotime($fecha_fin) > strtotime($fecha)){
                
                        $query_detalle_jornada = "SELECT *from detalle_jornada WHERE jornada_id = '$jornada' AND dia='$fecha_dia' AND '$time' >= ADDTIME(hora_inicio, '-00:20:00') AND '$time' <= ADDTIME(hora_inicio, '00:30:00')";
                        $result_detalle_jornada = mysqli_query($conexion,$query_detalle_jornada);
                        if (mysqli_num_rows($result_detalle_jornada) == 0){
                                $cont_det_jornada += 1;

                        }else{
                                while ($row_detalle_jornada = mysqli_fetch_array($result_detalle_jornada)){
                                        $detalle_id = $row_detalle_jornada['id'];
                                        $hora_inicio = $row_detalle_jornada['hora_inicio'];
                                        $hora_fin = $row_detalle_jornada['hora_fin'];
                                        
                                        $query_exis_marcacion = "SELECT *from marcacion_docente WHERE docente_id='$docente_id' AND fecha = '$fecha' AND hora_registro >= ADDTIME('$time', '-00:20:00') AND hora_registro <= ADDTIME('$time', '00:30:00')";
                                        $result_exis_marcacion = mysqli_query($conexion,$query_exis_marcacion);
                                        if (mysqli_num_rows($result_exis_marcacion) == 0){

                                                ?>
                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                        <strong><?php echo "Registro su entrada a las: ",$time; ?></strong>
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                        <?php

                                                $query_marcacion = "INSERT into marcacion_docente(docente_id, fecha, hora_registro,  dia, estado) VALUES ('$docente_id', now(),'$time',  $fecha_dia, 'entrada')";
                                                $result_marcacion = mysqli_query($conexion,$query_marcacion);

                                                $query_asistencia = "INSERT INTO asistencia_docente(detalle_jornada_id , docente_id , fecha , hora_inicio , hora_fin , dia) VALUES ('$detalle_id' , '$docente_id' , now() , '$hora_inicio' , '$hora_fin' , '$fecha_dia')";
                                                $result_asistencia = mysqli_query($conexion,$query_asistencia);

                                        }else{
                                               ?>
                                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                        <strong>Ya realizo esta marcación!</strong>
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                        <?php
                                        }
                }
                                }
                        }
                }
                if ($cont_jornada==$cont_det_jornada){
                        ?>
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>No tiene un horario asignado para esta hora.</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                        <?php
                }
        }
 include("../includes/footer.php");