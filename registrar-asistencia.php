<?php 
require 'database.php';
session_start();

$usuario_id = $_SESSION['usuario_id'];

echo date('d-m-Y');

// $q = "select id from docentes where usuario_id = '$usuario_id'";

// $consulta = mysqli_query($conexion,$q);
// $array = mysqli_fetch_assoc($consulta);

// $q = "INSERT into marcacion(fecha,hora_inicio,hola_fin,docente_id) VALUES ('2021-04-20', '10:15:00', '10:30:00', 3)"

// if(mysqli_num_rows($consulta) > 0){
//     $_SESSION['username']= $usuario;
//     $_SESSION['usuario_id']= $array['id'];
//     header("location: index.php");
// }else{
//     echo 'Datos incorrectos';
// }