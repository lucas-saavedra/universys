<?php
include('../includes/db.php');
$json = array();

if (isset($_POST['jornada_id'])) {
    $jornada_id = $_POST['jornada_id'];
    $sql = "SELECT * FROM mesa_examen_jornada where jornada_id = '$jornada_id'";

    try {
        if (!$result = mysqli_query($conexion, $sql)) throw new Exception(mysqli_error($conexion));
    } catch (Exception $e) {
        $json[] = array(
            'name' => $e->getMessage(),
            'type' => 'warning',
            'success' => false
        );
    }
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'id' => $row['id'],
            'nombre' => $row['carrera_nombre'],
            'jornada_id' => $row['jornada_id'],
            'carrera_id' => $row['carreraId'],
            'llamado_id' => $row['llamadoId'],
            'llamado_nombre' => $row['llamado_nombre'],
            'fecha_inicio' => $row['fecha_inicio'],
            'fecha_fin' => $row['fecha_fin'],
            'descripcion' => $row['descripcion']
        );
    }
} else {
    if (isset($_POST['mesa_examen_id'])) {

        $mesa_examen_id = $_POST['mesa_examen_id'];
        $fechaInicioMesa = $_POST['fechaInicioMesa'];
        $fechaFinMesa = $_POST['fechaFinMesa'];
        $descripcion = $_POST['descripcion'];

        $carrera_id = $_POST['carrera_id'];
        $llamado_id = $_POST['llamado_id'];
        $jornada_id_mesa = $_POST['jornada_id_mesa'];

        mysqli_query($conexion, 'START TRANSACTION');

        try {
            $query1 = "UPDATE jornada SET fecha_inicio = '$fechaInicioMesa', 
            fecha_fin = '$fechaFinMesa', descripcion = '$descripcion' 
             WHERE jornada.id = '$jornada_id_mesa'";

            if (!$result = mysqli_query($conexion, $query1)) throw new Exception(mysqli_error($conexion));
            $query = "UPDATE mesa_examen set carrera_id = '$carrera_id',  llamado_id = '$llamado_id'
            WHERE mesa_examen.id = '$mesa_examen_id'";

            if (!$result = mysqli_query($conexion, $query)) throw new Exception(mysqli_error($conexion));
            mysqli_commit($conexion);

            $json[] = array(
                'name' => 'La jornada de mesa ha sido actualizada!',
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
}

$jsonstring = json_encode($json[0]);
echo $jsonstring;
