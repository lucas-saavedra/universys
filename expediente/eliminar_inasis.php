<?php 
include "../includes/db.php";


if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id_docente'])) header("Location:crear-expediente-sin-aviso.php");
    
    $result = mysqli_query($conexion, "DELETE FROM inasistencia_sin_aviso_docente WHERE id={$_POST['id_docente']}");
        
    header("Location:crear-expediente-sin-aviso.php?del_expdte_id={$_POST['id_docente']}");
    
?>