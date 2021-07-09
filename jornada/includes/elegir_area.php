<div class="form-row">
    <div class="form-group col-md-12">
        <label for="">Area</label>
        <select class="form-control" id="area_id" required>
            <option selected value="" disabled>Escoja un area</option>
            <?php foreach (get_areas($conexion) as $areas) : ?>
                <option value="<?= $areas['id'] ?>">
                    <?= "{$areas['nombre']}" ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>