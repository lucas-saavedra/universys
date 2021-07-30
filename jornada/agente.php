<?php include("header.php"); ?>
<?php  ?>
<?php if (isset($_GET['tipo_agente'])) {
  $_SESSION['tipo_agente'] =  $_GET['tipo_agente'];
}
?>

<div class="jumbotron jumbotron-fluid">
  <div class="container-fluid">
    <h1 class="display-4">¡Bienvenido! AGENTE_NOMBRE</h1>
    <p class="lead">Seleccionado: <?php echo $_SESSION['tipo_agente'] ?> </p>
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
        <div class="card text-center" style="width: 15rem;">
          <div class="card-body">
            <h5 class="card-title">Mesa de Examen</h5>
            <button class="btn" type="submit"> <a href="mesa.php"><i class="fas fa-user fa-7x"></i></i></a></button>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col">
      <?php include("includes/listar_jornadas.php"); ?>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade " id="modal_jornadas" tabindex="-1" aria-labelledby="modal_jornadas" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="modal_jornadas">Jornada Agente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php include("horario.php");  ?>
      </div>
     
    </div>
  </div>
</div>





<?php include("footer.html") ?>