<?php include("navbar.php");

if (
    !$es_coord && !$es_admin &&
    !$es_alumn && !$es_director && !$es_personal
) {
    header("Location: ../index.php ");
}
?>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card mb-4 mt-4">
                <div class="card-header">
                    <h2 class="card-title text-center h-4">Mesa de examen docentes</h2>
                </div>
                <div class="card-body">
                    <form action="mesa.php" method="POST" id="jornada_mesa">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="fecha_inicio">Incio de la jornada</label>
                                <input required type="date" class="form-control" id="fechaInicioMesa">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="fecha_fin">Fin de la jornada</label>
                                <input required type="date" class="form-control" id="fechaFinMesa">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">Tipo de jornada</label>
                                <select disabled class="form-control" id="tipo_jornada_mesa_id" required>
                                    <option selected value="4">Mesa de examen</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="mx-2" for="">Carerra</label>
                                <select class="form-control" id="carrera_id" required>
                                    <option selected value="" disabled>Escoja una carrera</option>
                                    <?php foreach (get_carreras($conexion) as $e) : ?>
                                        <option value="<?= $e['id'] ?>">
                                            <?= "{$e['nombre']}" ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Llamado</label>
                                <select class="form-control" id="llamado_id" required>
                                    <option selected value="" disabled>Escoja un llamado</option>
                                    <?php foreach (get_llamado($conexion) as $e) : ?>
                                        <option value="<?= $e['id'] ?>">
                                            <?= "{$e['nombre']}" ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-2"><label class="">Inicio </label>
                                <input type="time" class="form-control timepicker" id="hora_inicio_mesa" value="16:00" step="1800">
                            </div>
                            <div class="form-group col-md-2  ">
                                <label class="">Fin</label>
                                <input type="time" class="form-control timepicker" id="hora_fin_mesa" value="19:00" step="1800">
                            </div>
                        </div>
                        <input type="hidden" id="horario_mesa_id">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="">Descripcion de la jornada</label>
                                <div class="form-floating">
                                    <textarea id='descripcion_mesa' class="form-control" placeholder="Ingrese aqui la descripcion" style="height: 10em;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-row justify-content-center">
                            <div class="form-group col-md-6">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Aceptar</button>
                            </div>
                            <div class="form-group col-md-6">
                                <button type="reset" data-dismiss="modal" class="btn btn-secondary btn-lg btn-block reset ">Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <?php include_once("includes/listar_jornada_mesa.php");  ?>
</div>

<!-- Modal agregar agentes a la mesa -->
<div class="modal fade" id="add_agente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Agregar agentes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="formAddAgente">
                    <div class="form-group col-md-12">
                        <div class="table-responsive">
                            <div class="card-body">
                                <div data-spy="scroll" data-target="#navbar-example2" data-offset="0">
                                    <input type="text" id="horario_id" hidden>
                                    <input type="text" id="hora_inicio_agente" hidden>
                                    <input type="text" id="hora_fin_agente" hidden>
                                    <input type="text" id="mesa_id" hidden>
                                    <?php foreach (get_docentes($conexion) as $e) : ?>
                                        <div required class="checkbox_docentes">
                                            <label>
                                                <input type="checkbox" name="docentes" value="<?= $e['id'] ?>">
                                                <?= "{$e['nombre']}" ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row justify-content-center">
                        <div class="form-group col-md-6">
                            <button type="submit" class="btn btn-primary btn-lg btn-block">Aceptar</button>
                        </div>
                        <div class="form-group col-md-6">
                            <button type="reset" data-dismiss="modal" class="btn btn-secondary btn-lg btn-block reset ">Cancelar</button>
                        </div>
                    </div>
                </form>


            </div>

        </div>
    </div>
</div>




<!-- Modal actualizar mesa -->
<div class="modal fade" id="upd_jornada_mesa" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Editar Jornada de Mesa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="act_jornada_mesa">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="mx-2" for="">Carerra</label>
                            <select class="form-control" id="carrera_id_updt" disabled required>
                                <option selected value="" disabled>Escoja una carrera</option>
                                <?php foreach (get_carreras($conexion) as $e) : ?>
                                    <option value="<?= $e['id'] ?>">
                                        <?= "{$e['nombre']}" ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <input type="text" hidden id="mesa_examen_id">
                        <input type="text" hidden id="jornada_id_mesa">

                        <div class="form-group col-md-6">
                            <label for="">Llamado</label>
                            <select class="form-control" id="llamado_id_updt" required>
                                <option selected value="">Escoja un llamado</option>
                                <?php foreach (get_llamado($conexion) as $e) : ?>
                                    <option value="<?= $e['id'] ?>">
                                        <?= "{$e['nombre']}" ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fecha_inicio">Fecha de incio de la jornada</label>
                            <input required type="date" disabled class="form-control" id="fechaInicioMesaUpdt">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fecha_fin">Fecha de fin de la jornada</label>
                            <input required type="date" class="form-control" id="fechaFinMesaUpdt">
                        </div>


                    </div>

                    <div class="form-group">
                        <label for="">Descripcion de la jornada</label>
                        <div class="form-floating">
                            <textarea id='descripcion_mesa_updt' name="detalle" class="form-control" placeholder="Ingrese aqui la descripcion" style="height: 100px"></textarea>
                        </div>
                    </div>
                    <div class="form-row justify-content-center">
                        <div class="form-group col-md-6">
                            <button type="submit" class="btn btn-primary btn-lg btn-block">Aceptar</button>
                        </div>
                        <div class="form-group col-md-6">
                            <button type="reset" data-dismiss="modal" class="btn btn-secondary btn-lg btn-block reset ">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA ACTUALIZAR EL DETALLE DE MESA -->

<div class="modal fade" id="upd_detalle_mesa" data-backdrop="static" data-keyboard="false" tabindex="-2" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modificacion del horario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="upd_mesa_horario">
                    <div class="form-row py-3">
                        <div class="form-group col-md-4">
                            <label>Dia </label>
                            <input type="text" class="form-control " disabled id="upd_mesa_dia">
                        </div>
                        <div class="form-group   col-md-4">
                            <label>Inicio </label>
                            <input type="time" id="mesa_horario_inicio" class="form-control timepicker" step="1800">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Fin</label>
                            <input type="time" id="mesa_horario_fin" class="form-control timepicker" step="1800">
                        </div>


                        <div class="form-group col-md-12">
                            <label for="">Descripcion del dia de la mesa</label>
                            <div class="form-floating">
                                <textarea id='descripcion_dia_mesa_updt' required name="detalle_dia_mesa" class="form-control" placeholder="Ingrese aqui la descripcion" style="height: 100px"></textarea>
                            </div>
                        </div>


                    </div>
                    <input type="text" hidden id="upd_mesa_horario_dia">
                    <input type="text" hidden id="upd_mesa_id">
                    <input type="text" hidden id="upd_mesa_dia_id">

                    <div class="form-row justify-content-center">
                        <div class="form-group col-md-6">
                            <button type="submit" class="btn btn-primary  btn-block">Aceptar</button>
                        </div>
                        <div class="form-group col-md-6">
                            <button type="reset" data-dismiss="modal" class="btn btn-secondary  btn-block reset ">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php") ?>