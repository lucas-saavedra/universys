<!--  <?php foreach (get_dia($conexion, $tipo_agente) as $e) : ?>
                    <div class="card my-1">
                        <div class="card-body p-3">
                            <div class="form-row d-flex align-items-center">
                                <div class="form-group col-md-4 m-0">
                                    <div class=" checkbox_dias " required>
                                        <label class="m-0">
                                            <input type="checkbox" name="dias" value="<?= $e['id'] ?>">
                                            <?= $e['nombre'] ?> </label>
                                    </div>
                                </div>
                                <div class="form-group  m-0 col-md-4 col-md-4 d-flex align-items-center"><label class="mx-2">Inicio </label>
                                    <input type="time" name="inicio[]" class="form-control timepicker my-1 mr-sm-2" value="16:00" step="1800">

                                </div>
                                <div class="form-group  m-0 col-md-4 col-md-4 d-flex align-items-center">
                                    <label class="mx-2">Fin</label>
                                    <input type="time" name="fin[]" class="form-control timepicker my-1 mr-sm-2" value="19:00" step="1800">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?> -->


                <!-- <div class="row collapse show multi-collapse">
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
                            <td> <button class="jornada_item_mesa btn btn-info" type="button" data-toggle="modal" data-target="#upd_jornada_mesa"><i class="fas fa-pen"></i></button>
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
                                                        foreach (get_agentes_mesa($conexion,  $mesa['id'], $horarios['det_jorn_id']) as $agente) : ?>
                                                            <button class=" btn badge badge-warning borrar_agente_mesa" jornada_agente_mesa_id="<?= $agente['jornada_agente_id'] ?> ">
                                                                <?= $agente['docente'] ?>
                                                                <i class=" fas fa-trash"></i>
                                                            </button>
                                                        <?php endforeach; ?>

                                                    </td>
                                                    <td horario_id="<?= $horarios['det_jorn_id'] ?>" mesa_id="<?= $mesa['id'] ?>" hora_inicio="<?= $horarios['hora_inicio'] ?>" hora_fin="<?= $horarios['hora_fin'] ?>" dia="<?= $horarios['nombre'] ?>">
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

                </tbody> -->
<!-- </table>
</div>
</div>
</div>  -->