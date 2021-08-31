<?php include("../includes/header.php"); ?>

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
    $query_jornada_mesa_i = $query_jornada_mesa . "
        WHERE
        jornada.fecha_inicio <= '$fecha_anterior' 
        and jornada.fecha_fin >= '$fecha_anterior'";

    $query_jornada_docente_i = $query_jornada_docente . "
        WHERE
        detalle_jornada.dia = '$fecha_dia' 
        and fecha_inicio <= '$fecha_anterior' 
        and fecha_fin >= '$fecha_anterior'";

    $result_jornada_mesa = mysqli_query($conexion, $query_jornada_mesa_i);
    $result_jornada_docente = mysqli_query($conexion, $query_jornada_docente_i);
    
    if (mysqli_num_rows($result_jornada_mesa) !== 0) {

        while ($jdm = mysqli_fetch_array($result_jornada_mesa)) {
            if ($jdm['dia_id'] == $fecha_dia) {
                $hora_inicio = $jdm['hora_inicio'];
                $hora_fin = $jdm['hora_fin'];
                $agente_id = $jdm['agente_id'];
                if (get_asistencias_num_rows($conexion, $jdm['det_jornada_id'], $fecha_anterior,  $agente_id, 'docente')) {
                    if (get_exp_num_rows($conexion, $jdm['persona_id'], $fecha_anterior)) {
                        if (get_inasistencias_num_rows($conexion,  $agente_id, $hora_inicio, $fecha_anterior, $hora_fin, 'docente')) {
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
    } else {

        while ($jd = mysqli_fetch_array($result_jornada_docente)) {
            $hora_inicio = $jd['hora_inicio'];
            $hora_fin = $jd['hora_fin'];

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



    //                                          JORNADA NO DOCENTE

    $query_jornada_docente_i = $query_jornada_no_docente . "
        WHERE
        detalle_jornada.dia = '$fecha_dia' 
        and fecha_inicio <= '$fecha_anterior' 
        and fecha_fin >= '$fecha_anterior'";
    $result_jornada_no_docente = mysqli_query($conexion, $query_jornada_docente_i);

    while ($jnd = mysqli_fetch_array($result_jornada_no_docente)) {
        $hora_inicio = $jnd['hora_inicio'];
        $hora_fin = $jnd['hora_fin'];

        if (get_asistencias_num_rows($conexion, $jnd['detalle_id'], $fecha_anterior, $jnd['agente_id'], 'no_docente')) {

            if (get_exp_num_rows($conexion, $jnd['persona_id'], $fecha_anterior, 'no_docente')) {

                if (get_inasistencias_num_rows($conexion, $jnd['agente_id'], $hora_inicio, $fecha_anterior, $hora_fin, 'no_docente')) {
                    $insert_falta = "INSERT INTO inasistencia_sin_aviso_no_docente (no_docente_id,fecha,hora_inicio,hora_fin,dia) 
                                VALUES('{$jnd['agente_id']}','$fecha_anterior','$hora_inicio','$hora_fin','$fecha_dia')";
                    if (($result_insert_falta = mysqli_query($conexion, $insert_falta)) === false) {
                        die(mysqli_error($conexion));
                    }
                }
            }
        }
    }
}






header("Location: crear-expediente-sin-aviso.php");
?>