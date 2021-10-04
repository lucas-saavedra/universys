

  <?php
    include('../includes/db.php');

    $json = array();
    $horario_id = $_POST['horario_id'];
    $sql = "SELECT * FROM `jornada_docente_mesa` WHERE jornada_docente_mesa.det_jornada_id = '$horario_id'";

    $result = mysqli_query($conexion, $sql);
    if (!$result) {
        die('Falló');
    }
    $jsonstring = json_encode(mysqli_fetch_array($result));
    echo $jsonstring;
