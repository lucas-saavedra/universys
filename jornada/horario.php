
<div class="container">
    <div class="row">
        <div class="col">

            <form action="" id="horario" method="POST">
                <div class="form-row collapse show multi-collapse" id="">
                    <div class="form-group col-md-6 ">
                        <input class="form-control" readonly aria-describedby="inputGroupPrepend" type="text" id="agente_horarios" placeholder="Click en buscar para seleccionar el agente" aria-label="">
                    </div>
                    <div class="form-group col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span data-toggle="collapse" role="button" type="submit" href="#agente_tabla_horarios" class="btn btn-outline-success input-group-text" id="inputGroupPrepend"><i class="fas fa-search"></i></span>
                            </div>
                            <input autocomplete="off"  class="form-control  input-group-text" aria-describedby="inputGroupPrepend" autofocus type="search" id="search-agente-horario" placeholder="Ingrese el nombre del agente" aria-label="Search">
                        </div>
                    </div>

                    <div class="collapse show multi-collapse col-md-12" id="agente_tabla_horarios">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tbody id="container-agente-horarios">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="">Jornadas disponibles</label>
                        <select class="form-control" id="jornada_agente" required>

                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="">Seleccione el dia</label>
                        <select class="form-control" id="dia_id" required>
                            <option selected value="" disabled>Elija un dia</option>
                            <?php foreach (get_dia($conexion) as $dia) : ?>
                                <option value="<?= $dia['id'] ?>">
                                    <?= "{$dia['nombre']}" ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                    <input type="hidden" id="horario_id">
                    <div class="form-group col-md-4">
                        <label for="hora_inicio">Inicio</label>
                        <input type="time" class="form-control timepicker" step="1800" id="hora_inicio">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="hora_fin">Fin</label>
                        <input type="time" class="form-control timepicker" step="1800" id="hora_fin">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="">Descripcion de la jornada</label>
                        <div class="form-floating">
                            <textarea id='descripcion_horario' name="detalle" class="form-control" placeholder="Ingrese aqui la descripcion" style="height: 100px"></textarea>
                        </div>
                    </div>

                </div>
                <div class="form-row justify-content-center">
                    <div class="form-group col-md-6">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" name="enviar">Aceptar</button>
                    </div>
                    <div class="form-group col-md-6">
                        <button type="reset" data-dismiss="modal" class="btn btn-secondary btn-lg btn-block reset">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>