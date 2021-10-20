<?php include("navbar.php");


if (
  !$es_coord && !$es_admin &&
  !$es_alumn && !$es_director && !$es_personal
) {
  header("Location: ../index.php ");
}


$agente = $_SESSION['agente'];

?>

<div class="jumbotron jumbotron-fluid p-0 pt-3">

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <h1 class="py-3 ">¡Bienvenid@! <?php echo $agente ?> </h1>

        <div class="row">
          <div class="dropdown ">
            <a class="btn btn-secondary ml-1 py-2 mb-0 btn-lg dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Seleccione el tipo de agente
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <a class="dropdown-item" href="agente.php?tipo_agente=<?php echo 'docente' ?>">Docente</a>
              <a class="dropdown-item" href="agente.php?tipo_agente=<?php echo 'no_docente' ?>">No Docente</a>
            </div>
          </div>
          <div class="mb-0 col-md-6 d-flex py-2 align-items-center">
            <h5 class="h5">Tipo de agente seleccionado: <?php echo $tipo_agente == 'docente' ?  'Docente' : 'No Docente' ?> </h5>
          </div>
        </div>


      </div>
    </div>
    <hr class="my-4">
    <div class="row d-flex justify-content-around">


      <div class="text-center" style="width: 10rem;">
        <div class="card-body">
          <h5 class="card-title">Jornadas</h5>
          <button type="button" class="btn jornadaModal" data-toggle="modal" data-target="#modal_jornadas"><i class="fas fa-calendar-alt fa-5x"></i></button>
        </div>
      </div>
      <div class=" text-center" style="width: 10rem;">
        <div class="card-body">
          <h5 class="card-title">Horarios</h5>
          <button type="button" class="btn horarioModal" data-toggle="modal" data-target="#modal_horarios"><i class="fas fa-clock fa-5x"></i></a></button>
        </div>
      </div>
      <?php if ($tipo_agente == 'docente') { ?>
        <div class=" text-center" style="width:10rem;">
          <div class="card-body">
            <h5 class="card-title">Mesa de Examen</h5>
            <button class="btn" type="submit"> <a class="btn" href="mesa.php?tipo_agente=<?php echo $tipo_agente ?>"><i class="fas fa-users-class fa-5x"></i></a></button>
          </div>
        </div>
      <?php } ?>


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
  <div class="modal-dialog modal-xl modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="modal_jornadas">Jornada Agente <?php echo $tipo_agente== 'docente' ?'Docente':'No Docente' ?> </h5>

      </div>
      <div class="modal-body">
        <?php include("jornada.php");  ?>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal_horarios" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-lg modal-dialog-scrollable">
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


<div class="modal fade" id="modal_horarios_one" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="text-center">Detalle de la jornada</h5>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="horarios_one">
          <div class="form-row justify-content-center">
            <div class="form-group col-md-4">
              <label for="">Seleccione el dia</label>
              <select class="form-control" id="dia_id" required>
                <option selected value="" disabled>Elija un dia</option>
                <?php foreach (get_dia($conexion) as $dia) : ?>
                  <option value="<?= $dia['id'] ?>">
                    <?= "{$dia['nombre']}" ?>
                  </option>
                <?php endforeach; ?>
              </select>

            </div>
            <input type="hidden" id="horario_id">
            <div class="form-group col-md-4">
              <label for="hora_inicio">Inicio</label>
              <input type="time" class="form-control timepicker" step="1800" id="hora_inicio">
            </div>
            <div class="form-group col-md-4">
              <label for="hora_fin">Fin</label>
              <input type="time" class="form-control timepicker" step="1800" id="hora_fin">
            </div>
          </div>

          <div class="form-row justify-content-center">
            <div class="form-group col-md-6">
              <button type="submit" class="btn btn-primary btn-lg btn-block" name="enviar">Aceptar</button>
            </div>
            <div class="form-group col-md-6">
              <button type="reset" data-dismiss="modal" class="btn btn-secondary btn-lg btn-block reset">Cancelar</button>
            </div>
          </div>
        </form>
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