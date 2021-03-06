<?php
include("navbar.php");

if (!isset($_SESSION['agente'])) {
    header("Location: ../index.php ");
}
$persona_id = $_SESSION['agente_id'];
?>

<?php

$day = array('', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');

setlocale(LC_ALL, "spanish");

$Object = new DateTime();
$DateAndTime = $Object->format("h:i:s a");
$fecha = date("Y-n-j");
$fecha_string = (strtotime($fecha));
$hoy = new DateTime();
?>

<div class="jumbotron jumbotron-fluid">
    <div class="container-fluid">
        <h1 class="h-4">¡Bienvenid@! <?php echo $agente ?> </h1>
        <h3><i class="fas fa-calendar"></i>
            <?php
            echo $day[strftime("%w")] . ' ' . strftime("%d de %B de %Y") . '<br/>'; ?> </h3>
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
            $result_jornadas_mesa = get_jornadasmesa_docentes_hoy($conexion, $array_id['id'], '');
            if (mysqli_num_rows($result_jornadas_mesa) !== 0 || mysqli_num_rows($result_jornadas) !== 0 || hay_mesa_hoy($conexion)) {
        ?>
                <div class="card">
                    <div class="card-header text-center">Docente<form action="../backend/registrar-asistencia.php" method="POST" class="py-3">
                            <button class="btn btn-primary geoButton" type="submit">Registrar asistencia</button>
                            <div class="alert alert-warning geoWarning my-3" hidden role="alert">
                                <i class="fas fa-map-marker-alt fa-2x"></i>
                                <div id="geoWarning">
                                    ¡No puede registrar la asistencia si se encuentra fuera de la facultad!
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <?PHP

                        if (hay_mesa_hoy($conexion)) { ?>
                            <div class="table-responsive rounded">
                                <table class="table table-sm">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Inicio</th>
                                            <th scope="col">Fin</th>
                                            <th scope="col">Area</th>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $result_jornadas_mesa_hoy = get_jornadasmesa_docentes_hoy($conexion, $array_id['id'], ' and detalle_jornada.dia = (select weekday(now()))');
                                        if (mysqli_num_rows($result_jornadas_mesa_hoy) !== 0) {
                                            while ($row_jornadas = mysqli_fetch_array($result_jornadas_mesa_hoy)) {
                                                $fecha_inicio = $row_jornadas['fecha_inicio'];
                                                $fecha_fin    = $row_jornadas['fecha_fin'];
                                                if (strtotime($fecha_inicio) <= strtotime($fecha) and strtotime($fecha_fin) >= strtotime($fecha)) {
                                        ?>
                                                    <tr>
                                                        <td> <?php echo date("H:i", strtotime($row_jornadas['hora_inicio'])) . ' hs' ?> </td>
                                                        <td> <?php echo date("H:i", strtotime($row_jornadas['hora_fin'])) . ' hs' ?> </td>
                                                        <td> <?php echo $row_jornadas['carrera_nombre'] ?></td>
                                                        <td> <?php echo '<span class="badge badge-primary">Mesa de examen</span>' ?></td>
                                                        <td> <?php echo '<span class="badge badge-success">Activa</span>' ?></td>

                                                    </tr>
                                                <?php   }  ?>
                                            <?php  } ?>
                                        <?php  } else { ?>
                                            <td colspan="4"> <?php echo '<span class="">Mesa de examen activa, no tiene jornadas para hoy.</span>' ?></td>
                                            <td> <?php echo '<span class="badge badge-success">Activa</span>' ?></td>

                                        <?php  } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                        <?PHP if (mysqli_num_rows($result_jornadas) !== 0) { ?>
                            <div class="table-responsive rounded">
                                <table class="table table-sm">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Inicio</th>
                                            <th scope="col">Fin</th>
                                            <th scope="col">Area</th>
                                            <th scope="col">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php



                                        while ($row_jornadas = mysqli_fetch_array($result_jornadas)) {
                                            $fecha_inicio = $row_jornadas['fecha_inicio'];
                                            $fecha_fin    = $row_jornadas['fecha_fin'];
                                            if (strtotime($fecha_inicio) <= strtotime($fecha) and strtotime($fecha_fin) >= strtotime($fecha)) {
                                        ?>
                                                <tr>
                                                    <td> <?php echo date("H:i", strtotime($row_jornadas['hora_inicio'])) . ' hs' ?> </td>
                                                    <td> <?php echo date("H:i", strtotime($row_jornadas['hora_fin'])) . ' hs' ?> </td>
                                                    <td> <?php echo $row_jornadas['catedra'] ?> | <?php echo $row_jornadas['carrera'] ?> </td>
                                                    <td> <?php $Object = new DateTime();
                                                            $hora_actual = $Object->format("H:i");

                                                            if (hay_mesa_hoy($conexion)) {
                                                                $estado = 'Inactiva';
                                                                $tipo_estado = 'secondary';
                                                            } else {

                                                                if (strtotime($row_jornadas['hora_inicio']) < strtotime($hora_actual) and strtotime($row_jornadas['hora_fin']) > strtotime($hora_actual)) {
                                                                    $estado = 'Activa';
                                                                    $tipo_estado = 'success';
                                                                } else {
                                                                    $estado = 'Inactiva';
                                                                    $tipo_estado = 'secondary';
                                                                }
                                                            }

                                                            echo '<span class="badge badge-' . $tipo_estado . '">' . $estado . '</span>' ?></td>

                                                </tr>
                                            <?php  } ?>
                                        <?php  } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
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
$query_no_docente = "SELECT * FROM no_docente WHERE persona_id='$persona_id'";
$result_no_docente = mysqli_query($conexion, $query_no_docente);
if (mysqli_num_rows($result_no_docente) !== 0) {
    echo '<div class="col-md-6">';
    $array_id = mysqli_fetch_assoc($result_no_docente);
    $result_jornadas = get_jornadas_no_docentes_hoy($conexion, $array_id['id']);
    if (mysqli_num_rows($result_jornadas) !== 0) {


?>
        <div class="card">
            <div class="card-header text-center">No docente <form action="../expediente/registrar-asistencia_no_docente.php" method="POST" class="py-3">
                    <button class="btn btn-primary geoButton" type="submit">Registrar asistencia</button>
                    <div class="alert alert-warning geoWarning my-3" hidden role="alert">
                        <i class="fas fa-map-marker-alt fa-2x"></i>
                        <div id="geoWarning">
                            ¡No puede registrar la asistencia si se encuentra fuera de la facultad!
                        </div>
                    </div>
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
                                <th scope="col">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row_jornadas = mysqli_fetch_array($result_jornadas)) {
                                $fecha_inicio = $row_jornadas['fecha_inicio'];
                                $fecha_fin    = $row_jornadas['fecha_fin'];

                                if (strtotime($fecha_inicio) <= strtotime($fecha) and strtotime($fecha_fin) >= strtotime($fecha)) {

                            ?>
                                    <tr>
                                        <td> <?php echo date("H:i", strtotime($row_jornadas['hora_inicio'])) . ' hs' ?> </td>
                                        <td> <?php echo date("H:i", strtotime($row_jornadas['hora_fin'])) . ' hs' ?> </td>
                                        <td> <?php echo $row_jornadas['area'] ?></td>
                                        <td> <?php $Object = new DateTime();
                                                $hora_actual = $Object->format("H:i");
                                                if (strtotime($row_jornadas['hora_inicio']) <= strtotime($hora_actual) and strtotime($row_jornadas['hora_fin']) >= strtotime($hora_actual)) {
                                                    $estado = 'Activa';
                                                    $tipo_estado = 'success';
                                                } else {
                                                    $estado = 'Inactiva';
                                                    $tipo_estado = 'secondary';
                                                }
                                                echo '<span class="badge badge-' . $tipo_estado . '">' . $estado . '</span>' ?></td>
                                    </tr>

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
<script src="js/geoLocation.js"></script>