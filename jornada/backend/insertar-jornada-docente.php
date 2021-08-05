<?php
include('../includes/db.php');

$fechaInicio =  $_POST["fechaInicio"];
$fechaFin = $_POST["fechaFin"];
$tipoJornadaId = $_POST["tipoJornadaId"];
$descripcion = $_POST["descripcion"];
$tipo_agente = $_POST["tipo_agente"];
$json = array();


mysqli_query($conexion, 'START TRANSACTION');
try {
  if (strtotime($fechaInicio) > strtotime($fechaFin)) {
    throw new Exception('<strong>Error: </strong> Fecha de inicio mayor que la fecha de fin');
  }
  if (!empty($_POST["id_agente"])) {
    $id_agente =  $_POST["id_agente"];
  } else {
    throw new Exception('Debe seleccionar todos los campos');
  }

  if ($tipo_agente == 'docente') {
    if (empty($_POST["catedraId"])) {
      throw new Exception('Debe seleccionar todos los campos');
    } else $catedraId =  $_POST["catedraId"];
  }

  if (!empty($_POST["area_id"])) {
    $area_id =  $_POST["area_id"];
  }

  $query1 = "INSERT INTO `jornada` ( `fecha_inicio`, `fecha_fin`, `tipo_jornada_id`, `descripcion`) 
          VALUES ( '$fechaInicio', '$fechaFin', '$tipoJornadaId', '$descripcion');";
  if (!$result = mysqli_query($conexion, $query1)) throw new Exception(mysqli_error($conexion));

  $jornadaCreadaId = mysqli_insert_id($conexion);

  if ($tipo_agente == 'docente') {
    $query2 = "INSERT INTO `jornada_docente` ( `docente_id`, `jornada_id`, `catedra_id`) VALUES ('$id_agente', '$jornadaCreadaId','$catedraId'); ";
  }
  if ($tipo_agente == 'no_docente') {
    $query2 = "INSERT INTO `jornada_no_docente` ( `no_docente_id`, `jornada_id`, `area_id`) VALUES 
        ('$id_agente', '$jornadaCreadaId','$area_id'); ";
  }
  if (!$result = mysqli_query($conexion, $query2)) throw new Exception(mysqli_error($conexion));

  mysqli_commit($conexion);

  $json[] = array(
    'name' => 'La jornada docente ha sido creada',
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
