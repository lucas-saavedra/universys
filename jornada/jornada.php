<div class="container">
    <div class="row">
        <div class="col">
            <form action="" id="jornada" method="POST">
                <?PHP include("includes/elegir_agente.php") ?>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="fecha_inicio">Fecha de incio de la jornada</label>
                        <input required type="date" class="form-control" id="fechaInicio">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="fecha_fin">Fecha de fin de la jornada</label>
                        <input required type="date" class="form-control" id="fechaFin">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="">Tipo de jornada</label>
                        <select class="form-control" id="tipoJornadaId" required>
                            <option selected value="" disabled>Escoja un tipo de jornada</option>
                            <?php foreach (get_tipo_jornadas($conexion, $tipo_agente) as $tipo_jornadas) : ?>
                                <option value="<?= $tipo_jornadas['id'] ?>">
                                    <?= "{$tipo_jornadas['nombre']}" ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="card my-1">
                    <div class="card-body p-2">
                        <?php foreach (get_dia($conexion, $tipo_agente) as $e) : ?>
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

                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="">Descripcion de la jornada</label>
                    <div class="form-floating">
                        <textarea id='descripcion' name="detalle" class="form-control" placeholder="Ingrese aqui la descripcion" style="height: 100px"></textarea>
                    </div>
                </div>

                <?php if ($tipo_agente == 'docente') {
                    include("includes/elegir_catedra.php");
                } else {
                    include("includes/elegir_area.php");
                }
                ?>

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