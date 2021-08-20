<?php
include("navbar.php");


if (!isset($_SESSION['agente'])) {
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
        <h1 class="h-4">¡Bienvenid@! <?php echo $agente ?> </h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <?php
        $query_docente = "SELECT * FROM docente WHERE persona_id='$persona_id'";
        $result_docente = mysqli_query($conexion, $query_docente);
        if (mysqli_num_rows($result_docente) !== 0) {
            echo '<div class="col-md-6">';
            $array_id = mysqli_fetch_assoc($result_docente);
            $result_jornadas = get_jornadas_docentes_hoy($conexion, $array_id['id']);
            if (mysqli_num_rows($result_jornadas) !== 0) {
        ?>
                <div class="card">
                    <div class="card-header text-center">Docente<form action="../backend/registrar-asistencia.php" method="POST" class="py-3">
                            <button class="btn btn-primary" type="submit">Registrar asistencia</button>
                            <input type="hidden" id="time" name="tiempo" value="<?= $DateAndTime ?>"></label>
                            <input type="hidden" name="fecha" value="<?= $fecha_string ?>"></label>
                        </form>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive rounded">
                            <table class="table table-sm">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Inicio</th>
                                        <th scope="col">Fin</th>
                                        <th scope="col">Area</th>
                                    </tr>
                                </thead>
                                <tbody id="listar_jornadas">
                                    <?php

                                    while ($row_jornadas = mysqli_fetch_array($result_jornadas)) {
                                        $fecha_inicio = $row_jornadas['fecha_inicio'];
                                        $fecha_fin    = $row_jornadas['fecha_fin'];
                                        if (strtotime($fecha_inicio) < strtotime($fecha) and strtotime($fecha_fin) > strtotime($fecha)) {
                                    ?>
                                            <tr>
                                                <td> <?php echo date("H:i", strtotime($row_jornadas['hora_inicio'])) . ' hs' ?> </td>
                                                <td> <?php echo date("H:i", strtotime($row_jornadas['hora_fin'])) . ' hs' ?> </td>
                                                <td> <?php echo $row_jornadas['catedra'] ?> | <?php echo $row_jornadas['carrera'] ?> </td>
                                            </tr>
                                        <?php  } ?>
                                    <?php  } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } else {
                echo '<div class="alert alert-primary" role="alert">
                        ¡No tiene jornadas como docente para hoy!
                        </div>';
            } ?>
                 </div>
     <?php    } ?>


        <?php
        $query_no_docente = "SELECT *FROM no_docente WHERE persona_id='$persona_id'";
        $result_no_docente = mysqli_query($conexion, $query_no_docente);
        if (mysqli_num_rows($result_no_docente) !== 0) {
            echo '<div class="col-md-6">';
            $array_id = mysqli_fetch_assoc($result_no_docente);
            $result_jornadas = get_jornadas_no_docentes_hoy($conexion, $array_id['id']);
            if (mysqli_num_rows($result_jornadas) !== 0) {

        ?>
                <div class="card">
                    <div class="card-header text-center">No docente <form action="../expediente/registrar-asistencia_no_docente.php" method="POST" class="py-3">
                            <button class="btn btn-primary" type="submit">Registrar asistencia</button>
                            <input type="hidden" id="time" name="tiempo" value="<?= $DateAndTime ?>"></label>
                            <input type="hidden" name="fecha" value="<?= $fecha_string ?>"></label>
                        </form>
                    </div>
                    <div class="card-body">

                        <?php

                        if (mysqli_num_rows($result_jornadas) !== 0) {

                        ?>

                            <div class="table-responsive rounded">
                                <table class="table table-sm">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Inicio</th>
                                            <th scope="col">Fin</th>
                                            <th scope="col">Area</th>
                                        </tr>
                                    </thead>
                                    <tbody id="listar_jornadas">
                                        <?php


                                        while ($row_jornadas = mysqli_fetch_array($result_jornadas)) {
                                            $fecha_inicio = $row_jornadas['fecha_inicio'];
                                            $fecha_fin    = $row_jornadas['fecha_fin'];

                                            if (strtotime($fecha_inicio) < strtotime($fecha) and strtotime($fecha_fin) > strtotime($fecha)) {

                                        ?>
                                                <tr>
                                                    <td> <?php echo date("H:i", strtotime($row_jornadas['hora_inicio'])) . ' hs' ?> </td>
                                                    <td> <?php echo date("H:i", strtotime($row_jornadas['hora_fin'])) . ' hs' ?> </td>
                                                    <td> <?php echo $row_jornadas['area'] ?></td>
                                                </tr>

                                            <?php  } ?>
                                        <?php  } ?>
                                    <?php  } ?>

                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
            <?php } else {
                echo '
                <div class="alert alert-primary" role="alert">
                ¡No tiene jornadas como no docente para hoy!
                </div>
                ';
            } ?>
        <?php echo '</div>';
        }  ?>

    </div>
</div>

<?php include("../includes/footer.php") ?>