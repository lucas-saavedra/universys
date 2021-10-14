<input type="hidden" id="jornadaId">
<div class="card">
    <div class="card-header">
        <h5 class="card-title text-center">Filtros de busqueda</h5>
    </div>
    <div class="card-body">

        <form action="" method="POST" id="filtroJornada">

            <div class="form-row col-md-12 d-flex justify-content-center">
                <div class="form-group col-md-3">
                    <label for="fecha_inicio">Inicio</label>
                    <input required type="date" class="form-control" id="filtroFechaInicio">
                </div>
                <div class="form-group col-md-3">
                    <label for="fecha_fin">Fin</label>
                    <input required type="date" class="form-control " id="filtroFechaFin">
                </div>

                <?php if ($tipo_agente == 'docente') { ?>
                    <div class="form-group col-md-2">
                        <label class="mx-2" for="">Carerra</label>
                        <select class="form-control" id="filtroCarreraId">
                            <option selected value="">Todas</option>
                            <?php foreach (get_carreras($conexion) as $e) : ?>
                                <option value="<?= $e['id'] ?>">
                                    <?= "{$e['nombre']}" ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="">Año académico</label>
                        <select class="form-control" id="filtroAnioId">
                            <option selected value="">Todos</option>
                            <?php foreach (get_anios($conexion) as $anio) : ?>
                                <option value="<?= $anio['id'] ?>">
                                    <?= "{$anio['nombre']}" ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php } else { ?>

                    <div class="form-group col-md-2">
                        <label for="">Area</label>
                        <select class="form-control" id="filtroAreaId" required>
                            <option selected value="">Todas</option>
                            <?php foreach (get_areas($conexion) as $areas) : ?>
                                <option value="<?= $areas['id'] ?>">
                                    <?= "{$areas['nombre']}" ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                <?php }  ?>


                <div class="form-group col-md-2">
                    <label for="">Tipo de jornada</label>
                    <select class="form-control" id="filtroTipoJornadaId">
                        <option selected value="">Todos</option>
                        <?php foreach (get_tipo_jornadas($conexion, $tipo_agente) as $tipo_jornadas) : ?>
                            <option value="<?= $tipo_jornadas['id'] ?>">
                                <?= "{$tipo_jornadas['nombre']}" ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <div class="form-row col-md-12 d-flex justify-content-center">
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
                    </div>
                    <div class="col-md-1">
                        <button type="reset" class="filtro_reset btn btn-secondary  btn-block"><i class="fas fa-sync-alt"></i></button>
                    </div>
                    <div class="col-md-4">
                        <a href="./backend/exportar_horarios.php" class=" btn btn-success  btn-block">
                             <i class="fas fa-download"></i> Descargar horarios
                        </a>
                    </div>
                </div>


            </div>

        </form>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h4 class="text-center">Jornadas agregadas</h4>
    </div>
    <div class="card-body mx-0">
        <div class="table-responsive rounded">
            <table class="table table-sm">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Nº</th>
                        <?php if ($tipo_agente == 'docente') { ?>
                            <th scope="col">Docente</th>
                            <th scope="col">Catedra</th>
                        <?php } else { ?>
                            <th scope="col">Agente</th>
                            <th scope="col">Area</th>

                        <?php }  ?>

                        <th scope="col">Inicio</th>
                        <th scope="col">Fin</th>
                        <th scope="col">Jornada</th>
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

<div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo_modal"> Detalle de la jornada</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table ">
                    <thead class="thead-dark rounded">
                        <tr>
                            <th scope="col">Dia</th>
                            <th scope="col">Inicio</th>
                            <th scope="col">Fin</th>
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