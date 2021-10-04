<?php
include('../includes/db.php');
include('../includes/consultas.php');
$json = array();



if (isset($_POST['llamado_id'])) {

    $fechaInicioMesa = $_POST['fechaInicioMesa'];
    $fechaFinMesa = $_POST['fechaFinMesa'];
    $descripcion = $_POST['descripcion'];
    $carrera_id = $_POST['carrera_id'];
    $llamado_id = $_POST['llamado_id'];


    mysqli_query($conexion, 'START TRANSACTION');
    try {

        if (strtotime($fechaInicioMesa) > strtotime($fechaFinMesa)) {
            throw new Exception('La fecha de inicio no puede ser mayor a la fecha de fin');
        }
        $hora_inicio = $_POST['hora_inicio_mesa'];
        $hora_fin = $_POST['hora_fin_mesa'];
        if (strtotime($hora_inicio) > strtotime($hora_fin)) {
            throw new Exception('La hora de inicio no puede ser mayor a la hora de fin');
        }

        $query1 = "INSERT INTO `jornada` ( `fecha_inicio`, `fecha_fin`, `tipo_jornada_id`, `descripcion`) 
        VALUES ( '$fechaInicioMesa', '$fechaFinMesa', '4', '$descripcion');";
        if (!$result = mysqli_query($conexion, $query1)) throw new Exception(mysqli_error($conexion));

        $jornadaCreadaId = mysqli_insert_id($conexion);
        $dia_id = $_POST['dia_id'];


        foreach ($dia_id as $id) {
            $query_detalle = "INSERT INTO detalle_jornada ( jornada_id, hora_inicio, hora_fin, dia) 
            VALUES ( '$jornadaCreadaId','$hora_inicio' , '$hora_fin', '$id');";
            if (!$result = mysqli_query($conexion, $query_detalle)) throw new Exception(mysqli_error($conexion));
        }

        $query = "INSERT INTO mesa_examen (carrera_id, llamado_id, jornada_id) VALUES ( '$carrera_id', '$llamado_id', '$jornadaCreadaId');";
        if (!$result = mysqli_query($conexion, $query)) throw new Exception(mysqli_error($conexion));
        mysqli_commit($conexion);

        $json[] = array(
            'name' => '¡La jornada de mesa ha sido creada!',
            'type' => 'success',
            'success' => true
        );
    } catch (Exception $e) {
        $json[] = array(
            'name' => $e->getMessage(),
            'type' => 'warning',
            'success' => false
        );
        mysqli_rollback($conexion);
    }
} else if (isset($_POST['docentes_mesa_id'])) {

    $array_agente = $_POST['docentes_mesa_id'];
    $detalle_jornada_id = $_POST['horario_id'];
    $mesa_examen_id = $_POST['mesa_id'];

    $query = "select detalle_jornada.id as horario_id,hora_inicio,hora_fin,dia,fecha_inicio,fecha_fin from mesa_examen 
    LEFT JOIN jornada on jornada.id = mesa_examen.jornada_id
    LEFT JOIN detalle_jornada on detalle_jornada.jornada_id = mesa_examen.jornada_id
    WHERE mesa_examen.id = '$mesa_examen_id' and detalle_jornada.id = '$detalle_jornada_id'";
    $res = mysqli_fetch_assoc(mysqli_query($conexion, $query));

    foreach ($array_agente as $id) {

        $jornada_mesa = new stdClass();
        $jornada_mesa->hora_inicio = $res['hora_inicio'];
        $jornada_mesa->hora_fin = $res['hora_fin'];
        $jornada_mesa->dia_id = $res['dia'];
        $jornada_mesa->id_agente = $id;
        $jornada_mesa->fecha_inicio = $res['fecha_inicio'];
        $jornada_mesa->fecha_fin = $res['fecha_fin'];
        $jornada_mesa->tipo_agente = 'docente';

        $sql = "SELECT * FROM jornada_docente_mesa where docente_id = '$id' and det_jornada_id='$detalle_jornada_id' and mesa_examen_id ='$mesa_examen_id'";
        $consulta = mysqli_query($conexion, $sql);
        if (!mysqli_num_rows($consulta) > 0) {

            $query_mesa = " INSERT INTO jornada_docente_mesa
            (docente_id,det_jornada_id, mesa_examen_id) VALUES
            ($id, '$detalle_jornada_id', '$mesa_examen_id'); ";
            try {
                isOverlapedSqlMesa($conexion, $jornada_mesa);
                if (!$result = mysqli_query($conexion, $query_mesa)) throw new Exception(mysqli_error($conexion));
                $json[] = array(
                    'name' => 'Los docentes han sido agregados',
                    'type' => 'success',
                    'success' => true
                );
            } catch (Exception $e) {
                $json[] = array(
                    'name' => $e->getMessage(),
                    'type' => 'warning',
                    'success' => false
                );
            }
        } else {
            $json[] = array(
                'name' => 'Exito! Algunos docentes ya estaban previamente agregados!',
                'type' => 'info',
                'success' => true
            );
        }
    }
} else {
    $json[] = array(
        'name' => 'Debe agregar al menos un docente',
        'type' => 'warning',
        'success' => false
    );
}


$jsonstring = json_encode($json[0]);
echo $jsonstring;
