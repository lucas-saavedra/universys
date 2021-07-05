<?PHP
  include('db.php');
function get_docentes($conexion){
    $sql = "SELECT docente.id,nombre FROM docente left join persona on docente.id = persona.id";
    $result = mysqli_query($conexion, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

?>