<?php
require '../includes/db.php';
session_start();
$usuario = $_POST['usuario'];
$clave = $_POST['clave'];
$query_persona = "SELECT *from persona where email = '$usuario' and contrasenia = '$clave'";
$result_persona = mysqli_query($conexion,$query_persona);
$persona = mysqli_fetch_assoc($result_persona);
$id_agente=$persona['id'];
$sql = "select id FROM jornada_no_docente WHERE jornada_no_docente.no_docente_id = 
(SELECT id from no_docente where no_docente.persona_id = '$id_agente') and jornada_no_docente.area_id = 1";
$result=mysqli_query($conexion,$sql);

if(mysqli_num_rows($result_persona) > 0){
    if(mysqli_num_rows($result) > 0){
        $_SESSION['agente_rol']= 'personal';
    }else{
        $_SESSION['agente_rol']= '';
    }
    $_SESSION['agente']= $persona['nombre'];
    $_SESSION['agente_id']= $persona['id'];
    header("location: ../jornada");
}else{
    echo 'Datos incorrectos';
}