<?php $tipo_agente = $_SESSION['tipo_agente']; ?>

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

<div class="form-group">
    <label for="">Descripcion de la jornada</label>
    <div class="form-floating">
        <textarea id='descripcion' required name="detalle" class="form-control" placeholder="Ingrese aqui la descripcion" style="height: 100px"></textarea>
    </div>
</div>