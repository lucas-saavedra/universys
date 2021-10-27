<?php include('db.php');  ?>
<input type="hidden" id="jornada_horarios">




<div class="row">
    <div class="col">
        <div class="card mb-2">
            <div class="card-header">
                <h5 class="card-title text-center">Filtros de busqueda</h5>
            </div>
            <div class="card-body">
                <form action="" method="POST" id="">

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="fecha_inicio">Incio de la jornada</label>
                            <input required type="date" class="form-control" id="filtroFechaInicio" name="filtroFechaInicio">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="fecha_fin">Fin de la jornada</label>
                            <input required type="date" class="form-control " id="filtroFechaFin" name="filtroFechaFin">
                        </div>

                        <div class="form-group col-md-2">
                            <label class="mx-2" for="">Carerra</label>
                            <select class="form-control" id="filtroCarreraId" name="filtroCarreraId">
                                <option selected value="">Todos</option>
                                <?php foreach (get_carreras($conexion) as $e) : ?>
                                    <option value="<?= $e['id'] ?>">
                                        <?= "{$e['nombre']}" ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Llamado</label>
                            <select class="form-control" id="filtroLlamadoId" name="filtroLlamadoId">
                                <option selected value="">Todos</option>
                                <?php foreach (get_llamado($conexion) as $e) : ?>
                                    <option value="<?= $e['id'] ?>">
                                        <?= "{$e['nombre']}" ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-1 d-flex align-items-end">
                            <button type="button" id="filtroJornadaMesa" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="form-group col-md-1 d-flex align-items-end">
                            <button type="reset" class="filtro_reset_mesa btn btn-secondary  btn-block"><i class="fas fa-sync-alt"></i></button>
                        </div>
                        <div class="form-group col-md-4 mx-auto d-flex align-items-end">
                            <button type="submit" formaction="../jornada/backend/exportar_horarios_mesa.php" method="POST" class=" btn btn-success  btn-block"><i class="fas fa-download"></i> Descargar horarios</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col">
        <div class="table-responsive rounded">
            <table class="table table-sm">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Carrera</th>
                        <th scope="col">Llamado</th>
                        <th scope="col">Fecha</th>
                        
                        <th scope="col">Descripcion</th>
                        <th scope="col">Acciones</th>
                    </tr>

                </thead>
                <tbody id="listar_jornadas_mesa">


                </tbody>
            </table>
        </div>
    </div>
</div>