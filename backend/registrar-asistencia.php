<?php
require '../includes/db.php';
include("../jornada/navbar.php");

$Object = new DateTime();
$time  = $Object->format("H:i:s");
$fecha = date("Y-n-j");

$usuario_id = $_SESSION['agente_id'];
$query_fecha_dia = "select weekday ('$fecha')";
$result_fecha_dia = mysqli_query($conexion, $query_fecha_dia);
while ($row_fecha_dia = mysqli_fetch_array($result_fecha_dia)) {
        $fecha_dia = $row_fecha_dia[0];
}
$marc_bol=false;
$sin_det_jornada=true;
$tiene_mesa=false;

$query_docente = "SELECT id from docente where persona_id = '$usuario_id'";
$result_docente = mysqli_query($conexion, $query_docente);
$array = mysqli_fetch_assoc($result_docente);
$docente_id = $array['id'];


$query_jornada_mesa = "SELECT *FROM jornada_docente_mesa WHERE docente_id='$docente_id'";
$result_jornada_mesa = mysqli_query($conexion, $query_jornada_mesa);
while ($row_jornada_mesa = mysqli_fetch_array($result_jornada_mesa)) {
        $mesa = $row_jornada_mesa['mesa_examen_id'];
        $marc_bol=true;

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
                                $tiene_mesa = true;
                                $sin_det_jornada = false;
                                while ($row_detalle_jornada = mysqli_fetch_array($result_detalle_jornada)) {
                                        $detalle_id = $row_detalle_jornada['id'];
                                        $hora_inicio = $row_detalle_jornada['hora_inicio'];
                                        $hora_fin = $row_detalle_jornada['hora_fin'];

                                        $query_exis_marcacion = "SELECT *from marcacion_docente WHERE docente_id='$docente_id' AND fecha = '$fecha' AND hora_registro >= ADDTIME('$time', '-00:20:00') AND hora_registro <= ADDTIME('$time', '00:30:00')";
                                        $result_exis_marcacion = mysqli_query($conexion, $query_exis_marcacion);
                                        if (mysqli_num_rows($result_exis_marcacion) == 0) {                                              
                                        ?>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong><?php echo "registro su entrada a las: ",$time; ?></strong>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                </button>
                                        </div>
                                        <div class="row alert alert-secondary alert-dismissible fade show">
                                                <div class="col text-center">
                                                        <h4>??Cerrar sesi??n?</h4>
                                                        <a style =" width: 100px" type="button" class="btn btn-success text-center text-white" 
                                                        href="../includes/logout.php"><strong>Si<strong>
                                                        </a>
                                                        <a style =" width: 100px" type="button" class="btn btn-primary text-center text-white"
                                                                 href="/universys/jornada"><strong>No</strong>
                                                        </a>        
                                                                        
                                                </div>         
                                        </div>
                                        <?php

                                                $query_marcacion = "INSERT into marcacion_docente(docente_id, fecha, hora_registro,  dia, estado) VALUES ('$docente_id', now(),'$time',  $fecha_dia, 'entrada')";
                                                $result_marcacion = mysqli_query($conexion, $query_marcacion);

                                                $query_asistencia = "INSERT INTO asistencia_docente(detalle_jornada_id , docente_id , fecha , hora_inicio , hora_fin , dia) VALUES ('$detalle_id' , '$docente_id' , now() , '$hora_inicio' , '$hora_fin' , '$fecha_dia')";
                                                $result_asistencia = mysqli_query($conexion, $query_asistencia);
                                        } else {
                                        ?>
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                <strong>Ya realizo esta marcaci??n!!!</strong>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                </button>
                                        </div>
                                        <div class="row alert alert-secondary alert-dismissible fade show">
                                                <div class="col text-center">
                                                        <h4>??Cerrar sesi??n?</h4>
                                                        <a style =" width: 100px" type="button" class="btn btn-success text-center text-white"
                                                                href="../includes/logout.php"><strong>Si<strong>
                                                        </a>
                                                        <a style =" width: 100px" type="button" class="btn btn-primary text-center text-white"
                                                                 href="/universys/jornada"><strong>No</strong>
                                                        </a>        
                                                                        
                                                </div>         
                                        </div>
                                        <?php
                                        }
                                }
                        }
                }
        }
}
$last_id = mysqli_insert_id($conexion);
// Sino tiene una marcacion en mesa de examen por que no es fecha de mesa entonces entra para una marcacion de jornada comun 


if ($last_id == 0) {
        
       
        $query_jornada = "SELECT *FROM jornada_docente WHERE docente_id='$docente_id'";
        $result_jornada = mysqli_query($conexion, $query_jornada);
        while ($row_jornada = mysqli_fetch_array($result_jornada)) {
                $jornada = $row_jornada['jornada_id'];
                $marc_bol=true;
               


                $query_fecha = "SELECT *FROM jornada WHERE id='$jornada'";
                $result_fecha = mysqli_query($conexion, $query_fecha);
                $row_fecha = mysqli_fetch_assoc($result_fecha);
                $fecha_inicio = $row_fecha['fecha_inicio'];
                $fecha_fin    = $row_fecha['fecha_fin'];

                if (strtotime($fecha_inicio) < strtotime($fecha) and strtotime($fecha_fin) > strtotime($fecha)) {

                        $query_detalle_jornada = "SELECT *from detalle_jornada WHERE jornada_id = '$jornada' AND dia='$fecha_dia' AND '$time' >= ADDTIME(hora_inicio, '-00:20:00') AND '$time' <= ADDTIME(hora_inicio, '00:30:00')";
                        $result_detalle_jornada = mysqli_query($conexion, $query_detalle_jornada);
                        if (mysqli_num_rows($result_detalle_jornada) == 0) {
                               
                        } 
                        else {
                                $sin_det_jornada = false;
                                while ($row_detalle_jornada = mysqli_fetch_array($result_detalle_jornada)) {
                                        $detalle_id = $row_detalle_jornada['id'];
                                        $hora_inicio = $row_detalle_jornada['hora_inicio'];
                                        $hora_fin = $row_detalle_jornada['hora_fin'];

                                        $query_exis_marcacion = "SELECT *from marcacion_docente WHERE docente_id='$docente_id' AND fecha = '$fecha' AND hora_registro >= ADDTIME('$time', '-00:20:00') AND hora_registro <= ADDTIME('$time', '00:30:00')";
                                        $result_exis_marcacion = mysqli_query($conexion, $query_exis_marcacion);
                                        if (mysqli_num_rows($result_exis_marcacion) == 0) {

                                                ?>
                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                        <strong><?php echo "registro su entrada a las: ",$time; ?></strong>
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                        </button>
                                                </div>
                                                <div class="row alert alert-secondary alert-dismissible fade show">
                                                        <div class="col text-center">
                                                                <h4>??Cerrar sesi??n?</h4>
                                                                <a style =" width: 100px" type="button" class="btn btn-success text-center text-white"
                                                                href="../includes/logout.php"><strong>Si<strong>
                                                                </a>
                                                                <a style =" width: 100px" type="button" class="btn btn-primary text-center text-white"
                                                                        href="/universys/jornada"><strong>No</strong></a>                                  
                                                        </div>         
                                                </div>
                                                <?php

                                                $query_marcacion = "INSERT into marcacion_docente(docente_id, fecha, hora_registro,  dia, estado) VALUES ('$docente_id', now(),'$time',  $fecha_dia, 'entrada')";
                                                $result_marcacion = mysqli_query($conexion, $query_marcacion);

                                                $query_asistencia = "INSERT INTO asistencia_docente(detalle_jornada_id , docente_id , fecha , hora_inicio , hora_fin , dia) VALUES ('$detalle_id' , '$docente_id' , now() , '$hora_inicio' , '$hora_fin' , '$fecha_dia')";
                                                $result_asistencia = mysqli_query($conexion, $query_asistencia);
                                        } 
                                        else {
                                        if ($tiene_mesa == false) {
                                        ?>
                                        
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                <strong>Ya realizo esta marcaci??n!!!</strong>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                </button>
                                        </div>
                                        <div class="row alert alert-secondary alert-dismissible fade show">
                                                <div class="col text-center">
                                                        <h4>??Cerrar sesi??n?</h4>
                                                        <a style =" width: 100px" type="button" class="btn btn-success text-center text-white"
                                                                href="../includes/logout.php"><strong>Si<strong>
                                                        </a>
                                                        <a style =" width: 100px" type="button" class="btn btn-primary text-center text-white"
                                                                 href="/universys/jornada"><strong>No</strong>
                                                        </a>         
                                                                        
                                                </div>         
                                        </div>
                                        <?php
                                        }
                                }
                                }
                        }
                }
              
        }
                  
 }
if ($marc_bol == false) {
        ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>No existen jornadas para este agente.</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                </button>
        </div>
        <div class="row alert alert-secondary alert-dismissible fade show">
                <div class="col text-center">
                        <h4>??Cerrar sesi??n?</h4>
                        <a style =" width: 100px" type="button" class="btn btn-success text-center text-white"
                                href="../includes/logout.php"><strong>Si<strong>
                        </a>
                        <a style =" width: 100px" type="button" class="btn btn-primary text-center text-white"
                                href="/universys/jornada"><strong>No</strong>
                        </a>        
                                        
                </div>         
        </div>
        <?php 
}else{
        if ($sin_det_jornada == true) {
                ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>No tiene un horario asignado para esta hora.</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="row alert alert-secondary alert-dismissible fade show">
                        <div class="col text-center">
                                <h4>??Cerrar sesi??n?</h4>
                                <a style =" width: 100px" type="button" class="btn btn-success text-center text-white"
                                        href="../includes/logout.php"><strong>Si<strong>
                                </a>
                                <a style =" width: 100px" type="button" class="btn btn-primary text-center text-white"
                                                href="/universys/jornada"><strong>No</strong>
                                </a>                  
                        </div>         
                </div>
                <?php
        }
}

include("../includes/footer.php"); ?>
