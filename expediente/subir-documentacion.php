<?php 
require_once('../dataBase.php');
include ("./consultas.php");

function subir_archivo($file, $nombre){
    $target_dir = "../uploads/";

    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    $file_name = "$nombre.$extension";

    $target_file = $target_dir . $file_name;
    $result = move_uploaded_file($file["tmp_name"], $target_file);

    if ($result) return $file_name;

    return "";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    mysqli_autocommit($conexion, FALSE);
    $sql = "INSERT INTO documentacion_justificada 
    (persona_id, tipo_justificacion_id, fecha_recepcion, descripcion) 
    VALUES (?,?,?,?)";

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt,"ssss",$_POST['agente_id'],$_POST['tipo_just_id'],$_POST['fecha_rec'], $_POST['desc']);
    mysqli_stmt_execute($stmt);
    $error = mysqli_error($conexion);
    if ($error) return;

    $doc_creada_id = mysqli_insert_id($conexion);

    $archivo_subido = subir_archivo($_FILES['archivo'], $doc_creada_id);

    if ($archivo_subido){
        mysqli_query($conexion, "UPDATE documentacion_justificada SET archivo='$archivo_subido' WHERE id=$doc_creada_id");
        mysqli_commit($conexion);
    }
    else{
        mysqli_rollback($conexion);
        $error = "Error al subir el archivo";
    }
}

include ("../header.html");
include ("./navbar.php");

$agentes = get_agentes($conexion);
?>

<div class="container">
    <div class="row mt-4">
        <div class="col">
            <h3>Subir documentación</h3>
        </div>
    </div>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert">
            <b>Ha ocurrido un error: </b><?=$error?>
        </div>
    <?php endif; ?>
    <div class="row mt-4">
        <div class="col-md-8">
            <form action="subir-documentacion.php" method="POST" enctype="multipart/form-data" id="form-doc">
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
                        <select class="form-control" name="agente_id" required>
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
                        <input class="form-control-file" type="file" name="archivo" >
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

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Confirmar</button>
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