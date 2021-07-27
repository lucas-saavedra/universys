<?php include("header.php"); ?>
<div class="container">
    <div class="row">
        <div class="col">

            <h1>UNIVERSYS</h1>


            <form action="mesa.php" method="POST" id="jornada_mesa">
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="fecha_inicio">Incio de la jornada</label>
                        <input required type="date" value="2021-07-19" class="form-control" id="fechaInicioMesa">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="fecha_fin">Fin de la jornada</label>
                        <input required type="date" value="2022-07-19" class="form-control" id="fechaFinMesa">
                    </div>

                    <div class="form-group col-md-2">
                        <label for="">Tipo de jornada</label>
                        <select disabled class="form-control" id="tipo_jornada_mesa_id" required>
                            <option selected value="4">Mesa de examen</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Llamado</label>
                        <select class="form-control" id="llamado_id" required>
                            <option selected value="1" disabled>Escoja un llamado</option>
                            <?php foreach (get_llamado($conexion) as $e) : ?>
                                <option value="<?= $e['id'] ?>">
                                    <?= "{$e['nombre']}" ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Carerra</label>
                        <select class="form-control" id="carrera_id" required>
                            <option selected value="1" disabled>Escoja una carrera</option>
                            <?php foreach (get_carreras($conexion) as $e) : ?>
                                <option value="<?= $e['id'] ?>">
                                    <?= "{$e['nombre']}" ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>


                <?php foreach (get_dia($conexion, $tipo_agente) as $e) : ?>
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
                <?php endforeach; ?>

                <input type="hidden" id="horario_mesa_id">


                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="">Descripcion de la jornada</label>
                        <div class="form-floating">
                            <textarea id='descripcion_mesa' required class="form-control" placeholder="Ingrese aqui la descripcion" style="height: 10em;">test</textarea>
                        </div>
                    </div>
                </div>
                <div class="form-row justify-content-center">
                    <div class="form-group col-md-6">
                        <button type="submit" class="btn btn-primary  btn-lg btn-block" name="enviar">Aceptar</button>
                    </div>
                    <div class="form-group col-md-6">
                        <button type="reset" class="btn btn-secondary  btn-lg btn-block">Resetear</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<div class="container-fluid px-md-3">
    <?php include_once("includes/listar_jornada_mesa.php");  ?>
</div>

<?php include("footer.html") ?>





<!-- Modal -->
<div class="modal fade" id="add_agente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="" method="post" id="formAddAgente">
                    <div class="form-group col-md-12">
                        <label class="heading">Seleccione los docentes para el dia de la mesa</label>
                        <div class="table-responsive" style="overflow:scroll;">
                            <div class="card-body">
                                <div data-spy="scroll" data-target="#navbar-example2" data-offset="0">
                                    <input type="text" id="horario_id" hidden>
                                    <input type="text" id="mesa_id" hidden>
                                    <?php foreach (get_docentes($conexion, $tipo_agente) as $e) : ?>
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
                            <button type="submit" class="btn btn-primary  btn-lg btn-block" name="enviar">Aceptar</button>
                        </div>
                        <div class="form-group col-md-6">
                            <button type="reset" class="btn btn-secondary  btn-lg btn-block">Resetear</button>
                        </div>
                    </div>
                </form>


            </div>

        </div>
    </div>
</div>

