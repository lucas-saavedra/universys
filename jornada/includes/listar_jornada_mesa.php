<?php include('db.php');  ?>
<input type="hidden" id="jornada_horarios">
<div class="row collapse show multi-collapse">
    <div class="col">
        <div class="table-responsive">
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
                <tbody id="listar_jornadas_horarios">
                    <?php
                    foreach (get_jornadas_mesa($conexion) as $mesa) : ?>
                        <tr jornada_id="<?= $mesa['jornada_id'] ?>" mesa_id=" <?= $mesa['id'] ?>" class="table-secondary">

                            <td> <?= $mesa['jornada_id'] ?> </td>
                            <td> <?= $mesa['carrera_nombre'] ?> </td>
                            <td> <?= $mesa['llamado_nombre'] ?> </td>
                            <td> <?= $mesa['fecha_inicio'] ?> </td>
                            <td> <?= $mesa['fecha_fin'] ?> </td>
                            <td> <?= $mesa['descripcion'] ?> </td>
                            <td> <button class="jornada-item btn btn-info" type="button" data-toggle="modal" data-target="#modal_jornadas"><i class="fas fa-pen"></i></button>
                                <button class="jornada_mesa_borrar btn btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <table class="table mb-0">
                                    <thead class="table-borderless">
                                        <tr>
                                            <th scope="col">Dia</th>
                                            <th scope="col">Hora Inicio</th>
                                            <th scope="col">Hora Fin</th>
                                            <th scope="col">Docentes</th>
                                            <th scope="col">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>



                                        <?php


                                        foreach (get_jornadas_horarios($conexion,  $mesa['jornada_id']) as $horarios) : ?>


                                            <div>
                                                <tr>
                                                    <td><?= $horarios['nombre'] ?> </td>
                                                    <td><?= $horarios['hora_inicio'] ?></td>
                                                    <td><?= $horarios['hora_fin'] ?></td>


                                                    <td class="align-middle">


                                                        <?php
                                                        foreach (get_agentes_mesa($conexion,  $mesa['id'], $horarios['det_jorn_id']) as $mesa) : ?>
                                                            <button class=" btn badge badge-warning borrar_agente_mesa" jornada_agente_mesa_id="<?= $mesa['jornada_agente_id'] ?> "   >
                                                                <?= $mesa['docente'] ?>
                                                                <i class=" fas fa-trash"></i>
                                                            </button>
                                                        <?php endforeach; ?>

                                                    </td>
                                                    <td horario_id="<?= $horarios['det_jorn_id'] ?>" mesa_id="<?= $mesa['id'] ?>" hora_inicio="<?= $horarios['hora_inicio'] ?>" hora_fin="<?= $horarios['hora_fin'] ?>" dia="<?= $horarios['nombre'] ?>" >
                                                        <button type="button" class="horario_mesa_i btn" data-bs-toggle="modal"><i class=" fas fa-pen"></i></button>
                                                        <button type="button" class="horario_mesa_i_add_agente btn" data-toggle="modal" data-target="#add_agente"><i class="fas fa-user-plus"></i> </button>
                                                    </td>
                                                </tr>

                                            </div>

                                        <?php endforeach; ?>

                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>


    </div>
</div>




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