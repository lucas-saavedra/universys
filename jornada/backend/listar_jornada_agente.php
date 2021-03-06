<?php
include('../includes/db.php');
/* include('../includes/consultas.php'); */

$tipo_agente = $_POST['tipo_agente'];
$json = array();
if ($tipo_agente == 'docente') {
  $query = "SELECT 
    jornada_agente.id as jornada_agente_id,
    docente_id as agente_id ,
    catedra_id,
    jornada_id, 
    docente_nombre.nombre as docente, 
    c.nombre as catedra,
    c.anio_plan_id as anio_plan,
    c.carrera_id,
    carrera.nombre as carrera,
    j.fecha_inicio,
    j.fecha_fin,
    j.tipo_jornada_id,
    j.nombre as tipo_jornada,
    j.descripcion
    FROM jornada_docente as jornada_agente
    LEFT JOIN docente_nombre on jornada_agente.docente_id = docente_nombre.id
    LEFT JOIN catedra as c on c.id = catedra_id
    LEFT OUTER JOIN v_jornada as j on jornada_agente.jornada_id=j.id
    LEFT JOIN carrera on c.carrera_id = carrera.id";
} else {
  $query = "SELECT 
    jornada_agente.id as jornada_agente_id,
    no_docente_id as agente_id,
    area_id,
    jornada_id, 
    agente_nombre.nombre as no_docente,
    a.nombre as area,
    j.fecha_inicio,
    j.fecha_fin,
    j.tipo_jornada_id,
    j.nombre as tipo_jornada,
    j.descripcion
    FROM jornada_no_docente as jornada_agente
    LEFT JOIN agente_nombre on jornada_agente.no_docente_id= agente_nombre.id
    LEFT JOIN area as a on a.id = jornada_agente.area_id
    LEFT OUTER JOIN v_jornada as j on jornada_agente.jornada_id=j.id";
}

/* if (isset($_POST['filtroFechaInicio']) && isset($_POST['filtroFechaFin'])) {

  $filtroFechaInicio = $_POST['filtroFechaInicio'];
  $filtroFechaFin = $_POST['filtroFechaFin'];
  if ($_POST['filtroFechaInicio'] <> null && $_POST['filtroFechaFin'] <> null) {
    $query = $query . " WHERE fecha_inicio >=  '$filtroFechaInicio' and fecha_fin  <= '$filtroFechaFin' ";
  } else if (($_POST['filtroFechaInicio'] <> null && $_POST['filtroFechaFin'] == null)) {
    $query = $query . " WHERE fecha_inicio >=  '$filtroFechaInicio'";
  } else if (($_POST['filtroFechaInicio'] == null && $_POST['filtroFechaFin'] <> null)) {
    $query = $query . " WHERE fecha_fin  <= '$filtroFechaFin'";
  } else {
    $query = $query . " WHERE 1";
  }
} else {
  $query = $query . " WHERE 1";
}
 */

/* if (isset($_POST['filtroTipoJornadaId'])) {
  if (($_POST['filtroTipoJornadaId']) <> null) {
    $tipoJornadaId = $_POST['filtroTipoJornadaId'];
    $query = $query . " and j.tipo_jornada_id='$tipoJornadaId' ";
  }
}

if (isset($_POST['filtroCarreraId'])) {
  if (($_POST['filtroCarreraId']) <> null) {
    $filtroCarreraId = $_POST['filtroCarreraId'];
    $query = $query . " and c.carrera_id='$filtroCarreraId' ";
  }
}
if (isset($_POST['filtroAnioId'])) {
  if (($_POST['filtroAnioId']) <> null) {
    $filtroAnioId = $_POST['filtroAnioId'];
    $query = $query . " and c.anio_plan_id = '1'='$filtroAnioId'";
  }
}

if (isset($_POST['filtroAreaId'])) {
  if (($_POST['filtroAreaId']) <> null) {
    $filtroAreaId = $_POST['filtroAreaId'];
    $query = $query . " and area_id='$filtroAreaId' ";
  }
}
 */
if (isset($_POST['jornada_agente_id']) && isset($_POST['agente_id'])) {
  $jd_id = $_POST['jornada_agente_id'];
  $agente_id = $_POST['agente_id'];
  if ($tipo_agente == 'docente') {
    $query = $query . " WHERE docente_id ='$agente_id' and jornada_agente.id ='$jd_id' ";
  } else {
    $query = $query . " WHERE no_docente_id ='$agente_id' and jornada_agente.id ='$jd_id' ";
  }
} else {
  if (isset($_POST['jornada_agente_id'])) {
    $jd_id = $_POST['jornada_agente_id'];
    $query = $query . " WHERE jornada_agente.id ='$jd_id'";
  } else if (isset($_POST['agente_id'])) {
    $agente_id = $_POST['agente_id'];

    if ($tipo_agente == 'docente') {
      $query = $query . " WHERE docente_id ='$agente_id' ";
    } else {
      $query = $query . " WHERE no_docente_id ='$agente_id' ";
    }
  }
}


$result = mysqli_query($conexion, $query);
if (!$result) {
  die('Query failed' . mysqli_error($conexion));
}

while ($row = mysqli_fetch_array($result)) {
  $jornada_id = $row['jornada_id'];
  $sql = "SELECT detalle_jornada.jornada_id
  ,detalle_jornada.id as id, 
  hora_inicio,hora_fin,dia.id as dia_id, 
  dia.nombre,descripcion  
  from  detalle_jornada 
  left join dia on detalle_jornada.dia = dia.id  
  where jornada_id ='$jornada_id' 
  order by detalle_jornada.dia";

  $res = mysqli_query($conexion, $sql);
  if (!$res) {
    die('Fall??');
  }
  $json_hor = array();
  while ($row2 = mysqli_fetch_array($res)) {
    $json_hor[] = array(
      'id' => $row2['id'],
      'nombre' => $row2['nombre'],
      'jornada_id' => $row2['jornada_id'],
      'dia_id' => $row2['dia_id'],
      'hora_inicio' => $row2['hora_inicio'],
      'hora_fin' => $row2['hora_fin'],
      'descripcion' => $row2['descripcion']
    );
  }
  if ($tipo_agente == 'docente') {
    $json[] = array(
      'jornada_agente_id' => $row['jornada_agente_id'],
      'agente_id' => $row['agente_id'],
      'jornada_id' => $row['jornada_id'],
      'catedra_id' => $row['catedra_id'],
      'catedra' => $row['catedra'],
      'carrera' => $row['carrera'],
      'docente' => $row['docente'],
      'fecha_inicio' => $row['fecha_inicio'],
      'fecha_fin' => $row['fecha_fin'],
      'tipo_jornada' => $row['tipo_jornada'],
      'tipo_jornada_id' => $row['tipo_jornada_id'],
      'descripcion' => $row['descripcion'],
      'anio_plan' => $row['anio_plan'],
      'detalle_jornada' => $json_hor,
    );
  } else {

    $json[] = array(
      'jornada_agente_id' => $row['jornada_agente_id'],
      'jornada_id' => $row['jornada_id'],
      'agente_id' => $row['agente_id'],
      'area_id' => $row['area_id'],
      'area' => $row['area'],
      'no_docente' => $row['no_docente'],
      'fecha_inicio' => $row['fecha_inicio'],
      'fecha_fin' => $row['fecha_fin'],
      'tipo_jornada' => $row['tipo_jornada'],
      'tipo_jornada_id' => $row['tipo_jornada_id'],
      'descripcion' => $row['descripcion'],
      'detalle_jornada' => $json_hor,
    );
  }
}

$jsonstring = json_encode($json);
echo $jsonstring;
