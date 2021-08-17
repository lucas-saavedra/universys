<?php
    require '../includes/db.php';

    if(isset($_POST['id_no_docente'])){
        $id = $_POST['id_no_docente'];

        $query = "DELETE FROM inasistencia_sin_aviso_no_docente WHERE id = '$id'";
        $result = mysqli_query($conexion,$query);
        if (!$result) {
            die("fallo el delete from");
        }else{
            //hacer con tutorial de plazy
            echo ("inasistencia eliminada");
        }
        

    };
    if(isset($_POST['id_docente'])){
        $id = $_POST['id_docente'];

        $query = "DELETE FROM inasistencia_sin_aviso_docente WHERE id = '$id'";
        $result = mysqli_query($conexion,$query);
        if (!$result) {
            die("fallo el delete from");
        }else{
            //igual
            echo ("inasistencia eliminada");
        }
    }


?> 