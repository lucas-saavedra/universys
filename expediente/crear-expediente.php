<?php 
include ("../header.html");
include ("./navbar.php");
require_once('../dataBase.php');
include ("./consultas.php");

$agentes = get_agentes($conexion);


function crear_expediente($bd){

    mysqli_query($bd, 'START TRANSACTION');
    try{
        $sql_aviso = "INSERT INTO aviso (fecha_recepcion, descripcion) VALUES 
        ('{$_POST['aviso_fecha']}', '{$_POST['aviso_desc']}')";

        if (!$result = mysqli_query($bd, $sql_aviso)) throw new Exception();
        
        $id_aviso = mysqli_insert_id($bd);

        $sql_expdte = "INSERT INTO expediente (persona_id, fecha_inicio, fecha_fin, aviso_id, codigo_id) VALUES
        ({$_POST['agente_id']}, '{$_POST['fecha_inicio']}', '{$_POST['fecha_fin']}', {$id_aviso}, {$_POST['codigo_id']})";
    
        if (!$result = mysqli_query($bd, $sql_expdte)) throw new Exception();
        
        $id_expdte = mysqli_insert_id($bd);

        if (isset($_POST['check-docente'])){
            $result = mysqli_query($bd, "SELECT id FROM docente WHERE persona_id={$_POST['agente_id']}");
            $id_docente = mysqli_fetch_row($result)[0];
            $sql_expdte_doc = "INSERT INTO expediente_docente (expediente_id, docente_id) VALUES 
            ($id_expdte, $id_docente)";

            if (!$result = mysqli_query($bd, $sql_expdte_doc)) throw new Exception();
            
        }

        if (isset($_POST['check-no-docente'])){
            $result = mysqli_query($bd, "SELECT id FROM no_docente WHERE persona_id={$_POST['agente_id']}");
            $id_no_docente = mysqli_fetch_row($result)[0];
            $sql_expdte_no_doc = "INSERT INTO expediente_no_docente (expediente_id, no_docente_id) VALUES 
            ($id_expdte, $id_no_docente)";

            if (!$result = mysqli_query($bd, $sql_expdte_no_doc)) throw new Exception();
            
        }

        mysqli_commit($bd);
    }
    catch (Exception $e){
        $msg['content'] = mysqli_error($bd);
        $msg['type'] = 'warning';
        mysqli_rollback($bd);
        return $msg;
    }
    

    $msg['content'] = "Creado expediente de ID {$id_expdte}";
    $msg['type'] = 'success';

    return $msg;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $msg = crear_expediente($conexion);
}
?>
<div class="container">
    <div class="row mt-4">
        <div class="col">
            <h3>Crear expediente</h3>
        </div>
    </div>
    <?php if (isset($msg['content'])): ?>
        <div class="row">
            <div class="col">
                <div class="alert alert-<?=$msg['type']?>" role="alert">
                    <?=$msg['content']?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="row mt-4">
        <div class="col-md-8">
            <form action="crear-expediente.php" method="POST">
                <div class="card mb-3">
                    <div class="card-body p-3">
                        <div class="mb-3 row filtro-agente">
                            <div class="col-auto">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="on" id="check-docente" name="check-docente">
                                    <label class="form-check-label" for="check-docente">
                                        Docente
                                    </label>
                                </div>

                            </div>
                            <div class="col-auto">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="on" id="check-no-docente" name="check-no-docente">
                                    <label class="form-check-label" for="check-no-docente">
                                        No docente
                                    </label>   
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-2 form-label">Agente</label>
                            <div class="col-sm-10">
                                <select class="form-control form-control-sm" name="agente_id" required>
                                </select>
                            </div>
                        </div>                    
                    </div>
                </div>

                <div class="mb-3 row">
                    <div class="col-md-6">
                        <label for="">Fecha de inicio</label>
                        <input type="date" class="form-control" name="fecha_inicio" required>
                    </div>
                    <div class="col-md-6">
                        <label for="">Fecha de fin</label>
                        <input type="date" class="form-control" name="fecha_fin" required>
                    </div>
                </div>

                <div class="card mb-3">
                    <h6 class="card-header">Datos del aviso</h6>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label for="" class="col-sm-2 form-label">Fecha de recepción</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" class="form-control" name="aviso_fecha" required />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="" class="col-sm-2 form-label">Descripción</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="aviso_desc"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="" class="col-sm-2 form-label">Código</label>
                    <div class="col-sm-7">
                        <select class="form-control" name="codigo_id" required>
                            <option selected></option>
                            <?php foreach (get_codigos_inasis($conexion) as $codigo):?>
                                <option value="<?=$codigo['id']?>">
                                    <?="{$codigo['referencia']} - {$codigo['nombre']}"?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

                <div class="mb-3 row">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Confirmar</button>
                    </div>
                </div>

        </div>

        </form>
    </div>
</div>
</div>


<script src="filtro_agentes.js"></script>
<script>
    filtro_agentes(<?=json_encode($agentes)?>);
</script>
<?php include("../footer.html"); ?>