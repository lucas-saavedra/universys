<?php
include('../includes/db.php');

$areaId =  $_POST["areaId"];
$tipoJornadaId =  $_POST["tipoJornadaId"];
$noDocenteId =  $_POST["noDocenteId"];
$fechaInicio =  $_POST["fechaInicio"];
$fechaFin = $_POST["fechaFin"];
$jornadaId = $_POST["jornadaId"];
$jornadaNoDocenteId = $_POST["jornadaNoDocenteId"];
$descripcion = $_POST["descripcion"];


$json = array();

  mysqli_query($conexion, 'START TRANSACTION');
  try {
    $query1 =   "UPDATE jornada SET fecha_inicio = '$fechaInicio', fecha_fin = '$fechaFin', descripcion = '$descripcion', tipo_jornada_id = '$tipoJornadaId' WHERE jornada.id = '$jornadaId'";
    if (!$result = mysqli_query($conexion, $query1)) throw new Exception(mysqli_error($conexion));
    $query2 = " UPDATE jornada_no_docente SET no_docente_id = '$noDocenteId', area_id = '$areaId' WHERE jornada_no_docente.id = '$jornadaNoDocenteId' ";
    mysqli_query($conexion, $query2);
    mysqli_commit($conexion);
  } catch (Exception $e) {
    $json[] = array(
        'name' => 'Upps, algo falló con la jornada:  <strong>[ '.$jornadaNoDocenteId.' ]</strong>',
        'type' => 'warning'
      );
  }  

  $json[] = array(
    'name' => 'La jornada docente <strong>[ '.$jornadaNoDocenteId.' ]</strong> ha sido actualizada', 
    'type' => 'info'
  );
  $jsonstring = json_encode($json[0]);
  echo $jsonstring;

?>
