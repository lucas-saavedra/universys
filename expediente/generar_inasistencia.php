<?php include("../includes/db.php"); ?>
<?php include('../jornada/includes/consultas.php'); ?>
<?php include('includes/consultas.php'); ?>

<?php
$hoy = new DateTimeImmutable('NOW');

$get_f_inicio = new DateTime($_GET['f_inicio']);
$get_f_fin = new DateTime($_GET['f_fin']);

session_start();
$_SESSION['inasis_rango'] = ['inicio' => $_GET['f_inicio'], 'fin' => $_GET['f_fin']];

if ($get_f_inicio > $get_f_fin){
    $_SESSION['inasis_msg'] = ['content' => 'Rango incorrecto', 'type'=> 'danger'];
    header("Location: crear-expediente-sin-aviso.php");
    exit();
}

if ($get_f_fin > $hoy->modify('-1 day')){
    $_SESSION['inasis_msg'] = [
        'content' => 'No puede generar inasistencias que sean del dia de hoy ni de dias que aun no han transcurrido', 'type'=> 'danger'
    ];
    header("Location: crear-expediente-sin-aviso.php");
    exit();
}


//                                          JORNADA DOCENTE
function generar_rango_fechas($fecha_inicio, $fecha_fin)
{
    $format = 'Y-n-j';
    $result = [];
    $fecha_inicio = new DateTime($fecha_inicio);
    $fecha_fin = new DateTime($fecha_fin);
    $result[] = $fecha_inicio->format($format);
    while ($fecha_inicio < $fecha_fin) {
        $result[] = $fecha_inicio->modify('+1 day')->format($format);
    };

    return $result;
}

// el  $query_jornada_docente lo traigo desde jornadas/includes/consultas.php

foreach (generar_rango_fechas($_GET['f_inicio'], $_GET['f_fin']) as $fecha_anterior) {

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
                $jornada_id = $jdm['jornada_id'];
                foreach (get_jornada($conexion, $jornada_id) as $get_jornada) :
                    $tipo_jornada_id = $get_jornada['tipo_jornada_id'];
                endforeach;
                foreach (get_tipo_jornada($conexion, $tipo_jornada_id) as $get_tipo_jornada) :
                    $tipo_jornada = $get_tipo_jornada['nombre'];
                endforeach;

                if (get_asistencias_num_rows($conexion, $jdm['det_jornada_id'], $fecha_anterior,  $agente_id, 'docente')) {
                    if (get_exp_num_rows($conexion, $jdm['persona_id'], $fecha_anterior)) {
                        if (get_inasistencias_num_rows($conexion,  $agente_id, $hora_inicio, $fecha_anterior, $hora_fin, 'docente')) {
                            $insert_falta = "INSERT INTO inasistencia_sin_aviso_docente (docente_id,fecha,hora_inicio,hora_fin,dia,descripcion) 
                                VALUES('$agente_id','$fecha_anterior','$hora_inicio','$hora_fin','$fecha_dia','$tipo_jornada' )";
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
            $catedra = $jd['catedra_id'];
            $jornada = $jd['jornada_id'];

            foreach (get_jornada($conexion, $jornada) as $get_jornada) :
                $tipo_jornada_id = $get_jornada['tipo_jornada_id'];
            endforeach;
            foreach (get_tipo_jornada($conexion, $tipo_jornada_id) as $get_tipo_jornada) :
                $tipo_jornada = $get_tipo_jornada['nombre'];
            endforeach;

            if (get_asistencias_num_rows($conexion, $jd['detalle_id'], $fecha_anterior, $jd['agente_id'], 'docente')) {

                if (get_exp_num_rows($conexion, $jd['persona_id'], $fecha_anterior, 'docente')) {

                    if (get_inasistencias_num_rows($conexion, $jd['agente_id'], $hora_inicio, $fecha_anterior, $hora_fin, 'docente')) {
                        $insert_falta = "INSERT INTO inasistencia_sin_aviso_docente (docente_id,fecha,hora_inicio,hora_fin,dia, catedra_id, descripcion) 
                                        VALUES('{$jd['agente_id']}','$fecha_anterior','$hora_inicio','$hora_fin','$fecha_dia','$catedra','$tipo_jornada')";
                        if (($result_insert_falta = mysqli_query($conexion, $insert_falta)) === false) {
                            die(mysqli_error($conexion));
                        }
                    }
                }
            }
        }
    }
    
    



        //                                          JORNADA NO DOCENTE

        $query_jornada_no_docente_i = $query_jornada_no_docente . "
            WHERE
            detalle_jornada.dia = '$fecha_dia' 
            and fecha_inicio <= '$fecha_anterior' 
            and fecha_fin >= '$fecha_anterior'";
        $result_jornada_no_docente = mysqli_query($conexion, $query_jornada_no_docente_i);

        if (mysqli_num_rows($result_jornada_mesa) !== 0) {
            
            while ($jdm = mysqli_fetch_array($result_jornada_mesa)) {
                // si es docente y no docente
              /*  $persona_id = $jdm['persona_id'];
                if (es_no_docente($conexion,$persona_id)){
                    while ($jnd = mysqli_fetch_array($result_jornada_no_docente)) {
                        $hora_inicio_nd = $jnd['hora_inicio'];
                        $hora_fin_nd = $jnd['hora_fin'];
                        $dia_nd = $jnd['dia'];
                        if (($jdm['dia_id'] == $dia) AND ($dia_nd == $dia)){
                            $hora_inicio_m = $jdm['hora_inicio'];
                            $hora_fin_m = $jdm['hora_fin'];
                            if (($hora_inicio_m >= $hora_inicio_nd) AND ($hora_fin_m <= $hora_inicio_nd)){

                            }else{
                                while ($jnd = mysqli_fetch_array($result_jornada_no_docente)) {
                                    $hora_inicio = $jnd['hora_inicio'];
                                    $hora_fin = $jnd['hora_fin'];
                                    $area = $jnd['area'];
                        
                                    if (get_asistencias_num_rows($conexion, $jnd['detalle_id'], $fecha_anterior, $jnd['agente_id'], 'no_docente')) {
                        
                                        if (get_exp_num_rows($conexion, $jnd['persona_id'], $fecha_anterior, 'no_docente')) {
                        
                                            if (get_inasistencias_num_rows($conexion, $jnd['agente_id'], $hora_inicio, $fecha_anterior, $hora_fin, 'no_docente')) {
                                                $insert_falta = "INSERT INTO inasistencia_sin_aviso_no_docente (no_docente_id,fecha,hora_inicio,hora_fin,dia,area) 
                                                            VALUES('{$jnd['agente_id']}','$fecha_anterior','$hora_inicio','$hora_fin','$fecha_dia','$area')";
                                                if (($result_insert_falta = mysqli_query($conexion, $insert_falta)) === false) {
                                                    die(mysqli_error($conexion));
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }else{
                            while ($jnd = mysqli_fetch_array($result_jornada_no_docente)) {
                                $hora_inicio = $jnd['hora_inicio'];
                                $hora_fin = $jnd['hora_fin'];
                                $area = $jnd['area'];
                    
                                if (get_asistencias_num_rows($conexion, $jnd['detalle_id'], $fecha_anterior, $jnd['agente_id'], 'no_docente')) {
                    
                                    if (get_exp_num_rows($conexion, $jnd['persona_id'], $fecha_anterior, 'no_docente')) {
                    
                                        if (get_inasistencias_num_rows($conexion, $jnd['agente_id'], $hora_inicio, $fecha_anterior, $hora_fin, 'no_docente')) {
                                            $insert_falta = "INSERT INTO inasistencia_sin_aviso_no_docente (no_docente_id,fecha,hora_inicio,hora_fin,dia,area) 
                                                        VALUES('{$jnd['agente_id']}','$fecha_anterior','$hora_inicio','$hora_fin','$fecha_dia','$area')";
                                            if (($result_insert_falta = mysqli_query($conexion, $insert_falta)) === false) {
                                                die(mysqli_error($conexion));
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }else{
                    while ($jnd = mysqli_fetch_array($result_jornada_no_docente)) {
                        $hora_inicio = $jnd['hora_inicio'];
                        $hora_fin = $jnd['hora_fin'];
                        $area = $jnd['area'];
            
                        if (get_asistencias_num_rows($conexion, $jnd['detalle_id'], $fecha_anterior, $jnd['agente_id'], 'no_docente')) {
            
                            if (get_exp_num_rows($conexion, $jnd['persona_id'], $fecha_anterior, 'no_docente')) {
            
                                if (get_inasistencias_num_rows($conexion, $jnd['agente_id'], $hora_inicio, $fecha_anterior, $hora_fin, 'no_docente')) {
                                    $insert_falta = "INSERT INTO inasistencia_sin_aviso_no_docente (no_docente_id,fecha,hora_inicio,hora_fin,dia,area) 
                                                VALUES('{$jnd['agente_id']}','$fecha_anterior','$hora_inicio','$hora_fin','$fecha_dia','$area')";
                                    if (($result_insert_falta = mysqli_query($conexion, $insert_falta)) === false) {
                                        die(mysqli_error($conexion));
                                    }
                                }
                            }
                        }
                    } */

                if ($jdm['dia_id'] == $fecha_dia) {
                    $hora_inicio = $jdm['hora_inicio'];
                    $hora_fin = $jdm['hora_fin'];
                    $agente_id = $jdm['agente_id'];
                    $jornada_id = $jdm['jornada_id'];
                    foreach (get_jornada($conexion,$jornada_id)as $get_jornada):
                        $tipo_jornada_id = $get_jornada['tipo_jornada_id'];
                      endforeach;
                      foreach (get_tipo_jornada($conexion,$tipo_jornada_id)as $get_tipo_jornada):
                        $tipo_jornada = $get_tipo_jornada['nombre'];
                      endforeach;
    
                    if (get_asistencias_num_rows($conexion, $jdm['det_jornada_id'], $fecha_anterior,  $agente_id, 'docente')) {
                        if (get_exp_num_rows($conexion, $jdm['persona_id'], $fecha_anterior)) {
                            if (get_inasistencias_num_rows($conexion,  $agente_id, $hora_inicio, $fecha_anterior, $hora_fin, 'docente')) {
                                $insert_falta = "INSERT INTO inasistencia_sin_aviso_docente (docente_id,fecha,hora_inicio,hora_fin,dia,descripcion) 
                                    VALUES('$agente_id','$fecha_anterior','$hora_inicio','$hora_fin','$fecha_dia','$tipo_jornada' )";
                                if (($result_insert_falta = mysqli_query($conexion, $insert_falta)) === false) {
                                    die(mysqli_error($conexion));
                                }
                            }
                        }
                    }
                }
            }

        
        } else {
        while ($jnd = mysqli_fetch_array($result_jornada_no_docente)) {
            $hora_inicio = $jnd['hora_inicio'];
            $hora_fin = $jnd['hora_fin'];
            $area = $jnd['area'];

            if (get_asistencias_num_rows($conexion, $jnd['detalle_id'], $fecha_anterior, $jnd['agente_id'], 'no_docente')) {

                if (get_exp_num_rows($conexion, $jnd['persona_id'], $fecha_anterior, 'no_docente')) {

                    if (get_inasistencias_num_rows($conexion, $jnd['agente_id'], $hora_inicio, $fecha_anterior, $hora_fin, 'no_docente')) {
                        $insert_falta = "INSERT INTO inasistencia_sin_aviso_no_docente (no_docente_id,fecha,hora_inicio,hora_fin,dia,area) 
                                    VALUES('{$jnd['agente_id']}','$fecha_anterior','$hora_inicio','$hora_fin','$fecha_dia','$area')";
                        if (($result_insert_falta = mysqli_query($conexion, $insert_falta)) === false) {
                            die(mysqli_error($conexion));
                        }
                    }
                }
            }
        }
    }
}




$_SESSION['inasis_msg'] = [
    'content' => 'Las inasistencias dentro del rango elegido han sido generadas', 
    'type' => 'success'
];

header("Location: crear-expediente-sin-aviso.php");
?>