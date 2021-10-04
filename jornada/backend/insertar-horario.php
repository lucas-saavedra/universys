
<?php
include('../includes/db.php');
include('../includes/consultas.php');

$descripcion = $_POST["descripcion"];
$tipo_agente = $_POST["tipo_agente"];
$jornadaId = $_POST["jornadaId"];

$json = array();

mysqli_query($conexion, 'START TRANSACTION');
try {
  if (isset($_POST['dias_horas'])) {
    $array_dias = $_POST['dias_horas'];
    foreach ($array_dias as $array_dias) {
      if ($array_dias['hora_inicio'] > $array_dias['hora_fin']) {
        throw new Exception('La hora de inicio no puede ser mayor a la hora de fin');
      }
    }
  } else {
    throw new Exception('Debe agregar al menos un día con su horario');
  }

  if (!empty($_POST["id_agente"])) {
    $id_agente =  $_POST["id_agente"];
  } else {
    throw new Exception('Debe seleccionar todos los campos');
  }

  $fecha = get_fecha($conexion, $jornadaId);

  if (isset($_POST['dias_horas'])) {
    $array_dias = $_POST['dias_horas'];
    foreach ($array_dias as $array_dias) {
      $jornada = new stdClass();
      $jornada->hora_inicio = $array_dias['hora_inicio'];
      $jornada->hora_fin = $array_dias['hora_fin'];
      $jornada->id_agente = $id_agente;
      $jornada->dia_id = $array_dias['dia_id'];
      $jornada->fecha_inicio = $fecha['fecha_inicio'];
      $jornada->fecha_fin = $fecha['fecha_fin'];
      $jornada->tipo_agente = $tipo_agente;

      isOverlapedSql($conexion, $jornada);

      $query_detalle = "INSERT INTO detalle_jornada ( jornada_id, hora_inicio, hora_fin, dia) 
    VALUES ( '$jornadaId','{$array_dias['hora_inicio']}' , '{$array_dias['hora_fin']}', '{$array_dias['dia_id']}');";
      if (!$result = mysqli_query($conexion, $query_detalle)) throw new Exception(mysqli_error($conexion));
    }
  }

  mysqli_commit($conexion);
  $json[] = array(
    'name' => 'Se han agregado días a la jornada',
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
$jsonstring = json_encode($json[0]);
echo $jsonstring;
