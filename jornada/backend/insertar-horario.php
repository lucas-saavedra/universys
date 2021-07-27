
<?php
include('../includes/db.php');
$json = array();
/* $jornada_agente_id = $_POST['jornada_agente_id']; */
$jornadaId = $_POST['jornadaId'];
$descripcion = $_POST['descripcion'];
$hora_inicio = $_POST['hora_inicio'];
$hora_fin = $_POST['hora_fin'];
$dia_id = $_POST['dia_id'];

$query1 = "INSERT INTO detalle_jornada ( jornada_id, hora_inicio, hora_fin, dia, descripcion)
VALUES ( '$jornadaId', '$hora_inicio', '$hora_fin', '$dia_id', '$descripcion')";

try {
  if (!$result = mysqli_query($conexion, $query1)) throw new Exception(mysqli_error($conexion));
} catch (Exception $e) {
  $msg['content'] = $e->getMessage();
  $msg['type'] = 'warning';
  $msg['success'] = false;
}
$json[] = array(
  'name' => 'El horario se agregó correctamente a la jornada',
  'type' => 'success',
  'success' => true
);
$jsonstring = json_encode($json[0]);
echo $jsonstring;
?>