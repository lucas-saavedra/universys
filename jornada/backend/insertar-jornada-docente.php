<?php
include('../includes/db.php');

function insertar_jornada($conexion)
{
  $catedraId =  $_POST["catedraId"];
  $docenteId =  $_POST["docenteId"];
  $fechaInicio =  $_POST["fechaInicio"];
  $fechaFin = $_POST["fechaFin"];
  $tipoJornadaId = $_POST["tipoJornadaId"];
  $descripcion = $_POST["descripcion"];
  mysqli_query($conexion, 'START TRANSACTION');
  try {
    $query1 = "INSERT INTO `jornada` ( `fecha_inicio`, `fecha_fin`, `tipo_jornada_id`, `descripcion`) 
        VALUES ( '$fechaInicio', '$fechaFin', '$tipoJornadaId', '$descripcion');";
    if (!$result = mysqli_query($conexion, $query1)) throw new Exception(mysqli_error($conexion));
    $jornadaCreadaId = mysqli_insert_id($conexion);
    mysqli_query($conexion, "INSERT INTO `jornada_docente` ( `docente_id`, `jornada_id`, `catedra_id`) VALUES ('$docenteId', '$jornadaCreadaId','$catedraId'); ");
    $jornadaDocenteCreadaId = mysqli_insert_id($conexion);
    mysqli_commit($conexion);
  } catch (Exception $e) {
  }

  $json = array();
  $json[] = array(
    'name' => 'La jornada docente <strong>[ '.$jornadaDocenteCreadaId.' ]</strong> ha sido creada',
    'type' => 'success'
  );
  $jsonstring = json_encode($json[0]);
  echo $jsonstring;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $msg = insertar_jornada($conexion);
}
