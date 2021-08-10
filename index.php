<?php include('includes/header.php'); ?>

<div id="sidebar-container" class="bg-primary">
    <div class="logo">
        <h4 class="text-light p-3">UNIVERSYS</h4>
        <?php
        session_start();
        $agente = $_SESSION['agente'];
        $agente_id = $_SESSION['agente_id'];
        $agente_rol =  $_SESSION['agente_rol'];
        echo "<h5 class='ml-3'> $agente </h5>";
        ?>

        <h4 class="text-light p-3"><?php echo $_SESSION['agente_rol']; ?></h4>
        <h4 class="text-light p-3">Hoy es <?php echo fechaArgentina() ?></h4>
    </div>

</div>
<?php
$Object = new DateTime();
$DateAndTime = $Object->format("h:i:s a");
$fecha = date("Y-n-j");
$sol = (strtotime($fecha));
?>

<?php
$query_docente = "SELECT * FROM docente WHERE persona_id='$persona_id'";
$result_docente = mysqli_query($conexion, $query_docente);
$docente = mysqli_fetch_array($result_docente);
if (mysqli_num_rows($result_docente) == 0) {
} else {
?>
    <div class="row">
        <div class="col">
            <form action="backend/registrar-asistencia.php" method="POST">
                <button class="btn btn-danger" type="submit">Registrar asistencia docente</button>
                <input type="hidden" id="time" name="appt" value="<?= $DateAndTime ?>"></label>
                <input type="hidden" name="fecha" value="<?= $sol ?>"></label>
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
            <form action="expediente/registrar-asistencia_no_docente.php" method="POST">
                <button class="btn btn-danger" type="submit">Registrar asistencia no docente</button>
                <input type="hidden" id="time" name="appt" value="<?= $DateAndTime ?>"></label>
                <input type="hidden" name="fecha" value="<?= $sol ?>"></label>
            </form>
        </div>
    </div>
<?php } ?>

<?php include('includes/footer.php'); ?>