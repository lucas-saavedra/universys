<?php 
include('db.php');

  $fecha_inicio =  $_POST["inicio"]; 
  $fecha_fin = $_POST["fin"]; 
  $_POST["tipo"]; 
  $descripcion = $_POST["detalle"]; 
 

$query="INSERT INTO jornada ( fecha_inicio, fecha_fin, tipo_jornada_id, descripcion)
VALUES ( '$fecha_inicio', '$fecha_fin', '1', '$descripcion')";

if (mysqli_query($conexion, $query)) {
  $_SESSION['message']="Jornada creada satisfactoriamente";
  $_SESSION['message_type']="success";
} else {
  echo "Error: " . $query . "<br>" . mysqli_error($conexion);
}

  

header("Location: ../crear-jornada-docente.php")
?>