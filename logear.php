<?php
require 'database.php';
session_start();

$usuario = $_POST['usuario'];
$clave = $_POST['clave'];

$q = "select id from usuarios where email = '$usuario' and contrasenia = '$clave'";
$consulta = mysqli_query($conexion,$q);
$array = mysqli_fetch_assoc($consulta);


if(mysqli_num_rows($consulta) > 0){
    $_SESSION['username']= $usuario;
    $_SESSION['usuario_id']= $array['id'];
    header("location: index.php");
}else{
    echo 'Datos incorrectos';
}