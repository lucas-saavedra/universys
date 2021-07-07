<?php 
require_once('../dataBase.php');
include ("../header.html");
include ("./includes/navbar.php");
include ("./includes/consultas.php");


if (isset($_GET['id']) && $id = intval($_GET['id'])){
    $expdte = get_expdte($conexion, $id);
}

if (!isset($expdte)) header("Location:crear-expediente.php");


function get_campos_modificados($array1, $array2, $convertir=array()){
    $campos = array_keys($array2);
    $modificaciones = [];

    foreach ($campos as $campo) {
        $converted = empty($convertir[$campo]) ? $campo: $convertir[$campo];
        if ($array1[$campo] != $array2[$campo]){
            if ($array2[$campo] === ""){
                $modificaciones[$campo] = "{$campo}=NULL";
                continue;
            }
            $modificaciones[$campo] = "{$converted}='{$array2[$campo]}'";
        }
    }

    return $modificaciones;
}

function modificar_expdte($bd, $expdte){
    $modifs_en_expdte = get_campos_modificados($expdte, $_POST['expdte']);

    $campos_aviso = ["aviso_fecha" => "fecha_recepcion", "aviso_desc" =>"descripcion"];
    $modifs_en_aviso = get_campos_modificados($expdte, $_POST['aviso'], $campos_aviso);
    

    if (!empty($modifs_en_aviso)){
        $update_string = implode(', ', $modifs_en_aviso);
        $sql_update_aviso = "UPDATE aviso SET {$update_string} WHERE id={$expdte['aviso_id']}";

        if (!$result = mysqli_query($bd, $sql_update_aviso)){
            $error = mysqli_error($bd);
            return ["content" => "Error al modificar aviso: {$error}", "type" => "warning"];
        }
    }

    if (!empty($modifs_en_expdte)){
        $update_string = implode(', ', $modifs_en_expdte);
        $sql_update_expdte = "UPDATE expediente SET {$update_string} WHERE id={$expdte['id']}";

        if (!$result = mysqli_query($bd, $sql_update_expdte)){
            $error = mysqli_error($bd);
            return ["content" => "Error al modificar expediente: {$error}", "type" => "warning"];
        }
    }

    return ["content" => "El expediente ha sido modificado con exito", "type" => "success"];

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
    <?php include("./includes/msg-box.php"); ?>

    <div class="row">
        <div class="col-md-8">
            <form action="<?="modificar-expediente.php?id={$id}"?>" method="POST">
                <div class="jumbotron p-4 d-flex justify-content-between">
                    <h4 class="m-0">Expediente ID: <?=$id?> - Agente: <?=$expdte['nom_agente']?></h4>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="">Fecha de inicio</label>
                        <input type="date" class="form-control" name="expdte[fecha_inicio]" value="<?=$expdte['fecha_inicio']?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="">Fecha de fin</label>
                        <input type="date" class="form-control" name="expdte[fecha_fin]" value="<?=$expdte['fecha_fin']?>" required>
                    </div>
                </div>
                <div class="card mb-3">
                    <h6 class="card-header">Datos del aviso</h6>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label for="" class="col-sm-2 form-label">Fecha de recepción</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" class="form-control" name="aviso[aviso_fecha]" 
                                value="<?=$expdte['aviso_fecha']?>" required />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="" class="col-sm-2 form-label">Descripción</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="aviso[aviso_desc]"><?=$expdte['aviso_desc']?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="col-sm-2 form-label">Documentación</label>
                    <div class="col-sm-10">
                        <select class="form-control form-control-sm" name="expdte[doc_justificada_id]">
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
                        <select class="form-control" name="expdte[codigo_id]" required>
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

        <div class="col-md-4">
            <?php foreach(get_p_prod_asociadas($conexion, $expdte['id']) as $nombre => $planillas): ?>
                <?php if (empty($planillas)) continue; ?>
                <div class="card border-primary mb-3">
                    <div class="card-header"><?="P.Productividad $nombre"?></div>
                    <div class="card-body">
                        <?php foreach ($planillas as list($mes, $anio)):?>
                            <span class="badge badge-info"><?="$mes - $anio"?></span>
                        <?php endforeach; ?>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include("../footer.html"); ?>