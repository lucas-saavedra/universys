<?php 
require_once('../dataBase.php');
include ("../header.html");
include ("./includes/navbar.php");
include ("./includes/consultas.php");


if (isset($_GET['id']) && $id = intval($_GET['id'])){
    $expdte = get_expdte($conexion, $id);
}

if (!isset($expdte)) header("Location:crear-expediente.php");


function get_campos_modificados($array1, $array2){
    $campos = array_keys($array2);
    $modificaciones = [];

    foreach ($campos as $campo) {
        if ($array1[$campo] != $array2[$campo]){
            if ($array2[$campo] === ""){
                $modificaciones[$campo] = "{$campo}=NULL";
                continue;
            }
            $modificaciones[$campo] = "{$campo}='{$array2[$campo]}'";
        }
    }

    return $modificaciones;
}

function modificar_expdte($bd, $expdte){
    $modificaciones = get_campos_modificados($expdte, $_POST);

    if (empty($modificaciones)) return;
    
    $update_string = implode(', ', $modificaciones);

    $sql_update_expdte = "UPDATE expediente SET {$update_string} WHERE id={$expdte['id']}";

    if ($result = mysqli_query($bd, $sql_update_expdte)){
        return ["content" => "El expediente ha sido modificado con exito", "type" => "success"];
    }

    $error = mysqli_error($bd);
    return ["content" => "Ha ocurrido un error: {$error}", "type" => "warning"];

}


if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $msg = modificar_expdte($conexion, $expdte);
    $expdte = get_expdte($conexion, $expdte['id']);
}

?>

<div class="container">
    <div class="row my-4">
        <div class="col">
            <h3>Modificar expediente</h3>
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

    <div class="row">
        <div class="col-md-8">
            <form action="<?="modificar-expediente.php?id={$id}"?>" method="POST">
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