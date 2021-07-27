<?PHP
include('db.php');
function get_agentes($conexion, $tipo_agente)
{
  $sql = "SELECT $tipo_agente.id,nombre FROM $tipo_agente left join persona on $tipo_agente.id = persona.id";
  $result = mysqli_query($conexion, $sql);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
function get_areas($conexion)
{
  $sql = "SELECT * FROM area";
  $result = mysqli_query($conexion, $sql);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_tipo_jornadas($conexion, $tipo_agente)
{
  $sql = "SELECT * FROM tipo_jornada WHERE pertenece = '$tipo_agente'";
  $result = mysqli_query($conexion, $sql);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
function get_jornada_docentes($conexion)
{
  $sql = "SELECT 
  jd.id as jornada_doc_id,
  docente_id ,
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
  LEFT OUTER JOIN v_jornada as j on jd.jornada_id=j.id 
  order by docente ";
  $result = mysqli_query($conexion, $sql);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
function get_dia($conexion)
{
  $sql = "SELECT * FROM dia ";
  $result = mysqli_query($conexion, $sql);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_jornadas_horarios($conexion, $jornada_id)
{
  $sql =  "SELECT detalle_jornada.jornada_id ,detalle_jornada.id as det_jorn_id, hora_inicio,hora_fin, dia.nombre,descripcion  
  from  detalle_jornada left join dia on detalle_jornada.dia = dia.id where jornada_id ='$jornada_id' order by detalle_jornada.dia";
  $result = mysqli_query($conexion, $sql);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function obtener_jornadas($conexion, $fecha_inicio, $fecha_fin, $tipo_jornada_id)
{
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
  LEFT OUTER JOIN v_jornada as j on jd.jornada_id=j.id";

  if (isset($fecha_inicio)) {
    $query = $query . " WHERE fecha_inicio >=  '$fecha_inicio' and fecha_fin <= '$fecha_fin'";
  } else if (isset($tipo_jornada_id)) {
    $query = $query . " and j.tipo_jornada_id='$tipo_jornada_id' ";
  }

  $result = mysqli_query($conexion, $query);
  if (!$result) {
    die('Query failed' . mysqli_error($conexion));
  }

  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
function get_carreras($conexion)
{
  $sql = "SELECT * FROM carrera ";
  $result = mysqli_query($conexion, $sql);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
function get_llamado($conexion)
{
  $sql = "SELECT * FROM llamado ";
  $result = mysqli_query($conexion, $sql);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
function get_docentes($conexion)
{
  $sql = "SELECT * FROM docente_nombre ";
  $result = mysqli_query($conexion, $sql);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_jornadas_mesa($conexion)
{

  $sql = " SELECT * FROM `mesa_examen_jornada` ";
  $result = mysqli_query($conexion, $sql);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
function get_agentes_mesa($conexion, $mesa_id,$horario_id)
{
  $sql = "SELECT jdm.id as jornada_agente_id, 
  jdm.docente_id as agente_id , 
  docente_nombre.nombre as docente,
  detalle_jornada.jornada_id ,
  detalle_jornada.id as det_jorn_id, 
  hora_inicio,hora_fin, dia.nombre as dia_nombre,
  mesa_examen_jornada.id as id,
  mesa_examen_jornada.carrera_nombre
  from jornada_docente_mesa as jdm 
  LEFT JOIN detalle_jornada on jdm.det_jornada_id = detalle_jornada.id 
  LEFT JOIN mesa_examen_jornada on mesa_examen_jornada.id= jdm.mesa_examen_id
  LEFT JOIN docente_nombre on jdm.docente_id = docente_nombre.id
 left join dia on detalle_jornada.dia = dia.id 
WHERE mesa_examen_jornada.id = '$mesa_id' and detalle_jornada.id='$horario_id'";
  $result = mysqli_query($conexion, $sql);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
