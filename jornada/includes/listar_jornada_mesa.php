<?php include('db.php');  ?>
<input type="hidden" id="jornada_horarios">




<div class="row">
    <div class="col">
        <div class="card mb-2">
            <div class="card-header">
                <h5 class="card-title text-center">Filtros de busqueda</h5>
            </div>
            <div class="card-body">
                <form action="" method="POST" id="filtroJornadaMesa">

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="fecha_inicio">Incio de la jornada</label>
                            <input required type="date" value='2021-07-01' class="form-control" id="filtroFechaInicio">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="fecha_fin">Fin de la jornada</label>
                            <input required type="date" value='2021-07-30' class="form-control " id="filtroFechaFin">
                        </div>

                        <div class="form-group col-md-2">
                            <label class="mx-2" for="">Carerra</label>
                            <select class="form-control" id="filtroCarreraId">
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
                            <select class="form-control" id="filtroLlamadoId" >
                                <option selected value="">Todos</option>
                                <?php foreach (get_llamado($conexion) as $e) : ?>
                                    <option value="<?= $e['id'] ?>">
                                        <?= "{$e['nombre']}" ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="form-group col-md-1 d-flex align-items-end">
                            <button type="reset" class="filtro_reset_mesa btn btn-secondary  btn-block"><i class="fas fa-sync-alt"></i></button>
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
                        <th scope="col">Fecha de inicio</th>
                        <th scope="col">Fecha de fin</th>
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





<!-- MODAL PARA ACTUALIZAR EL DETALLE DE MESA -->
<div class="modal fade" id="upd_detalle_mesa" data-backdrop="static" data-keyboard="false" tabindex="-2" aria-hidden="true">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modificacion del horario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="upd_mesa_horario">
                <div class="modal-body" id="edit_horario">
                    <div class="form-row">

                        <div class="form-group  m-0 col-md-3 d-flex align-items-center">
                            <input type="text" class="form-control " disabled id="upd_mesa_dia">
                        </div>
                        <div class="form-group  m-0 col-md-3  d-flex align-items-center"><label class="mx-2">Inicio </label>
                            <input type="time" id="mesa_horario_inicio" class="form-control timepicker my-1 mr-sm-2" step="1800">

                        </div>

                        <input type="text" hidden id="upd_mesa_horario_dia">

                        <div class="form-group  m-0 col-md-3 d-flex align-items-center">
                            <label class="mx-2">Fin</label>
                            <input type="time" id="mesa_horario_fin" class="form-control timepicker my-1 mr-sm-2" step="1800">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group col-md-12 d-flex justify-content-around">
                            <button type="submit" class="btn btn-primary">Aceptar</button>
                            <button type="reset" data-dismiss="modal" class="btn btn-secondary">Cancelar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>