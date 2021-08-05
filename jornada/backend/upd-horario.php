
<?php
include('../includes/db.php');
$json = array();
if (isset($_POST['id'])) {
  $id = $_POST['id'];
  $inicio = $_POST['inicio'];
  $fin = $_POST['fin'];

  $query1 = "UPDATE detalle_jornada SET  hora_inicio =  '$inicio',
  `hora_fin` = '$fin'
    WHERE `detalle_jornada`.`id` = '$id'";
  try {
    if (strtotime($inicio) > strtotime($fin)) {
      throw new Exception('La hora de inicio no puede ser mayor a la hora de fin');
    }
    if (!$result = mysqli_query($conexion, $query1)) throw new Exception(mysqli_error($conexion));
  } catch (Exception $e) {
    $json[] = array(
      'name' => $e->getMessage(),
      'type' => 'warning',
      'success' => false
    );
  }
  $json[] = array(
    'name' => 'El horario se actualizó correctamente a la jornada',
    'type' => 'success',
    'success' => true
  );
} else {

  $horario_id = $_POST['horario_id'];
  $jornadaId = $_POST['jornadaId'];
  $descripcion = $_POST['descripcion'];
  $hora_inicio = $_POST['hora_inicio'];
  $hora_fin = $_POST['hora_fin'];
  $dia_id = $_POST['dia_id'];

  $query1 = "UPDATE detalle_jornada SET jornada_id = '$jornadaId', hora_inicio =  '$hora_inicio',
 `hora_fin` = '$hora_fin',
  `dia` = '$dia_id',
   `descripcion` = '$descripcion' 
   WHERE `detalle_jornada`.`id` = '$horario_id'";

  try {
    if (strtotime($hora_inicio) > strtotime($hora_fin)) {
      throw new Exception('La hora de inicio no puede ser mayor a la hora de fin');
    }
    if (!$result = mysqli_query($conexion, $query1)) throw new Exception(mysqli_error($conexion));
    $json[] = array(
      'name' => 'El horario se actualizó correctamente a la jornada',
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
$jsonstring = json_encode($json[0]);
echo $jsonstring;
?>