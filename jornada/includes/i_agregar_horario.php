

<div class="form-row">
    <div class="form-group col-md-12">
        <label for="">Jornadas disponibles</label>
        <select class="form-control" id="jornada_agente" required>
            <option selected value="" disabled>Escoja una jornada</option>
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
        <input type="time" class="form-control timepicker"  step="1800" id="hora_fin">
    </div>

    <div class="form-group col-md-12">
        <label for="">Descripcion de la jornada</label>
        <div class="form-floating">
            <textarea id='descripcion_horario' required name="detalle" class="form-control" placeholder="Ingrese aqui la descripcion" style="height: 100px"></textarea>
        </div>
    </div>

</div>