<?php include('db.php');  ?>
<input type="hidden" id="jornada_horarios">
<div class="row collapse show multi-collapse">
    <div class="col">
        <div class="table-responsive">
            <table class="table table-sm">
                <thead class="thead-light">
                    <tr>
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

                        <?php if (isset($_SESSION['editando'])) { ?>
                             <th scope="col">Acciones</th>
                        <?php
                        } ?>

                    </tr>

                </thead>
                <tbody id="listar_jornadas_horarios">
                    <?php
                    foreach (obtener_jornadas($conexion,$fecha_inicio,$fecha_fin,$tipo_jornada_id) as $jornada) : ?>
                        <tr jornada_id="<?= $jornada['jornada_id'] ?>">
                            <td> <?= $jornada['docente'] ?> </td>
                            <td> <?= $jornada['catedra'] ?> </td>
                            <td> <?= $jornada['fecha_inicio'] ?> </td>
                            <td> <?= $jornada['fecha_fin'] ?> </td>
                            <td> <?= $jornada['tipo_jornada'] ?> </td>
                            <td> <?= $jornada['descripcion'] ?> </td>
                            <td> <button class="jornada-item btn btn-info" type="button" data-toggle="modal" data-target="#modal_jornadas"><i class="fas fa-pen"></i></button>
                                <button class="jornada_borrar btn btn-danger" ><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">

                                <?php
                                foreach (get_jornadas_horarios($conexion,  $jornada['jornada_id']) as $horarios) : ?>

                                    <div horario_id="<?= $horarios['det_jorn_id'] ?>" jornada_agente_id="<?= $jornada['jornada_agente_id'] ?>" agente_id="<?= $jornada['agente_id'] ?>" jornada_id="<?= $jornada['jornada_id'] ?>">
                                        <span class="input-group-text" id="basic-addon1"><?= $horarios['nombre'] ?> <?= $horarios['hora_inicio'] . '    ' ?><i class="fas fa-arrow-right p-1"></i>
                                            <?= ' ' . $horarios['hora_fin'] ?>
                                            <button type="button" class="horario_item btn" data-toggle="modal" data-target="#modal_horarios"><i class=" fas fa-pen"></i></button>
                                            <button type="button" class="horario_item_borrar btn"><i class=" fas fa-trash"></i></button>
                                        </span>
                                    </div>
                                <?php endforeach; ?>

                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>


    </div>
</div>


<!-- Modal -->
<!-- <div class="modal fade" id="modal_edit_horario" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modificacion del horario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="horario">
                <div class="modal-body" id="edit_horario">
                   
                </div>
                <div class="modal-footer">
                    <div class="form-group col-md-12 d-flex justify-content-around">
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                        <button type="reset" data-dismiss="modal" class="btn btn-secondary">Cancelar</button>
                    </div>
                </div>
                
            </form>

        </div>
    </div>
</div> -->