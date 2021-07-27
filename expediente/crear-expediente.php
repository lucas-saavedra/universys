<?php 
require_once('../dataBase.php');
include ("../header.html");
include ("./includes/navbar.php");
include ("./includes/consultas.php");
include ("./includes/asignar-planilla-prod.php");
include ("./includes/validaciones.php");

$agentes = get_agentes($conexion);
$codigos = get_codigos_inasis($conexion);

function crear_expediente($bd){

    $expdte = $_POST['expdte'];
    $aviso = $_POST['aviso'];

    mysqli_query($bd, 'START TRANSACTION');
    try{
        $sql_aviso = "INSERT INTO aviso (fecha_recepcion, descripcion) VALUES 
        ('{$aviso['aviso_fecha']}', '{$aviso['aviso_desc']}')";

        if (!$result = mysqli_query($bd, $sql_aviso)) throw new Exception(mysqli_error($bd));
        
        $id_aviso = mysqli_insert_id($bd);

        $sql_expdte = "INSERT INTO expediente (persona_id, fecha_inicio, fecha_fin, aviso_id, codigo_id) VALUES
        ({$expdte['persona_id']}, '{$expdte['fecha_inicio']}', '{$expdte['fecha_fin']}', {$id_aviso}, {$expdte['codigo_id']})";
    
        if (!$result = mysqli_query($bd, $sql_expdte)) throw new Exception(mysqli_error($bd));
        
        $id_expdte = mysqli_insert_id($bd);

        if (isset($expdte['check-docente'])){
            $result = mysqli_query($bd, "SELECT id FROM docente WHERE persona_id={$expdte['persona_id']}");
            $id_docente = mysqli_fetch_row($result)[0];
            $sql_expdte_doc = "INSERT INTO expediente_docente (expediente_id, docente_id) VALUES 
            ($id_expdte, $id_docente)";

            if (!$result = mysqli_query($bd, $sql_expdte_doc)) throw new Exception(mysqli_error($bd));
            
        }

        if (isset($expdte['check-no-docente'])){
            $result = mysqli_query($bd, "SELECT id FROM no_docente WHERE persona_id={$expdte['persona_id']}");
            $id_no_docente = mysqli_fetch_row($result)[0];
            $sql_expdte_no_doc = "INSERT INTO expediente_no_docente (expediente_id, no_docente_id) VALUES 
            ($id_expdte, $id_no_docente)";

            if (!$result = mysqli_query($bd, $sql_expdte_no_doc)) throw new Exception(mysqli_error($bd));
            
        }

        validar_aviso($bd, $id_expdte);
        asignar_expdte_a_planillas_prod($bd, $id_expdte);

        mysqli_commit($bd);
    }
    catch (Exception $e){
        $msg['content'] = $e->getMessage();
        $msg['type'] = 'danger';
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

    <?php include("./includes/msg-box.php"); ?>

    <div class="row mt-4">
        <div class="col-md-8">
            <form action="crear-expediente.php" method="POST">
                <div class="card mb-3">
                    <div class="card-body p-3">
                        <div class="mb-3 row filtro-agente">
                            <div class="col-auto">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="on" id="check-docente"
                                        name="expdte[check-docente]">
                                    <label class="form-check-label" for="check-docente">
                                        Docente
                                    </label>
                                </div>

                            </div>
                            <div class="col-auto">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="on" id="check-no-docente"
                                        name="expdte[check-no-docente]">
                                    <label class="form-check-label" for="check-no-docente">
                                        No docente
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-sm-2 form-label">Agente</label>
                            <div class="col-sm-10">
                                <select class="form-control form-control-sm" name="expdte[persona_id]" required>
                                    <option value="" selected disabled>Seleccione un tipo de agente</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3 row">
                    <div class="col-md-6">
                        <label for="">Fecha de inicio</label>
                        <input type="date" class="form-control" name="expdte[fecha_inicio]" required>
                    </div>
                    <div class="col-md-6">
                        <label for="">Fecha de fin</label>
                        <input type="date" class="form-control" name="expdte[fecha_fin]" required>
                    </div>
                </div>

                <div class="card mb-3">
                    <h6 class="card-header">Datos del aviso</h6>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label for="" class="col-sm-2 form-label">Fecha de recepción</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" class="form-control" name="aviso[aviso_fecha]" required />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="" class="col-sm-2 form-label">Descripción</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="aviso[aviso_desc]"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="" class="col-sm-2 form-label">Código</label>
                    <div class="col-sm-7">
                        <select class="form-control" name="expdte[codigo_id]" required>
                            <option value="" selected disabled>Seleccione un tipo de agente</option>
                        </select>
                    </div>

                </div>

                <div class="row" >
                    <div class="col" id="info-cupo"></div>
                </div>

                <div class="mb-3 row">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Confirmar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <ul class="list-group list-group-horizontal flex-wrap">
                <?php foreach (mysqli_fetch_all(mysqli_query($conexion, 'SELECT id FROM expediente'), MYSQLI_ASSOC) as $expdte):?>
                    <li class="list-group-item">
                        <a href="modificar-expediente.php?id=<?=$expdte['id']?>">
                            <?=$expdte['id']?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>


</div>


<script src="./js/filtro_agentes.js"></script>
<script src="./js/verificar_cupo.js"></script>
<script>
    filtro_agentes(<?=json_encode($agentes)?>);
    filtro_codigos(<?=json_encode($codigos, JSON_NUMERIC_CHECK )?>);
</script>
<?php include("../footer.html"); ?>