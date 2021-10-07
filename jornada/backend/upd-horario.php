
<?php
include('../includes/db.php');
include('../includes/consultas.php');
$json = array();




try {

  if (isset($_POST['mesa_id'])) {
    $horario_id = $_POST['horario_id'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];
    $dia_id = $_POST['dia_id'];

    $query1 = "UPDATE detalle_jornada SET  hora_inicio =  '$hora_inicio',
    `hora_fin` = '$hora_fin', dia='$dia_id' WHERE `detalle_jornada`.`id` = '$horario_id'";

    if (strtotime($hora_inicio) > strtotime($hora_fin)) {
      throw new Exception('La hora de inicio no puede ser mayor a la hora de fin');
    }
  } else {
    $horario_id = $_POST['horario_id'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];
    $tipo_agente = $_POST['tipo_agente'];
    $jornadaId = $_POST['jornadaId'];
    $id_agente = $_POST['id_agente'];
    $dia_id = $_POST['dia_id'];


    $query1 = "UPDATE detalle_jornada SET  hora_inicio =  '$hora_inicio',
  `hora_fin` = '$hora_fin', dia='$dia_id' WHERE `detalle_jornada`.`id` = '$horario_id'";

    if (strtotime($hora_inicio) > strtotime($hora_fin)) {
      throw new Exception('La hora de inicio no puede ser mayor a la hora de fin');
    }

    $fecha = get_fecha($conexion, $jornadaId);

    $jornada = new stdClass();
    $jornada->hora_inicio = $hora_inicio;
    $jornada->hora_fin = $hora_fin;
    $jornada->id_agente = $id_agente;
    $jornada->dia_id = $dia_id;
    $jornada->fecha_inicio = $fecha['fecha_inicio'];
    $jornada->fecha_fin = $fecha['fecha_fin'];
    $jornada->horario_id = $horario_id;
    $jornada->tipo_agente = $tipo_agente;
    isOverlapedSql($conexion, $jornada);
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


$jsonstring = json_encode($json[0]);
echo $jsonstring;
?>