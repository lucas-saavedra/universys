<?PHP
  include('db.php');
   function get_agentes($conexion,$tipo_agente) 
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

  function get_tipo_jornadas($conexion,$tipo_agente)
  {
    $sql = "SELECT * FROM tipo_jornada WHERE pertenece = '$tipo_agente'";
    $result = mysqli_query($conexion, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
  }
function get_jornada_docentes($conexion){
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
  LEFT OUTER JOIN v_jornada as j on jd.jornada_id=j.id ";
   $result = mysqli_query($conexion, $sql);
   return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>
