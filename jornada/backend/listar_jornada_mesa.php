<?php
include('../includes/db.php');
include('../includes/consultas.php');

$json = array();
$json_mesa = array();
$json_agente_dia_mesa = array();
$json_detalle_jornada = array();


function get_jornadas_mesa($conexion)
{
  $query = "SELECT * FROM `mesa_examen_jornada`";

  if (isset($_POST['filtroFechaInicio']) && isset($_POST['filtroFechaFin'])) {
    $filtroFechaInicio = $_POST['filtroFechaInicio'];
    $filtroFechaFin = $_POST['filtroFechaFin'];
    $query = $query . " WHERE fecha_inicio >=  '$filtroFechaInicio' and fecha_fin  <= '$filtroFechaFin' ";
  }
  if (isset($_POST['filtroCarreraId'])) {
    if (($_POST['filtroCarreraId']) <> null) {
      $filtroCarreraId = $_POST['filtroCarreraId'];
      $query = $query . " and  mesa_examen_jornada.carreraId =  '$filtroCarreraId' ";
    }
  }
  if (isset($_POST['filtroLlamadoId'])) {
    if (($_POST['filtroLlamadoId']) <> null) {
      $filtroLlamadoId = $_POST['filtroLlamadoId'];
      $query = $query . " and llamadoId = '$filtroLlamadoId' ";
    }
  }

  $query = $query . " order by mesa_examen_jornada.id desc";

  $result = mysqli_query($conexion, $query);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}


function get_jornadas_horarios($conexion, $jornada_id)
{
  $sql =  "SELECT detalle_jornada.jornada_id ,detalle_jornada.id as det_jorn_id, hora_inicio,hora_fin, dia.nombre,descripcion ,detalle_jornada.dia as dia_id 
  from  detalle_jornada left join dia on detalle_jornada.dia = dia.id where jornada_id ='$jornada_id' order by detalle_jornada.dia";
  $result = mysqli_query($conexion, $sql);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}



foreach (get_jornadas_mesa($conexion) as $mesa) :
  foreach (get_jornadas_horarios($conexion,  $mesa['jornada_id']) as $horarios) :
    $json_agente_dia_mesa = [];
    foreach (get_agentes_mesa($conexion,  $mesa['id'], $horarios['det_jorn_id']) as $agente) :
      $json_agente_dia_mesa[] = array(
        'jornada_agente_id' =>  $agente['jornada_agente_id'],
        'docente' => $agente['docente']
      );

    endforeach;
    $json_detalle_jornada[] = array(
      'nombre' => $horarios['nombre'],
      'hora_inicio' => $horarios['hora_inicio'],
      'dia_id' => $horarios['dia_id'],
      'descripcion_dia' => $horarios['descripcion'],
      'hora_fin' => $horarios['hora_fin'],
      'det_jorn_id' => $horarios['det_jorn_id'],
      'docentes' => $json_agente_dia_mesa
    );
  endforeach;

  $json_mesa[] = array(
    'id' => $mesa['id'],
    'carrera_nombre' =>  $mesa['carrera_nombre'],
    'carrera_id' =>  $mesa['carreraId'],
    'llamado_nombre' =>  $mesa['llamado_nombre'],
    'jornada_id' =>  $mesa['jornada_id'],
    'fecha_inicio' => $mesa['fecha_inicio'],
    'fecha_fin' =>  $mesa['fecha_fin'],
    'descripcion' =>  $mesa['descripcion'],
    'detalle_mesa' => $json_detalle_jornada
  );
  $json_detalle_jornada = [];
endforeach;


$jsonstring = json_encode($json_mesa);
echo $jsonstring;
