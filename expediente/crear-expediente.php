<title>Crear Expediente</title>
<?php 
include_once('../includes/db.php');
include ("./includes/consultas.php");
include ("./includes/asignar-planilla-prod.php");
include ("./includes/validaciones.php");

$agentes = get_agentes($conexion);
$codigos = get_codigos_inasis($conexion, "id!={$ID_COD_SIN_AVISO}");

function crear_expediente($bd){

    $expdte = $_POST['expdte'];
    $aviso = $_POST['aviso'];

    mysqli_query($bd, 'START TRANSACTION');
    try{
        $sql_aviso = "INSERT INTO aviso (fecha_recepcion, descripcion) VALUES 
        ('{$aviso['aviso_fecha']}', '{$aviso['aviso_desc']}')";

        if (!$result = mysqli_query($bd, $sql_aviso)) throw new Exception(mysqli_error($bd));
        
        $id_aviso = mysqli_insert_id($bd);

        $sql_expdte = "INSERT INTO expediente (persona_id, fecha_inicio, fecha_fin, aviso_id, codigo_id, cupo_superado, confirmado) VALUES
        ({$expdte['persona_id']}, '{$expdte['fecha_inicio']}', '{$expdte['fecha_fin']}', {$id_aviso}, {$expdte['codigo_id']}, {$expdte['cupo_superado']}, {$expdte['confirmado']})";
    
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

    if ($msg['type'] == 'success'){
        session_start();
        $_SESSION['crear_expdte_msg'] = $msg;
        header('Location:index.php');
    }
}

include ("../jornada/navbar.php");
?>
<div class="container">
    <div class="row mt-4">
        <div class="col">
            <h3>Crear expediente</h3>
        </div>
    </div>

    <?php include("./includes/msg-box.php"); ?>

    <div class="row mt-4">
        <div class="col">
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
                                <select id="select-agente" class="form-control form-control-sm" name="expdte[persona_id]" required>
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
                            <label for="" class="col-sm-2 form-label">Fecha de recepci??n</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" class="form-control" name="aviso[aviso_fecha]" required />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="" class="col-sm-2 form-label">Descripci??n</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="aviso[aviso_desc]"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="" class="col-sm-2 form-label">C??digo</label>
                    <div class="col-sm-7">
                        <select class="form-control" name="expdte[codigo_id]" required>
                            <option value="" selected disabled>Seleccione un tipo de agente</option>
                        </select>
                    </div>
                    <div class="col-sm-3 d-flex align-items-center">
                        <div class="form-check">
                            <input type="hidden" name="expdte[cupo_superado]" value="0" />
                            <input class="form-check-input" type="checkbox" id="check-cupo" disabled />
                            <label class="form-check-label">
                                Cupo superado
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row" >
                    <div class="col" id="info-cupo"></div>
                </div>

                <div class="mb-3 row">
                    <div class="col text-center">
                        <input type="hidden" name="expdte[confirmado]" value="0">
                        <button type="submit" class="btn btn-primary btn-lg">Confirmar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


</div>


<script src="./js/filtro_agentes.js"></script>
<script src="./js/verificar_cupo.js"></script>
<script>
    filtro_agentes(<?=json_encode($agentes)?>);
    filtro_codigos(<?=json_encode($codigos, JSON_NUMERIC_CHECK )?>);
</script>
<?php include("../includes/footer.php"); ?>