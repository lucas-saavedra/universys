<title>Subir documentación</title>
<?php 

/* include ("../includes/header.php");
include ("../includes/menu.php"); */
include ("../jornada/navbar.php");
include ("../expediente/includes/consultas.php");

function subir_archivo($file, $nombre){
    $target_dir = "./uploads/";

    if (!is_dir($target_dir)) mkdir($target_dir);

    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    $file_name = "$nombre.$extension";

    $target_file = $target_dir . $file_name;
    $result = move_uploaded_file($file["tmp_name"], $target_file);

    if ($result) return $file_name;

    return "";
}

function subir_documentacion($bd){
    mysqli_query($bd, 'START TRANSACTION');
    try{
        $sql_insert = "INSERT INTO documentacion_justificada 
        (persona_id, tipo_justificacion_id, fecha_recepcion, descripcion) VALUES 
        ({$_POST['agente_id']},{$_POST['tipo_just_id']},'{$_POST['fecha_rec']}', '{$_POST['desc']}')";

        if (!$result = mysqli_query($bd, $sql_insert)) throw new Exception(mysqli_error($bd));

        $doc_creada_id = mysqli_insert_id($bd);

        $archivo_subido = subir_archivo($_FILES['archivo'], $doc_creada_id);

        if (!$archivo_subido) throw new Exception("Ha ocurrido un error al subir el archivo.");

        mysqli_query($bd, "UPDATE documentacion_justificada SET archivo='{$archivo_subido}' WHERE id={$doc_creada_id}");

        mysqli_commit($bd);
    }
    catch (Exception $e){
        $msg['content'] = $e->getMessage();
        $msg['type'] = 'warning';
        mysqli_rollback($bd);
        return $msg;
    }

    $msg['content'] = "Creada documentacion de ID: {$doc_creada_id} con archivo: {$archivo_subido}";
    $msg['type'] = 'success';

    return $msg;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $msg = subir_documentacion($conexion);
}

$agentes = get_agentes($conexion);
?>

<div class="container">
    <div class="row mt-4">
        <div class="col">
            <h3>Subir documentación</h3>
        </div>
    </div>
    <?php include("../expediente/includes/msg-box.php"); ?>

    <div class="row mt-4">
        <div class="col">
            <form action="index.php" method="POST" enctype="multipart/form-data" id="form-doc">
                <div class="mb-3 row">
                    <label for="" class="col-sm-2 form-label">Fecha de recepción</label>
                    <div class="col-sm-10">
                        <input type="datetime-local" class="form-control" name="fecha_rec" required/>
                    </div>
                </div>
                <div class="mb-3 row filtro-agente">
                    <div class="col-auto">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="check-docente">
                            <label class="form-check-label" for="check-docente">
                                Docente
                            </label>
                        </div>

                    </div>
                    <div class="col-auto">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="check-no-docente">
                            <label class="form-check-label" for="check-no-docente">
                                No docente
                            </label>   
                        </div>
                    </div>
                </div>
                <div class="mb-5 row">
                    <label for="" class="col-sm-2 form-label">Agente</label>
                    <div class="col-sm-6">
                        <select id="select-agente" class="form-control" name="agente_id" required>
                        <option selected></option>
                        <?php foreach ($agentes as $agente):?>
                            <option value="<?=$agente['id']?>">
                                <?=$agente['nombre']?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="" class="col-md-2 form-label">Archivo</label>
                    <div class="col-md-10">
                        <input class="form-control-file" type="file" name="archivo" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="" class="col-sm-2 form-label">Tipo de documentación</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="tipo_just_id" required>
                            <option selected></option>
                            <?php foreach (get_tipos_documentacion($conexion) as $tipo_doc): ?>
                                <option value="<?=$tipo_doc['id']?>">
                                    <?=$tipo_doc['descripcion']?>
                                </option>  
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="col-sm-2 form-label">Descripción</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="desc"></textarea>
                    </div>
                </div>

                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-lg btn-primary">Confirmar</button>
                </div>
            </form>
        </div>
    </div>


    <div class="row mt-4">
        <div class="col">
            <div class="card">
                <div class="card-header py-3">
                    <h4>Documentación sin expediente asignado</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Tipo</th>
                                    <th>Agente</th>
                                    <th>Fecha de recepción</th>
                                    <th>Descripción</th>
                                    <th class="text-center">Archivo</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach(get_docs_sin_expdte($conexion) as $doc):?>
                                    <tr>
                                        <td class="align-middle"><?=$doc['id']?></td>
                                        <td class="align-middle"><?=$doc['nom_tipo_just']?></td>
                                        <td class="align-middle"><?=$doc['agente_nombre']?></td>
                                        <td class="align-middle"><?=$doc['fecha_recepcion']?></td>
                                        <td class="align-middle"><?=$doc['descripcion']?></td>
                                        <td class="align-middle text-center">
                                            <a href=<?="uploads/{$doc['archivo']}"?>>
                                                <i class="fa fa-lg fa-download"></i>
                                            </a>
                                        </td>
                                        <td class="align-middle text-center">
                                            <form class="m-0" action="eliminar.php" method="POST">
                                                <button 
                                                    class="btn btn-danger" 
                                                    type="submit" name="id" 
                                                    value="<?=$doc['id']?>"
                                                    onclick="return confirm('Seguro que desea eliminar la documentación de ID <?= $doc['id'] ?>?')"
                                                >
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

<script src="../expediente/js/filtro_agentes.js"></script>
<script>
    filtro_agentes(<?=json_encode($agentes)?>);
</script>
<?php include("../includes/footer.php"); ?>