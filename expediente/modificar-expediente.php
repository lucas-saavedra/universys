<?php 
require_once('../dataBase.php');
include ("../header.html");
include ("./navbar.php");
include ("./consultas.php");


if (isset($_GET['id']) && $id = intval($_GET['id'])){
    $sql_expdte = "SELECT e.*, p.nombre as nom_agente FROM expediente as e 
    INNER JOIN persona as p ON e.persona_id=p.id and e.id={$id}";
    $expdte = mysqli_fetch_assoc(mysqli_query($conexion, $sql_expdte));
}

if (!isset($expdte)) header("Location:crear-expediente.php");

?>

<div class="container">
    <div class="row my-4">
        <div class="col">
            <h3>Agregar documentación a expediente</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <form action="<?="agregar-doc-expediente.php?id={$id}"?>" method="POST">
                <div class="jumbotron p-4 d-flex justify-content-between">
                    <h4 class="m-0">Expediente ID: <?=$id?> - Agente: <?=$expdte['nom_agente']?></h4>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="">Fecha de inicio</label>
                        <input type="date" class="form-control" name="fecha_inicio" value="<?=$expdte['fecha_inicio']?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="">Fecha de fin</label>
                        <input type="date" class="form-control" name="fecha_fin" value="<?=$expdte['fecha_fin']?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="col-sm-2 form-label">Documentación</label>
                    <div class="col-sm-10">
                        <select class="form-control form-control-sm" name="doc_justificada_id">
                            <option value="" <?=!$expdte['doc_justificada_id'] ? 'selected': ''?>></option>

                            <?php foreach(get_docs_sin_expdte($conexion, $expdte) as $doc): ?>
                                <option value="<?=$doc['id']?>" <?=$doc['id'] === $expdte['doc_justificada_id'] ? 'selected': ''?>>
                                    <?="{$doc['id']} / {$doc['fecha_recepcion']} - {$doc['nom_tipo_just']}"?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="col-sm-2 form-label">Código</label>
                    <div class="col-sm-7">
                        <select class="form-control" name="codigo_id" required>
                            <?php if (!$expdte['codigo_id']): ?>
                                <option value="" selected disabled>Seleccione un código</option>
                            <?php endif; ?>

                            <?php foreach (get_codigos_inasis($conexion) as $codigo):?>
                                <option value="<?=$codigo['id']?>" <?=$codigo['id'] === $expdte['codigo_id'] ? 'selected': ''?>>
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
            </form>
        </div>
    </div>
</div>

<?php include("../footer.html"); ?>