<?php 
    function _get_roles($bd){
        $sql = "SELECT * FROM rol";
        return mysqli_fetch_all(mysqli_query($bd, $sql), MYSQLI_ASSOC);
    }
?>

<div class="form-group row mt-4">
    <div class="col-12">
        <h4 class="border-bottom border-black pb-2 text-secondary">Roles</h4>
    </div>
</div>

<div class="form-group row">
    <?php foreach(_get_roles($conexion) as $rol): ?>
        <div class="col-auto">
            <div class="form-check">
                <input 
                    name="<?="roles[{$rol['nombre']}]"?>" 
                    class="form-check-input" type="checkbox" 
                    value=<?=$rol['id']?> 
                    id="<?="rol-{$rol['nombre']}"?>"
                    <?=isset($agente_roles) && in_array($rol['id'], $agente_roles) ? 'checked': ''?>
                >
                <label class="form-check-label" for="<?="rol-{$rol['nombre']}"?>">
                    <?=$rol['nombre']?>
                </label>
            </div>
        </div> 
    <?php endforeach; ?>
</div>