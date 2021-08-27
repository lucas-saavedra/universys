<?PHP
include('db.php');
/* function get_agentes($conexion, $tipo_agente)
{
  $sql = "SELECT $tipo_agente.id,nombre FROM $tipo_agente left join persona on $tipo_agente.id = persona.id";
  $result = mysqli_query($conexion, $sql);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
} */
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



function get_agentes_mesa($conexion, $mesa_id, $horario_id)
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

function get_jornadas_docentes_hoy($conexion, $docente_id)
{
  $query_jornadas =
    "SELECT hora_inicio,hora_fin,dia, fecha_inicio,fecha_fin, catedra.nombre as catedra, carrera.nombre as carrera  from jornada_docente 
    LEFT  join jornada on jornada.id = jornada_docente.jornada_id
    LEFT JOIN detalle_jornada on detalle_jornada.jornada_id = jornada_docente.jornada_id
    left JOIN catedra on catedra.id = jornada_docente.catedra_id
    right JOIN carrera on carrera.id = catedra.carrera_id
    WHERE jornada_docente.docente_id = '$docente_id' and detalle_jornada.dia = (select weekday(now()))
    order by hora_inicio";

  return mysqli_query($conexion, $query_jornadas);
}

function get_jornadas_no_docentes_hoy($conexion, $no_docente_id)
{
  $query_jornadas =
    "SELECT hora_inicio,hora_fin,dia, fecha_inicio,fecha_fin, area.nombre as area  from jornada_no_docente
  LEFT join jornada on jornada.id = jornada_no_docente.jornada_id
  LEFT JOIN detalle_jornada on detalle_jornada.jornada_id = jornada_no_docente.jornada_id
  left JOIN area on area.id = jornada_no_docente.area_id
  WHERE jornada_no_docente.no_docente_id = '$no_docente_id' and detalle_jornada.dia = (select weekday(now()))
  order by hora_inicio";
  return mysqli_query($conexion, $query_jornadas);
}

function get_jornadasmesa_docentes_hoy($conexion, $docente_id)
{
  $query_jornadas_mesa_hoy = "SELECT 
  docente_nombre.nombre as docente,
  hora_inicio,hora_fin, dia.nombre as dia_nombre,dia.id as dia_id,
  mesa_examen_jornada.id as id,
  mesa_examen_jornada.carrera_nombre,
  jornada.fecha_inicio,jornada.fecha_fin
  from jornada_docente_mesa as jdm
  LEFT JOIN detalle_jornada on jdm.det_jornada_id = detalle_jornada.id 
  LEFT JOIN mesa_examen_jornada on mesa_examen_jornada.id= jdm.mesa_examen_id
  LEFT JOIN docente_nombre on jdm.docente_id = docente_nombre.id
  LEFT join dia on detalle_jornada.dia = dia.id 
  LEFT JOIN jornada on mesa_examen_jornada.jornada_id = jornada.id
  WHERE jdm.docente_id = '$docente_id' and detalle_jornada.dia = (select weekday(now()))";
  return mysqli_query($conexion, $query_jornadas_mesa_hoy);
}

function get_roles($conexion){
  $sql="SELECT persona.nombre as persona,rol.nombre as rol from persona_rol 
  left join rol on persona_rol.rol_id = rol.id
  left join persona on persona.id = persona_rol.persona_id ORDER by persona.nombre";
  return mysqli_query($conexion, $sql);
}


$sql="SELECT DISTINCT j.fecha_inicio,j.fecha_fin, docente.persona_id,docente_id,jornada_id, catedra_id 
FROM jornada_docente 
LEFT JOIN docente on docente.id = jornada_docente.docente_id 
LEFT JOIN jornada as j on j.id = jornada_docente.jornada_id";


$query_jornada_no_docente="SELECT
jornada_no_docente.jornada_id AS jornada_id,
detalle_jornada.id as detalle_id,
hora_inicio,
hora_fin,
dia,
fecha_inicio,
fecha_fin,
area.nombre AS area,
jornada_no_docente.no_docente_id as agente_id,
persona.id AS persona_id
FROM
jornada_no_docente
LEFT JOIN no_docente ON no_docente.id = jornada_no_docente.no_docente_id
LEFT JOIN persona ON persona.id = no_docente.persona_id
LEFT JOIN jornada ON jornada.id = jornada_no_docente.jornada_id
LEFT JOIN detalle_jornada ON detalle_jornada.jornada_id = jornada_no_docente.jornada_id
LEFT JOIN area ON area.id = jornada_no_docente.area_id
WHERE
detalle_jornada.dia =(
SELECT
WEEKDAY(NOW())) -1";

$query_jornada_docente="SELECT
jornada_docente.jornada_id AS jornada_id,
detalle_jornada.id AS detalle_id,
hora_inicio,
hora_fin,
dia,
fecha_inicio,
fecha_fin,
catedra.nombre AS catedra,
carrera.nombre AS carrera,
jornada_docente.docente_id AS agente_id,
persona.id AS persona_id
FROM
jornada_docente
LEFT JOIN docente ON docente.id = jornada_docente.docente_id
LEFT JOIN persona ON persona.id = docente.persona_id
LEFT JOIN jornada ON jornada.id = jornada_docente.jornada_id
LEFT JOIN detalle_jornada ON detalle_jornada.jornada_id = jornada_docente.jornada_id
LEFT JOIN catedra ON catedra.id = jornada_docente.catedra_id
LEFT JOIN carrera ON carrera.id = catedra.carrera_id
/*WHERE
detalle_jornada.dia =(
SELECT
WEEKDAY(NOW()))-1*/";

function get_asistencias_num_rows($conexion,$id_detalle,$fecha_anterior,$agente_id,$tipo_agente){
  $query_asistencia = "SELECT * FROM asistencia_docente WHERE detalle_jornada_id = '$id_detalle' AND fecha = '$fecha_anterior' and docente_id='$agente_id'";
  return mysqli_num_rows(mysqli_query($conexion, $query_asistencia)) == 0;
}

function get_exp_num_rows($conexion,$persona,$fecha_anterior,$tipo_agente){
  $query_expediente = "SELECT *FROM expediente WHERE persona_id='$persona' and fecha_inicio <= '$fecha_anterior' and fecha_fin >= '$fecha_anterior'";
  return mysqli_num_rows(mysqli_query($conexion, $query_expediente)) == 0;
}

function get_inasistencias_num_rows($conexion,$agente_id,$hora_inicio,$fecha_anterior,$hora_fin,$tipo_agente){
  $query_inasistencia = "SELECT * FROM inasistencia_sin_aviso_docente WHERE 
  fecha='$fecha_anterior' AND docente_id='$agente_id' AND hora_inicio='$hora_inicio' AND hora_fin='$hora_fin'";
  return mysqli_num_rows(mysqli_query($conexion, $query_inasistencia)) == 0;
}


