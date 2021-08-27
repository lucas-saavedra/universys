<?php include("../includes/header.php"); ?>
<?php /* include('../dataBase.php'); */ ?>
<?php include('../jornada/includes/consultas.php'); ?>

<?php

//                                          JORNADA DOCENTE

function generar_fechas_a_procesar($fecha_ref)
{

    $format = 'Y-n-j';

    $result = [];
    $result[] = $fecha_ref->modify('-1 day')->format($format);
    $result[] = $fecha_ref->modify('-2 day')->format($format);
    $result[] = $fecha_ref->modify('-3 day')->format($format);
    $result[] = $fecha_ref->modify('-4 day')->format($format);
    $result[] = $fecha_ref->modify('-5 day')->format($format);

    return $result;
}



$hoy = new DateTimeImmutable('NOW');
// el  $query_jornada_docente lo traigo desde jornadas/includes/consultas.php

foreach (generar_fechas_a_procesar($hoy) as $fecha_anterior) {
    
    $result_fecha_dia = mysqli_query($conexion, "select weekday ('$fecha_anterior')");
    while ($row_fecha_dia = mysqli_fetch_array($result_fecha_dia)) {
        $fecha_dia = $row_fecha_dia[0];
    }

    $result_jornada_docente = mysqli_query($conexion, $query_jornada_docente);
    $result_jornada_no_docente = mysqli_query($conexion, $query_jornada_no_docente);

    while ($jd = mysqli_fetch_array($result_jornada_docente)) {
        if (strtotime($jd['fecha_inicio']) < strtotime($fecha_anterior) and strtotime($jd['fecha_fin']) > strtotime($fecha_anterior)) {

            $hora_inicio = $jd['hora_inicio'];
            $hora_fin = $jd['hora_fin'];

            if ($jd['dia'] == $fecha_dia) {
                if (get_asistencias_num_rows($conexion, $jd['detalle_id'], $fecha_anterior, $jd['agente_id'], 'docente')) {
                   
                    if (get_exp_num_rows($conexion, $jd['persona_id'], $fecha_anterior, 'docente')) {
                        
                        if (get_inasistencias_num_rows($conexion, $jd['agente_id'], $hora_inicio, $fecha_anterior, $hora_fin, 'docente')) {
                            
                            $insert_falta = "INSERT INTO inasistencia_sin_aviso_docente (docente_id,fecha,hora_inicio,hora_fin,dia) 
                                        VALUES('{$jd['agente_id']}','$fecha_anterior','$hora_inicio','$hora_fin','$fecha_dia')";
                            if (($result_insert_falta = mysqli_query($conexion, $insert_falta)) === false) {
                                die(mysqli_error($conexion));
                            }
                        }
                    }
                }
            }
        }
    }
}



/* 
////////////////////////////////////////////

//                                          JORNADA NO DOCENTE

$query_jornada_no_docente = "SELECT DISTINCT no_docente_id,jornada_id, area_id FROM jornada_no_docente";
$result_jornada_no_docente = mysqli_query($conexion, $query_jornada_no_docente);
while ($row_jornada_no_docente = mysqli_fetch_array($result_jornada_no_docente)) {
    $no_docente =  $row_jornada_no_docente['no_docente_id'];
    $jornada = $row_jornada_no_docente['jornada_id'];

    $query_jornada = "SELECT *FROM jornada WHERE id='$jornada'";
    $result_jornada = mysqli_query($conexion, $query_jornada);
    while ($row_jornada = mysqli_fetch_array($result_jornada)) {
        $fecha_inicio = $row_jornada['fecha_inicio'];
        $fecha_fin = $row_jornada['fecha_fin'];
    }


    if (strtotime($fecha_inicio) < strtotime($fecha_anterior) and strtotime($fecha_fin) > strtotime($fecha_anterior)) {
        $query_detalle_jornada = "SELECT *FROM detalle_jornada WHERE jornada_id = '$jornada' and dia='$fecha_dia'";
        $result_detalle_jornada = mysqli_query($conexion, $query_detalle_jornada);
        while ($row_detalle_jornada = mysqli_fetch_array($result_detalle_jornada)) {
            $id_detalle = $row_detalle_jornada['id'];
            $hora_inicio = $row_detalle_jornada['hora_inicio'];
            $hora_fin = $row_detalle_jornada['hora_fin'];
            $query_asistencia = "SELECT *FROM asistencia_no_docente WHERE detalle_jornada_id = '$id_detalle' AND fecha = '$fecha_anterior' and no_docente_id='$no_docente'";
            $result_asistencia = mysqli_query($conexion, $query_asistencia);
            if (mysqli_num_rows($result_asistencia) == 0) {

                $query_expediente = "SELECT *FROM expediente WHERE persona_id='$persona' and fecha_inicio <= '$fecha_anterior' and fecha_fin >= '$fecha_anterior' AND confirmado='1'";
                $result_expediente = mysqli_query($conexion, $query_expediente);
                if (mysqli_num_rows($result_expediente) == 0) {

                    $query_inasistencia = "SELECT *FROM inasistencia_sin_aviso_no_docente WHERE 
                        fecha='$fecha_anterior' AND no_docente_id='$no_docente' AND hora_inicio='$hora_inicio' AND hora_fin='$hora_fin'";
                    $result_inasistencia = mysqli_query($conexion, $query_inasistencia);
                    if (mysqli_num_rows($result_inasistencia) == 0) {

                        $insert_falta = "INSERT INTO inasistencia_sin_aviso_no_docente (no_docente_id,fecha,hora_inicio,hora_fin,dia) VALUES('$no_docente','$fecha_anterior','$hora_inicio','$hora_fin','$fecha_dia')";
                        if (($result_insert_falta = mysqli_query($conexion, $insert_falta)) === false) {
                            die(mysqli_error($conexion));
                        }
                    } else {
                    }
                } else {
                }
            } else {
            }
        }
    }
}

*/
///////////////////////////////////////////////

//                                  JORNADA MESA DE EXAMEN

/* 
$query_jornada_docente = "SELECT DISTINCT docente_id, det_jornada_id, mesa_examen_id FROM jornada_docente_mesa";*/
/* $result_jornada_mesa = mysqli_query($conexion, $$query_jornada_mesa); 

while ($jdm = mysqli_fetch_array($result_jornada_mesa)) {

    $agente_id =  $jdm['docente_id'];
    $mesa_examen = $jdm['mesa_examen_id'];
    $fecha_inicio = $jdm['fecha_inicio'];
    $fecha_fin = $jdm['fecha_fin'];
    $persona_id = $jdm['persona_id'];

 
    if (strtotime($fecha_inicio) < strtotime($fecha_anterior) and strtotime($fecha_fin) > strtotime($fecha_anterior)) {

            $hora_inicio = $row_detalle_jornada['hora_inicio'];
            $hora_fin = $row_detalle_jornada['hora_fin'];
            if ($jd['dia_id'] == $fecha_dia) {

            if (get_asistencias_num_rows($conexion,$jdm['det_jornada_id'],$fecha_anterior,$agente_id,'docente')) {

                if (get_exp_num_rows($conexion,$jdm['persona_id'],$fecha_anterior)) {


                    if (get_inasistencias_num_rows($conexion,$agente_id,$hora_inicio,$fecha_anterior,$hora_fin,'docente')) {

                        $insert_falta = "INSERT INTO inasistencia_sin_aviso_docente (docente_id,fecha,hora_inicio,hora_fin,dia) 
                        VALUES('$agente_id','$fecha_anterior','$hora_inicio','$hora_fin','$fecha_dia')";
                        if (($result_insert_falta = mysqli_query($conexion, $insert_falta)) === false) {
                            die(mysqli_error($conexion));
                        }
                    }
                } 
            } 
        }
    }
}  */
header("Location: crear-expediente-sin-aviso.php");
?>