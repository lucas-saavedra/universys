<?php
include('../includes/db.php');
include('../includes/consultas.php');
$tipo_agente = $_POST['tipo_agente'];
$json = array();
if ($tipo_agente == 'docente') {
  $query = "SELECT 
  jd.id as jornada_agente_id,
  docente_id as agente_id ,
  catedra_id,
  jornada_id, 
  docente_nombre.nombre as docente, 
  c.nombre as catedra,
  j.fecha_inicio,
  j.fecha_fin,
  j.tipo_jornada_id,
  j.nombre as tipo_jornada,
  j.descripcion
  FROM `jornada_docente` as jd
  LEFT JOIN docente_nombre on jd.docente_id = docente_nombre.id
  LEFT JOIN catedra as c on c.id = catedra_id
  LEFT OUTER JOIN v_jornada as j on jd.jornada_id=j.id ";

  if (isset($_POST['jornada_agente_id'])) {
    if ($tipo_agente == 'docente') {
      $jd_id = $_POST['jornada_agente_id'];
      $query = $query . " where jd.id = '$jd_id'";
    };
  }
} else if ($tipo_agente == 'no_docente') {
  $query = "SELECT 
      jnd.id as jornada_agente_id,
      no_docente_id as agente_id,
      area_id,
      jornada_id, 
      agente_nombre.nombre as agente, 
      a.nombre as area,
      j.fecha_inicio,
      j.fecha_fin,
      j.tipo_jornada_id,
      j.nombre as tipo_jornada,
      j.descripcion
      FROM `jornada_no_docente` as jnd
      LEFT JOIN agente_nombre on jnd.no_docente_id= agente_nombre.id
      LEFT JOIN area as a on a.id = jnd.area_id
      LEFT OUTER JOIN v_jornada as j on jnd.jornada_id=j.id";

  if (isset($_POST['jornada_agente_id'])) {
    if ($tipo_agente == 'no_docente') {
      $jnd_id = $_POST['jornada_agente_id'];
      $query = $query . " where jnd.id = '$jnd_id'";
    }
  };
}

$result = mysqli_query($conexion, $query);
if (!$result) {
  die('Query failed' . mysqli_error($conexion));
}
if ($tipo_agente == 'docente') {
  while ($row = mysqli_fetch_array($result)) {
    $json[] = array(
      'jornada_agente_id' => $row['jornada_agente_id'],
      'agente_id' => $row['agente_id'],
      'jornada_id' => $row['jornada_id'],
      'catedra_id' => $row['catedra_id'],
      'catedra' => $row['catedra'],
      'docente' => $row['docente'],
      'fecha_inicio' => $row['fecha_inicio'],
      'fecha_fin' => $row['fecha_fin'],
      'tipo_jornada' => $row['tipo_jornada'],
      'tipo_jornada_id' => $row['tipo_jornada_id'],
      'descripcion' => $row['descripcion']
    );
  }
} else if ($tipo_agente == 'no_docente') {

  while ($row = mysqli_fetch_array($result)) {
    $json[] = array(
      'jornada_agente_id' => $row['jornada_agente_id'],
      'jornada_id' => $row['jornada_id'],
      'agente_id' => $row['agente_id'],
      'area_id' => $row['area_id'],
      'area' => $row['area'],
      'no_docente' => $row['agente'],
      'fecha_inicio' => $row['fecha_inicio'],
      'fecha_fin' => $row['fecha_fin'],
      'tipo_jornada' => $row['tipo_jornada'],
      'tipo_jornada_id' => $row['tipo_jornada_id'],
      'descripcion' => $row['descripcion']
    );
  }
}


$jsonstring = json_encode($json);
echo $jsonstring;
