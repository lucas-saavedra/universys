<?php 
include("navbar.php");

 if (!isset($_SESSION['agente'])){
    header("Location: ../index.php ");
  } 
$persona_id = $_SESSION['agente_id'];
?>

<?php
$Object = new DateTime();
$DateAndTime = $Object->format("h:i:s a");
$fecha = date("Y-n-j");
$fecha_string = (strtotime($fecha));
?>

<div class="jumbotron jumbotron-fluid">
    <div class="container-fluid">
        <h1 class="h-3">¡Bienvenid@! <?php echo $agente ?> </h1>
        <?php if ($es_personal) { ?>
        <p class="lead">Seleccione el tipo de agente con el que desea trabajar.</p>
        <?php } ?>
        <hr class="my-4">
        <div class="row d-flex justify-content-center">
            <div class="card-deck">
                <div class="card text-center">
                    <div class="card-body" style="width: 14rem; display: flex; align-items:center; justify-content:center">
                        <div>
                            <h5 class="card-title">Asistencia</h5>
                            <?php

                            $query_docente = "SELECT * FROM docente WHERE persona_id='$persona_id'";
                            $result_docente = mysqli_query($conexion, $query_docente);
                            $docente = mysqli_fetch_array($result_docente);
                            if (mysqli_num_rows($result_docente) == 0) {
                                echo "<h5 class='ml-3'>  $persona_id </h5>";
                            } else {
                            ?>
                                <div class="row">
                                    <div class="col">
                                        <form action="../backend/registrar-asistencia.php" method="POST">
                                            <button class="btn btn-primary btn-block" type="submit">Docente</button>
                                            <input type="hidden" id="time" name="tiempo" value="<?= $DateAndTime ?>"></label>
                                            <input type="hidden" name="fecha" value="<?= $fecha_string ?>"></label>
                                        </form>
                                    </div>
                                </div>
                            <?php } ?>


                            <?php
                                $query_no_docente = "SELECT *FROM no_docente WHERE persona_id='$persona_id'";
                                $result_no_docente = mysqli_query($conexion, $query_no_docente);
                                $no_docente = mysqli_fetch_array($result_no_docente);
                                if (mysqli_num_rows($result_no_docente) == 0) {
                                } else {
                                ?>
                                <div class="row">
                                    <div class="col">
                                        <form action="../expediente/registrar-asistencia_no_docente.php" method="POST">
                                            <button class="btn btn-primary btn-block" type="submit">No Docente</button>
                                            <input type="hidden" id="time" name="tiempo" value="<?= $DateAndTime ?>"></label>
                                            <input type="hidden" name="fecha" value="<?= $fecha_string ?>"></label>
                                        </form>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include("../includes/footer.php") ?>