<?php
require 'database.php';
session_start();

$usuario = $_POST['usuario'];
$clave = $_POST['clave'];

$query_persona = "SELECT *from persona where email = '$usuario' and contrasenia = '$clave'";
$result_persona = mysqli_query($conexion,$query_persona);
$persona = mysqli_fetch_assoc($result_persona);


if(mysqli_num_rows($result_persona) > 0){
    $_SESSION['username']= $persona['nombre'];
    $_SESSION['usuario_id']= $persona['id'];
    header("location: index.php");
}else{
    echo 'Datos incorrectos';
}