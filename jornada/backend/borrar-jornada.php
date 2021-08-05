<?php
include('../includes/db.php');

$json = array();

if (isset($_POST['horario_id'])) {
  $id = $_POST['horario_id'];
  $query = "DELETE FROM detalle_jornada WHERE id = '$id' ";

  try {
    if (!$result = mysqli_query($conexion, $query)) throw new Exception(mysqli_error($conexion));

    $json[] = array(
      'name' => '¡El detalle de jornada ha sido eliminado!',
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
  if (isset($_POST['mesa_id'])) {
    $mesa_id = $_POST['mesa_id'];
    $jornada_id = $_POST['jornada_id'];
    $query1 = "DELETE FROM mesa_examen WHERE mesa_examen.id = '$mesa_id'";
    $query2 = "DELETE FROM jornada WHERE id = '$jornada_id' ";

    try {
      if (!$result = mysqli_query($conexion, $query1)) throw new Exception(mysqli_error($conexion));
      if (!$result = mysqli_query($conexion, $query2)) throw new Exception(mysqli_error($conexion));
      $json[] = array(
        'name' => 'La jornada docente de mesa ha sido eliminada',
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

    if (isset($_POST['jornada_id'])) {
      $jornada_id = $_POST['jornada_id'];
      $query1 = "DELETE FROM jornada WHERE id = '$jornada_id' ";
    } else
  if (isset($_POST['jornada_agente_mesa_id'])) {
      $j_agente_id = $_POST['jornada_agente_mesa_id'];
      $query1 = "DELETE FROM jornada_docente_mesa WHERE jornada_docente_mesa.id = '$j_agente_id'";
    }
    try {
      if (!$result = mysqli_query($conexion, $query1)) throw new Exception(mysqli_error($conexion));
      $json[] = array(
        'name' => '¡Eliminado con exito!',
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
  }
}

$jsonstring = json_encode($json[0]);
echo $jsonstring;
