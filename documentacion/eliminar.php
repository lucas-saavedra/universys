<?php 

include "../includes/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) header("Location:index.php");

$result = mysqli_query($conexion, "DELETE FROM documentacion_justificada WHERE id={$_POST['id']}");

if ($result) header("Location:index.php");

exit(mysqli_error($conexion));

?>