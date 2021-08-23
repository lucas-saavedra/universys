
<?php 
    include "../includes/db.php";

    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) header("Location:confirmar-p-productividad.php");

    $result = mysqli_query($conexion, "DELETE FROM expediente WHERE id={$_POST['id']}");

    header("Location:index.php?del_expdte_id={$_POST['id']}");

?>