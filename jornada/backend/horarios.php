  <?php
  include('../includes/db.php');

$json = array();
$jornada_id=$_POST['jornada_id'];

$sql = "SELECT detalle_jornada.jornada_id ,detalle_jornada.id as id, hora_inicio,hora_fin,dia.id as dia_id, dia.nombre,descripcion  
 from  detalle_jornada left join dia on detalle_jornada.dia = dia.id  where jornada_id ='$jornada_id' 
 ";

 if (isset($_POST['horario_id'])){
  $horario_id=$_POST['horario_id'];
  $sql= $sql. " and detalle_jornada.id = '$horario_id'";
 };

$sql = $sql . " order by detalle_jornada.dia";
  $result= mysqli_query($conexion, $sql);
    if(!$result){
      die('Falló');
    }
    while ($row = mysqli_fetch_array($result)) {
      $json[] = array(
        'id' => $row['id'],
        'nombre' => $row['nombre'],
        'jornada_id' => $row['jornada_id'],
        'dia_id' => $row['dia_id'],
        'hora_inicio' => $row['hora_inicio'],
        'hora_fin' => $row['hora_fin'],
        'descripcion' => $row['descripcion']
      );
    }
  $jsonstring = json_encode($json);
  echo $jsonstring;
  ?>