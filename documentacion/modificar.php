<?php 

include "../includes/db.php";
include "../expediente/includes/validaciones.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) header("Location:index.php");

$sql = "UPDATE documentacion_justificada SET fecha_recepcion=?, descripcion=? WHERE id=?";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, 'ssd', $_POST['fecha_recepcion'], $_POST['descripcion'], $_POST['id']);
$result = mysqli_stmt_execute($stmt);

session_start();


if (!$result){
    $_SESSION['modif_doc_msg'] = ['content'=> mysqli_error($conexion), 'type'=> 'danger'];
}
else{
    if ($_POST['expdte_id'] != '') validar_documentacion($conexion, $_POST['expdte_id']);
    
    $_SESSION['modif_doc_msg'] = ['content'=> "Documentación actualizada!", 'type'=> 'success'];
}


header("Location:index.php");
?>