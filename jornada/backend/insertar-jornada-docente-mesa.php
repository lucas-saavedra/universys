<?php
include('../includes/db.php');
$json = array();



if (isset($_POST['llamado_id'])) {

    $fechaInicioMesa = $_POST['fechaInicioMesa'];
    $fechaFinMesa = $_POST['fechaFinMesa'];
    $descripcion = $_POST['descripcion'];
    $carrera_id = $_POST['carrera_id'];
    $llamado_id = $_POST['llamado_id'];

    if (strtotime($fechaInicioMesa) > strtotime($fechaFinMesa)) {
        $json[] = array(
            'name' => 'La fecha de inicio debe ser menor a la fecha de fin',
            'type' => 'warning',
            'success' => false
        );
    } else {
        mysqli_query($conexion, 'START TRANSACTION');
        try {
            $query1 = "INSERT INTO `jornada` ( `fecha_inicio`, `fecha_fin`, `tipo_jornada_id`, `descripcion`) 
        VALUES ( '$fechaInicioMesa', '$fechaFinMesa', '4', '$descripcion');";
            if (!$result = mysqli_query($conexion, $query1)) throw new Exception(mysqli_error($conexion));

            $jornadaCreadaId = mysqli_insert_id($conexion);
            $dia_id = $_POST['dia_id'];
            $hora_inicio = $_POST['hora_inicio_mesa'];
            $hora_fin = $_POST['hora_fin_mesa'];

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
    }
} else if (isset($_POST['docentes_mesa_id'])) {

    $array_agente = $_POST['docentes_mesa_id'];
    $detalle_jornada_id = $_POST['horario_id'];
    $mesa_examen_id = $_POST['mesa_id'];

    foreach ($array_agente as $id) {

        $sql = "SELECT * FROM jornada_docente_mesa where docente_id = '$id' and det_jornada_id='$detalle_jornada_id' and mesa_examen_id ='$mesa_examen_id'";
        $consulta = mysqli_query($conexion, $sql);
        if (!mysqli_num_rows($consulta) > 0) {
            $query_mesa = " INSERT INTO jornada_docente_mesa
            (docente_id,det_jornada_id, mesa_examen_id) VALUES
            ($id, '$detalle_jornada_id', '$mesa_examen_id'); ";
            try {
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
}


$jsonstring = json_encode($json[0]);
echo $jsonstring;
