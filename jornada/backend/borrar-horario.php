<?php
include('../includes/db.php');

if (isset($_POST['horario_id'])) {
  $id = $_POST['horario_id'];
  $query = "DELETE FROM detalle_jornada WHERE id = '$id' ";

  if (mysqli_query($conexion, $query)) {
    $json = array();
    $json[0] = array(
      'message' => 'La el detalle de la jornada ha sido eliminada',
      'message-type' => 'danger'
    );
    $jsonstring = json_encode($json);
    echo $jsonstring;
  }
}
