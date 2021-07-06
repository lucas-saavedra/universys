<?php 
include('../includes/db.php');

if (isset($_POST['jornada_id'])){
$id=$_POST['jornada_id'];
$query="DELETE FROM jornada WHERE id = '$id' ";

if (mysqli_query($conexion, $query)) {
  $json = array();
  $json[0] = array(
    'message' => 'La jornada ha sido eliminada',
    'message-type' => 'danger'
  );
  $jsonstring = json_encode($json);
  echo $jsonstring; 
}
  
}
