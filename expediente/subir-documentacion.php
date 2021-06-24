<?php 
require_once('../dataBase.php');
include ("./consultas.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $sql = "INSERT INTO documentacion_justificada 
    (persona_id, tipo_justificacion_id, fecha_recepcion, descripcion) 
    VALUES (?,?,?,?)";

    $stmt = mysqli_prepare($conexion, $sql);

    mysqli_stmt_bind_param($stmt,"ssss",$_POST['agente_id'],$_POST['tipo_just_id'],$_POST['fecha_rec'], $_POST['desc']);

    mysqli_stmt_execute($stmt);

    $sql_error = mysqli_error($conexion);
}

include ("../header.html");
include ("./navbar.php");

$agentes = get_agentes($conexion)

?>

<div class="container">
    <div class="row mt-4">
        <div class="col">
            <h3>Subir documentación</h3>
        </div>
    </div>
    <?php if (!empty($sql_error)): ?>
        <div class="alert alert-danger" role="alert">
            <b>Ha ocurrido un error: </b><?=$sql_error?>
        </div>
    <?php endif; ?>
    <div class="row mt-4">
        <div class="col-md-8">
            <form action="subir-documentacion.php" method="POST" id="form-doc">
                <div class="mb-3 row">
                    <label for="" class="col-sm-2 form-label">Fecha de recepción</label>
                    <div class="col-sm-10">
                        <input type="datetime-local" class="form-control" name="fecha_rec" required/>
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
                        <input class="form-control-file" type="file">
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

<?php include("../footer.html"); ?>