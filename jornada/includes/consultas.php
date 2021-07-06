<?PHP
  include('db.php');
function get_docentes($conexion){
    $sql = "SELECT docente.id,nombre FROM docente left join persona on docente.id = persona.id";
    $result = mysqli_query($conexion, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
function get_agentes($conexion){
  $sql = "SELECT no_docente.id,nombre FROM no_docente left join persona on no_docente.id = persona.id";
  $result = mysqli_query($conexion, $sql);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
function get_areas($conexion){
  $sql = "SELECT * FROM area";
  $result = mysqli_query($conexion, $sql);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_tipo_jornadas_docentes($conexion){
  $sql = "SELECT * FROM tipo_jornada WHERE pertenece = 'docente'";
  $result = mysqli_query($conexion, $sql);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_tipo_jornadas($conexion){
  $sql = "SELECT * FROM tipo_jornada WHERE pertenece = 'no_docente'";
  $result = mysqli_query($conexion, $sql);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}



?>