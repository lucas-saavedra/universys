<?php
include('../includes/db.php');

  $jornadaId =  $_POST["jornadaId"];
  $jornadaDocenteId =  $_POST["jornadaDocenteId"];
  $catedraId =  $_POST["catedraId"];
  $docenteId =  $_POST["docenteId"];
  $fechaInicio =  $_POST["fechaInicio"];
  $fechaFin = $_POST["fechaFin"];
  $tipoJornadaId = $_POST["tipoJornadaId"];
  $descripcion = $_POST["descripcion"];


$json = array();

  mysqli_query($conexion, 'START TRANSACTION');
  try {
    $query1 =   "UPDATE jornada SET fecha_inicio = '$fechaInicio', fecha_fin = '$fechaFin', descripcion = '$descripcion', tipo_jornada_id = '$tipoJornadaId' WHERE jornada.id = '$jornadaId'";
    if (!$result = mysqli_query($conexion, $query1)) throw new Exception(mysqli_error($conexion));
    $query2 = " UPDATE jornada_docente SET docente_id = '$docenteId', catedra_id = '$catedraId' WHERE jornada_docente.id = '$jornadaDocenteId' ";
    mysqli_query($conexion, $query2);
    mysqli_commit($conexion);
  } catch (Exception $e) {
    $json[] = array(
        'name' => 'Upps, algo falló con la jornada:  <strong>[ '.$jornadaDocenteId.' ]</strong>',
        'type' => 'warning'
      );
  } 

  $json[] = array(
    'name' => 'La jornada docente <strong>[ '.$jornadaDocenteId.' ]</strong> ha sido actualizada',
    'type' => 'info'
  );
  $jsonstring = json_encode($json[0]);
  echo $jsonstring;

?>
