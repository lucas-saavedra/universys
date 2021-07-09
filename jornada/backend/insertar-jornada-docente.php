<?php
include('../includes/db.php');

function insertar_jornada($conexion)
{

  
  $id_agente =  $_POST["id_agente"];
  $fechaInicio =  $_POST["fechaInicio"];
  $fechaFin = $_POST["fechaFin"];
  $tipoJornadaId = $_POST["tipoJornadaId"];
  $descripcion = $_POST["descripcion"];
  $tipo_agente = $_POST["tipo_agente"];

 
  if (!empty($_POST["area_id"])){
    $area_id =  $_POST["area_id"];
  }
  if (!empty($_POST["catedraId"])){
    $catedraId = $_POST["catedraId"];
  }


/*  if($tipo_agente =='docente'){
  if (empty($_POST["catedraId"])){
    $json[] = array(
      'name' => 'Error:  <strong> [Debe seleccionar todos los campos] </strong>',
      'type' => 'warning',
      'success' => false
    );
  }
} else if (empty($_POST["id_agente"]) ) {
    $json[] = array(
      'name' => 'Error:  <strong> [Debe seleccionar todos los campos] </strong>',
      'type' => 'warning',
      'success' => false
    );
  }
  else if ( strtotime($fechaInicio) > strtotime($fechaFin)) {

      $json[] = array(
      'name' => 'Error: Fecha de inicio mayor que la fecha de fin </strong>',
      'type' => 'warning',
      'success' => false
    );
  } else { */
    $json = array();

    mysqli_query($conexion, 'START TRANSACTION');
    try {
      $query1 = "INSERT INTO `jornada` ( `fecha_inicio`, `fecha_fin`, `tipo_jornada_id`, `descripcion`) 
          VALUES ( '$fechaInicio', '$fechaFin', '$tipoJornadaId', '$descripcion');";
      if (!$result = mysqli_query($conexion, $query1)) throw new Exception(mysqli_error($conexion));

      $jornadaCreadaId = mysqli_insert_id($conexion);

      if($tipo_agente =='docente'){
        $query2 = "INSERT INTO `jornada_docente` ( `docente_id`, `jornada_id`, `catedra_id`) VALUES ('$id_agente', '$jornadaCreadaId','$catedraId'); ";
      }
      if($tipo_agente =='no_docente'){
        $query2="INSERT INTO `jornada_no_docente` ( `no_docente_id`, `jornada_id`, `area_id`) VALUES 
        ('$id_agente', '$jornadaCreadaId','$area_id'); ";

      }
 if (!$result = mysqli_query($conexion, $query2)) throw new Exception(mysqli_error($conexion));
  $jornadaAgenteId = mysqli_insert_id($conexion);
      mysqli_commit($conexion);
    } catch (Exception $e) {
      $msg['content'] = $e->getMessage();
      $msg['type'] = 'warning';
      $msg['success'] = false;
      mysqli_rollback($conexion);
    }

    $json[] = array(
      'name' => 'La jornada docente <strong>[ ' . $jornadaAgenteId . ' ]</strong> ha sido creada',
      'type' => 'success',
      'success' => true
    );
 /*  } */
  $jsonstring = json_encode($json[0]);
  echo $jsonstring;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $msg = insertar_jornada($conexion);
}
