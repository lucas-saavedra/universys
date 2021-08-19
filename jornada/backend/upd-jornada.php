<?php
include('../includes/db.php');

$jornadaId =  $_POST["jornadaId"];
$id_agente =  $_POST["id_agente"];
$fechaInicio =  $_POST["fechaInicio"];
$fechaFin = $_POST["fechaFin"];
$tipoJornadaId = $_POST["tipoJornadaId"];
$descripcion = $_POST["descripcion"];
$tipo_agente = $_POST["tipo_agente"];

if (!empty($_POST["jornada_agente_id"])) {
  $jornada_agente_id =  $_POST["jornada_agente_id"];
}

if (!empty($_POST["area_id"])) {
  $area_id =  $_POST["area_id"];
}
if (!empty($_POST["catedraId"])) {
  $catedraId = $_POST["catedraId"];
}

$json = array();

mysqli_query($conexion, 'START TRANSACTION');
try {

  if (strtotime($fechaInicio) > strtotime($fechaFin)) {
    throw new Exception('La fecha de inicio no puede ser mayor a la hora de fin');
  }
  $query1 =   "UPDATE jornada SET fecha_inicio = '$fechaInicio', fecha_fin = '$fechaFin', descripcion = '$descripcion', tipo_jornada_id = '$tipoJornadaId' WHERE jornada.id = '$jornadaId'";
  if (!$result = mysqli_query($conexion, $query1)) throw new Exception(mysqli_error($conexion));
  if ($tipo_agente == 'docente') {
    $query2 = " UPDATE jornada_docente SET docente_id = '$id_agente', catedra_id = '$catedraId' WHERE jornada_docente.id = '$jornada_agente_id' ";
  } else if ($tipo_agente == 'no_docente') {
    $query2 = " UPDATE jornada_no_docente SET no_docente_id = '$id_agente', area_id = '$area_id' WHERE jornada_no_docente.id = '$jornada_agente_id' ";
  }
  mysqli_query($conexion, $query2);
  if (isset($_POST['dias_horas'])) {

    $array_dias = $_POST['dias_horas'];
    foreach ($array_dias as $array_dias) {
      $query_detalle = "INSERT INTO detalle_jornada ( jornada_id, hora_inicio, hora_fin, dia) 
    VALUES ( '$jornadaId','{$array_dias['hora_inicio']}' , '{$array_dias['hora_fin']}', '{$array_dias['dia_id']}');";
      if (!$result = mysqli_query($conexion, $query_detalle)) throw new Exception(mysqli_error($conexion));
    }
  }
  mysqli_commit($conexion);
  $json[] = array(
    'name' => 'La jornada docente <strong>[ ' . $jornada_agente_id . ' ]</strong> ha sido actualizada',
    'type' => 'info',
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
