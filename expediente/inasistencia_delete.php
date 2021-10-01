<?php
    include "../includes/db.php";
    include ("./includes/consultas.php");
    
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];
    $fecha_dia = $_POST['fecha_dia'];
    $docente = $_POST['docente_id'];
    $fecha = $_POST['fecha'];
    $no_docente = $_POST['no_docente_id'];

    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id_docente'])) header("Location:crear-expediente-sin-aviso.php");
    
        $result = mysqli_query($conexion, "DELETE FROM inasistencia_sin_aviso_docente WHERE id={$_POST['id_docente']}");
        foreach (get_jornada_docente($conexion,$docente)as $get_jornada_id):
            $jornada_id = $get_jornada_id['jornada_id'];
        
            foreach (get_jornada($conexion,$jornada_id)as $get_jornada):
            $fecha_inicio = $get_jornada['fecha_inicio'];
            $fecha_fin = $get_jornada['fecha_fin'];

            if (strtotime($fecha_inicio) < strtotime($fecha) and strtotime($fecha_fin) > strtotime($fecha)) {
            
                foreach (get_det_jornada($conexion, $jornada_id, $hora_inicio, $hora_fin, $fecha_dia) as $det_jornada):
                $det_jornada_id = $det_jornada['id'];
                endforeach;
            }

            endforeach;
        endforeach;
        $result_asistencia = mysqli_query($conexion, "INSERT INTO asistencia_docente (detalle_jornada_id, docente_id, fecha,hora_inicio, hora_fin, dia)
        VALUES ('$det_jornada_id', '$docente', '$fecha','$hora_inicio', '$hora_fin', '$fecha_dia')");

    header("Location:crear-expediente-sin-aviso.php?del_expdte_id={$_POST['id_docente']}");

    

    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id_no_docente'])) header("Location:crear-expediente-sin-aviso.php");

        $result = mysqli_query($conexion, "DELETE FROM inasistencia_sin_aviso_no_docente WHERE id={$_POST['id_no_docente']}");
        
        foreach (get_jornada_no_docente($conexion,$no_docente)as $get_jornada_id):
            $jornada_id = $get_jornada_id['jornada_id'];
        
            foreach (get_jornada($conexion,$jornada_id)as $get_jornada):
            $fecha_inicio = $get_jornada['fecha_inicio'];
            $fecha_fin = $get_jornada['fecha_fin'];

            if (strtotime($fecha_inicio) < strtotime($fecha) and strtotime($fecha_fin) > strtotime($fecha)) {
            
                foreach (get_det_jornada($conexion, $jornada_id, $hora_inicio, $hora_fin, $fecha_dia) as $det_jornada):
                $det_jornada_id = $det_jornada['id'];
                endforeach;
            }

            endforeach;
        endforeach;

        $result_asistencia = mysqli_query($conexion, "INSERT INTO asistencia_no_docente (detalle_jornada_id, no_docente_id, fecha,hora_inicio, hora_fin, dia)
        VALUES ('$det_jornada_id', '$no_docente', '$fecha','$hora_inicio', '$hora_fin', '$fecha_dia')");

    header("Location:crear-expediente-sin-aviso.php?del_expdte_id={$_POST['id_no_docente']}");

?> 