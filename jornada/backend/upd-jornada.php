<?php
include('../includes/db.php');

$jornadaId =  $_POST["jornadaId"];

$id_agente =  $_POST["id_agente"];
$fechaInicio =  $_POST["fechaInicio"];
$fechaFin = $_POST["fechaFin"];
$tipoJornadaId = $_POST["tipoJornadaId"];
$descripcion = $_POST["descripcion"];
$tipo_agente = $_POST["tipo_agente"];

if(!empty($_POST["jornada_agente_id"])){
  $jornada_agente_id =  $_POST["jornada_agente_id"];
}

if (!empty($_POST["area_id"])){
  $area_id =  $_POST["area_id"];
}
if (!empty($_POST["catedraId"])){
  $catedraId = $_POST["catedraId"];
}

$json = array();

  mysqli_query($conexion, 'START TRANSACTION');
  try {
    $query1 =   "UPDATE jornada SET fecha_inicio = '$fechaInicio', fecha_fin = '$fechaFin', descripcion = '$descripcion', tipo_jornada_id = '$tipoJornadaId' WHERE jornada.id = '$jornadaId'";
    if (!$result = mysqli_query($conexion, $query1)) throw new Exception(mysqli_error($conexion));
    if($tipo_agente=='docente'){
      $query2 = " UPDATE jornada_docente SET docente_id = '$id_agente', catedra_id = '$catedraId' WHERE jornada_docente.id = '$jornada_agente_id' ";

    }else if ($tipo_agente=='no_docente'){
      $query2 = " UPDATE jornada_no_docente SET no_docente_id = '$id_agente', area_id = '$area_id' WHERE jornada_no_docente.id = '$jornada_agente_id' ";

    }
    mysqli_query($conexion, $query2);
    mysqli_commit($conexion);
  } catch (Exception $e) {
    $json[] = array(
        'name' => 'Upps, algo falló con la jornada:  <strong>[ '.$jornada_agente_id.' ]</strong>',
        'type' => 'warning'
      );
  } 

  $json[] = array(
    'name' => 'La jornada docente <strong>[ '.$jornada_agente_id.' ]</strong> ha sido actualizada',
    'type' => 'info',
    'success' => true
  );
  $jsonstring = json_encode($json[0]);
  echo $jsonstring;

?>
