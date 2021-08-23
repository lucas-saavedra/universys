
<?php 
    include "../includes/db.php";

    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) header("Location:index.php");

    
    $result = mysqli_query($conexion, "DELETE FROM expediente WHERE id={$_POST['id']}");
    
    session_start();
    if ($result){
        $_SESSION['elim_expdte_msg'] = ['content'=> "El expediente de ID {$_POST['id']} ha sido eliminado", 'type'=> 'success'];
    }
    else{
        $_SESSION['elim_expdte_msg'] = ['content'=> mysqli_error($conexion), 'type'=> 'danger'];
    }

    header("Location:index.php");

?>