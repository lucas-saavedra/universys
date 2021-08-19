<?php include("navbar.php");
if (!isset($_SESSION['agente'])) {
  header("Location: ../index.php ");
}
$agente = $_SESSION['agente'];
?>

<div class="jumbotron jumbotron-fluid">

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <h1 class="display-4">¡Bienvenido! <?php echo $agente ?> </h1>
        <h3 class="display-6">Tipo de agente seleccionado: <?php echo $tipo_agente == 'docente' ?  'Docente' : 'No Docente' ?> </h3>
        <div class="dropdown">
          <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Tipo de agente
          </a>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="agente.php?tipo_agente=<?php echo 'docente' ?>">Docente</a>
            <a class="dropdown-item" href="agente.php?tipo_agente=<?php echo 'no_docente' ?>">No Docente</a>
          </div>
        </div>
      </div>
     <!--  <div class="col-md-6">
        <div class="col-md-12">
          <form action="" method="POST" id="filtroJornada">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="fecha_inicio">Inicio del ciclo lectivo</label>
                <input required type="date" class="form-control" id="filtroFechaInicio">
              </div>
              <div class="form-group col-md-6">
                <label for="fecha_fin">Inicio del ciclo lectivo</label>
                <input required type="date" class="form-control " id="filtroFechaFin">
              </div>
              <div class="form-group col-md-6">
                <label for="fecha_inicio">Fin del 1er cuatrimestre</label>
                <input required type="date" class="form-control" id="filtroFechaInicio">
              </div>
              <div class="form-group col-md-6">
                <label for="fecha_fin">Inicio del 2er cuatrimestre</label>
                <input required type="date" class="form-control " id="filtroFechaFin">
              </div>
                <div class="form-group col-md-3 ">
                  <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
                </div>
                <div class="form-group col-md-3 ">
                  <button type="reset" class="filtro_reset btn btn-secondary  btn-block"><i class="fas fa-sync-alt"></i></button>
                </div>
            </div>

          </form>

        </div>
      </div> -->
    </div>
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
              <button class="btn" type="submit"> <a class="btn" href="mesa.php?tipo_agente=<?php echo $tipo_agente ?>"><i class="fas fa-user fa-7x"></i></a></button>
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
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
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



<!-- <button type="button" class="btn horarioModal" data-toggle="modal" data-target="#modal_fechas">Set</a></button>


<div class="modal fade" id="modal_fechas" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class=" text-center">Defina las fechas de inicio y fin</h5>
      </div>
      <div class="modal-body">

      </div>
    </div>
  </div>
</div> -->




<?php include("footer.php") ?>