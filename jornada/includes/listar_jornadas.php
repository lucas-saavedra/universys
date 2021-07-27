<?php $tipo_agente = $_SESSION['tipo_agente']; ?>
<input type="hidden" id="jornadaId">
<div class="container">
    <div class="row collapse show multi-collapse" id='toggle_jornadas'>
        <div class="col">
            <div class="card">
            <div class="card-header">
                   <!--  <h4 class="py-2 text-center">Jornadas agregadas</h4> -->
                    <h5 class="card-title text-center">Filtros de busqueda</h5>
                </div>
                <div class="card-body">
                   
                    <form action="" method="POST" id="filtroJornada">

                        <div class="form-row">


                            <div class="form-group col-md-3">
                                <label for="fecha_inicio">Fecha de incio de la jornada</label>
                                <input required type="date" class="form-control" id="filtroFechaInicio">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fecha_fin">Fecha de fin de la jornada</label>
                                <input required type="date" class="form-control " id="filtroFechaFin">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">Tipo de jornada</label>
                                <select class="form-control" id="filtroTipoJornadaId">
                                    <option selected value="" disabled>Todos</option>
                                    <?php foreach (get_tipo_jornadas($conexion, $tipo_agente) as $tipo_jornadas) : ?>
                                        <option value="<?= $tipo_jornadas['id'] ?>">
                                            <?= "{$tipo_jornadas['nombre']}" ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group col-md-1 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
                            </div>
                            <div class="form-group col-md-1 d-flex align-items-end">
                                <button type="reset" class="filtro_reset btn btn-secondary  btn-block"><i class="fas fa-sync-alt"></i></button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>


            <div class="custom-control custom-switch" style="height: 25px;">
                <div class="col-sm-10">
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <h4 class="text-center">Jornadas agregadas</h4>
                </div>
                <div class="card-body">

                    <div class="table-responsive table-borderless">
                        <table class="table table-sm">

                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Nº</th>
                                    <?php if ($tipo_agente == 'docente') { ?>
                                        <th scope="col">Docente</th>
                                        <th scope="col">Catedra</th>
                                    <?php } else { ?>
                                        <th scope="col">Agente</th>
                                        <th scope="col">Area</th>

                                    <?php }  ?>

                                    <th scope="col">Fecha de inicio</th>
                                    <th scope="col">Fecha de fin</th>
                                    <th scope="col">Tipo de jornada</th>
                                    <th scope="col">Descripcion</th>
                                    <th scope="col justify-content-between">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="listar_jornadas">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo_modal"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Dia</th>
                            <th scope="col">Hora Inicio</th>
                            <th scope="col">Hora FIn</th>
                            <th scope="col">Descripcion</th>
                        </tr>
                    </thead>
                    <tbody id="tabla_horarios">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>