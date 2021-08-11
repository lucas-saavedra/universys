<?php include("navbar.php");
if (!isset($_SESSION['agente'])){
  header("Location: ../index.php ");
}
$agente = $_SESSION['agente'];
?>

<div class="jumbotron jumbotron-fluid">
  <div class="container-fluid">

    <h1 class="display-4">¡Bienvenido! <?php  echo $agente ?> </h1>
    <h3 class="display-6">Tipo de agente seleccionado: <?php echo $tipo_agente ?> </h3>

    <hr class="my-4">
    <div class="row d-flex justify-content-center">

      <div class="card-deck">
        <div class="card text-center" style="width: 15rem;">
          <div class="card-body">
            <h5 class="card-title">Jornadas</h5>
            <button type="button" class="btn jornadaModal" data-toggle="modal" data-target="#modal_jornadas"><i class="fas fa-calendar-alt fa-7x"></i></button>
          </div>
        </div>
        <div class="card text-center" style="width: 15rem;">
          <div class="card-body">
            <h5 class="card-title">Horarios</h5>
            <button type="button" class="btn horarioModal" data-toggle="modal" data-target="#modal_horarios"><i class="fas fa-clock fa-7x"></i></a></button>
          </div>
        </div>
        <?php if ($tipo_agente == 'docente') { ?>
          <div class="card text-center" style="width: 15rem;">
            <div class="card-body">
              <h5 class="card-title">Mesa de Examen</h5>
              <button class="btn" type="submit"> <a href="mesa.php?tipo_agente=<?php echo $tipo_agente ?>"><i class="fas fa-user fa-7x"></i></a></button>
            </div>
          </div>
        <?php } ?>

      </div>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="col">
      <?php include("includes/listar_jornadas.php"); ?>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade " id="modal_jornadas" data-backdrop="static" tabindex="-1" aria-labelledby="modal_jornadas" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="modal_jornadas">Jornada Agente</h5>

      </div>
      <div class="modal-body">
        <?php include("jornada.php");  ?>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal_horarios" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="text-center">Detalle de la jornada</h5>
      </div>
      <div class="modal-body">
        <?php include("horario.php");  ?>
      </div>
    </div>
  </div>
</div>



<?php include("footer.php") ?>