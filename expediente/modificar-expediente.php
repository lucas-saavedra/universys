<title>Modificar Expediente</title>
<?php 

include ("../jornada/navbar.php");
include ("./includes/consultas.php");
include ("./includes/validaciones.php");
include ("./includes/asignar-planilla-prod.php");


if (isset($_GET['id']) && $id = intval($_GET['id'])){
    $expdte = get_expdte($conexion, $id);
}

if (!isset($expdte)) return;


function get_campos_modificados($array1, $array2, $convertir=array()){
    $campos = array_keys($array2);
    $modificaciones = [];

    foreach ($campos as $campo) {
        $converted = empty($convertir[$campo]) ? $campo: $convertir[$campo];
        if ($array1[$campo] != $array2[$campo]){
            if ($array2[$campo] === ""){
                $modificaciones[$campo] = "{$converted}=NULL";
                continue;
            }
            $modificaciones[$converted] = "{$converted}='{$array2[$campo]}'";
        }
    }

    return $modificaciones;
}
// ale //
function get_campos_ant_modificados($array1, $array2, $convertir=array()){
    $campos = array_keys($array2);
    $modificaciones = [];

    foreach ($campos as $campo) {
        $converted = empty($convertir[$campo]) ? $campo: $convertir[$campo];
        if ($array1[$campo] != $array2[$campo]){
            if ($array2[$campo] === ""){
                $modificaciones[$campo] = "{$converted}=NULL";
                continue;
            }
            $modificaciones[$converted] = "{$converted}='{$array1[$campo]}'";
        }
    }

    return $modificaciones;
}
//----------------------------------------//
function modificar_expdte($bd, $expdte){
    $modifs_en_expdte = get_campos_modificados($expdte, $_POST['expdte']);

    $campos_aviso = ["aviso_fecha" => "fecha_recepcion", "aviso_desc" =>"descripcion"];
    $modifs_en_aviso = get_campos_modificados($expdte, $_POST['aviso'], $campos_aviso);

    mysqli_query($bd, 'START TRANSACTION');

    try {
        if (!empty($modifs_en_aviso)){
            $update_string = implode(', ', $modifs_en_aviso);
            $sql_update_aviso = "UPDATE aviso SET {$update_string} WHERE id={$expdte['aviso_id']}";
    
            if (!$result = mysqli_query($bd, $sql_update_aviso)){
                $error = mysqli_error($bd);
                throw new Exception("Error al modificar aviso: {$error}");
            }
        }
    
        if (!empty($modifs_en_expdte)){
            $ant_modifs = get_campos_ant_modificados($expdte, $_POST['expdte']);
            $update_string = implode(', ', $modifs_en_expdte);


            if (!empty($ant_modifs)){
                $ant_update_string = implode(', ', $ant_modifs);
                $dia = date("Y-m-d H:i:s");
                $cambios= $expdte['cambios'];
                $modif = $cambios . '\n'.'Modificaci??n del '. date("Y-m-d"). '\n(';
                $largo = strlen($ant_update_string);
                for ($x=0; $x <  $largo; $x++) {
                    if ($ant_update_string[$x]== "'"){

                    }else{
                        $modif = $modif . $ant_update_string[$x];
                    }
                }
            }
            $modif = $modif .').';
            $sql_update_expdte = "UPDATE expediente SET {$update_string}, cambios='$modif', ult_cambio='$dia' WHERE id={$expdte['id']}";
            
            if (!$result = mysqli_query($bd, $sql_update_expdte)){
                $error = mysqli_error($bd);
                throw new Exception("Error al modificar expediente: {$error}");
            }
        
        }

        // Actualizacion de las hs a descontar
        $hs_desc_actual = get_hs_a_desc_expdte($bd, $expdte);
        $hs_desc_modificadas = isset($_POST['hs_descontadas']) && $hs_desc_actual != $_POST['hs_descontadas'];
        
        if ($hs_desc_modificadas){
            update_hs_descontar($bd, $expdte, $_POST['hs_descontadas']);
            $hs_modif_string = "\nModificacion del ". date("Y-m-d"). " (hs_descontadas={$hs_desc_actual})";
            mysqli_query(
                $bd, 
                "UPDATE expediente SET cambios=CONCAT(IFNULL(cambios, ''), '{$hs_modif_string}') WHERE id={$expdte['id']}"
            );
        }
        
        $modificacion_fechas_expdte = isset($modifs_en_expdte['fecha_inicio']) || isset($modifs_en_expdte['fecha_fin']);
        $aviso_revalidado = false;
        $doc_revalidada = false;

        if (isset($modifs_en_aviso['fecha_recepcion']) || $modificacion_fechas_expdte){
            validar_aviso($bd, $expdte['id']);
            $aviso_revalidado = true;
        }

        if (isset($modifs_en_expdte['doc_justificada_id']) || $modificacion_fechas_expdte){
            validar_documentacion($bd, $expdte['id']);
            $doc_revalidada = true;
        }

        if (isset($modifs_en_expdte['confirmado']) || isset($modifs_en_expdte['codigo_id']) || $aviso_revalidado || $doc_revalidada){
            validar_codigo($bd, $expdte['id']);
        }

        if ($modificacion_fechas_expdte){
            on_update_fechas_expdte($bd, $expdte['id']);
        }
        mysqli_commit($bd);
    }
    catch (Exception $e){
        mysqli_rollback($bd);
        return ['content' => $e->getMessage(), 'type' => 'danger'];
    }
    
    return ["content" => "El expediente ha sido modificado con exito", "type" => "success"];

}

function update_hs_descontar($bd, $expdte, $valor){

    if (!empty($expdte['expdte_docente_id'])){
        mysqli_query($bd, "UPDATE expediente_planilla_docente SET hs_descontadas={$valor} 
        WHERE expediente_docente_id={$expdte['expdte_docente_id']}");
    }

    if (!empty($expdte['expdte_no_docente_id'])){
        mysqli_query($bd, "UPDATE expediente_planilla_no_docente SET hs_descontadas={$valor} 
        WHERE expediente_no_docente_id={$expdte['expdte_no_docente_id']}");
    }
}

function on_update_fechas_expdte($bd, $id_expdte){
    asignar_expdte_a_planillas_prod($bd, $id_expdte);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $msg = modificar_expdte($conexion, $expdte);

    $expdte = get_expdte($conexion, $expdte['id']);
}

$filtros = [];
if (!is_null($expdte['expdte_docente_id'])) $filtros[] = "es_docente=1";
if (!is_null($expdte['expdte_no_docente_id'])) $filtros[] = "es_no_docente=1";
$filtros[] = "id!={$ID_COD_SIN_AVISO}";

$codigos = get_codigos_inasis($conexion, implode(' AND ', $filtros));
$cod_sin_aviso = get_codigos_inasis($conexion, "id={$ID_COD_SIN_AVISO}")[0];

// En los expedientes con el codigo sin aviso hay campos q no se pueden modificar

if ($expdte['codigo_id'] == $cod_sin_aviso['id']){
    $cod_del_expdte = $cod_sin_aviso;
    $readonly = 'readonly';
}
else{
    $idx_cod_expdte = array_search($expdte['codigo_id'], array_column($codigos, 'id'));
    $cod_del_expdte = $codigos[$idx_cod_expdte];
    $readonly = '';
}


?>

<div class="container">
    <div class="row my-4">
        <div class="col">
            <h3>
                Modificar expediente (ID: <?=$id?>)
                <?php if ($expdte['confirmado']): ?>
                    <span class="badge badge-info">Confirmado</span>
                <?php endif; ?>
                <?php if ($expdte['expdte_docente_id']): ?>
                    <span class="badge badge-secondary">Docente</span>
                <?php endif; ?>
                <?php if ($expdte['expdte_no_docente_id']): ?>
                    <span class="badge badge-secondary">No docente</span>
                <?php endif; ?>
                <?php if ($expdte['cupo_superado']): ?>
                    <span class="badge badge-warning">Cupo superado</span>
                <?php endif; ?>
            </h3>
        </div>
    </div>
    <?php include("./includes/msg-box.php"); ?>

    <div class="row">
        <div class="col-md-8">
            <div class="jumbotron p-4 d-flex justify-content-between mb-3">
                <h4 class="m-0">
                    Agente: <?=$expdte['nom_agente']?>
                </h4>
            </div>
            <form action="<?="modificar-expediente.php?id={$id}"?>" method="POST">
                <?php if (!$expdte['confirmado']): ?>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="alert alert-info">
                                <i class="fa fa-info fa-lg mr-2"></i>
                                El expediente no est?? confirmado. Confirme para validar el c??digo 
                                <button type="submit" value="1" name="expdte[confirmado]" class="btn btn-primary ml-2">Confirmar</button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="">Fecha de inicio</label>
                        <input type="date" class="form-control" name="expdte[fecha_inicio]" value="<?=$expdte['fecha_inicio']?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="">Fecha de fin</label>
                        <input type="date" class="form-control" name="expdte[fecha_fin]" value="<?=$expdte['fecha_fin']?>" required>
                    </div>
                    <input type="hidden" name="expdte[id]" value="<?=$expdte['id']?>">
                    <input type="hidden" name="expdte[persona_id]" value="<?=$expdte['persona_id']?>">
                </div>
                <div class="card mb-3">
                    <h5 class="card-header">
                        Aviso
                        <?php if ($expdte['aviso_validez']): ?>
                            <span class="badge badge-success">
                                V??lido
                            </span>
                        <?php else: ?>
                            <span class="badge badge-danger">
                                No v??lido
                            </span>
                        <?php endif; ?>
                    </h5>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label for="" class="col-sm-2 form-label">Fecha de recepci??n</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" class="form-control" name="aviso[aviso_fecha]" 
                                value="<?=$expdte['aviso_fecha']?>" <?=$readonly?> required/>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="" class="col-sm-2 form-label">Descripci??n</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="aviso[aviso_desc]" <?=$readonly?>><?=$expdte['aviso_desc']?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="col-sm-2 form-label">Documentaci??n</label>
                    <div class="col-sm-8">
                        <select class="form-control form-control-sm" name="expdte[doc_justificada_id]" <?=$readonly?>>
                            <option value="" <?=!$expdte['doc_justificada_id'] ? 'selected': ''?>></option>

                            <?php foreach(get_docs_sin_expdte($conexion, $expdte) as $doc): ?>
                                <option value="<?=$doc['id']?>" <?=$doc['id'] === $expdte['doc_justificada_id'] ? 'selected': ''?>>
                                    <?="{$doc['id']} / ". date("d-m-Y", strtotime($doc['fecha_recepcion'])). " - {$doc['nom_tipo_just']}"?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-2 d-flex align-items-center">
                        <h5 class="m-0">
                            <?php if ($expdte['doc_validez']): ?>
                                <span class="badge badge-success">V??lida</span>
                            <?php else: ?>
                                <span class="badge badge-danger">No v??lida</span>
                            <?php endif; ?>
                        </h5>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="col-sm-2 form-label">C??digo</label>
                    <div class="col-sm-7">
                        <?php if (!$readonly): ?>
                            <select class="form-control" name="expdte[codigo_id]" required>
                                <?php if (!$expdte['codigo_id']): ?>
                                    <option value="" selected disabled>Seleccione un c??digo</option>
                                <?php endif; ?>

                                <?php foreach ($codigos as $codigo):?>
                                    <option value="<?=$codigo['id']?>" <?=$codigo['id'] === $expdte['codigo_id'] ? 'selected': ''?>>
                                        <?="{$codigo['referencia']} - {$codigo['nombre']}"?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php else: ?>
                            <select class="form-control" name="expdte[codigo_id]" required readonly>
                                <option value="<?=$cod_sin_aviso['id']?>"><?=$cod_sin_aviso['nombre']?></option>
                            </select>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-3 d-flex align-items-center">
                        <div class="form-check">
                            <input type="hidden" name="expdte[cupo_superado]" value="<?=$expdte['cupo_superado']?>">
                            <input class="form-check-input" type="checkbox" id="check-cupo" disabled <?=$expdte['cupo_superado'] ? 'checked': ''?>>
                            <label class="form-check-label">
                                Cupo superado
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row" >
                    <div class="col" id="info-cupo"></div>
                </div>

                <?php if ($cod_del_expdte['con_descuento'] || $expdte['cupo_superado']):?>
                    <div class="row mb-3">
                        <label for="input-hs" class="col-sm-2 form-label">Hs. desc.</label>
                        <div class="col-auto">
                            <input class="form-control" type="number" name="hs_descontadas" id="input-hs" placeholder="Hs a descontar" value=<?=get_hs_a_desc_expdte($conexion, $expdte)?>>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="mb-3 row">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Modificar</button>
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

            <div class="card border-primary mb-3">
                <div class="card-header">Ultima actualizaci??n</div>
                    <div class="card-body">
                            <span class="badge badge-info"><?php echo $expdte['ult_cambio']?></span>
                    </div>
                </div> 
                <div class="card border-primary mb-3">
                    <div class="card-header">Modificaciones</div>
                            <textarea rows="18" cols="40" readonly><?php echo $expdte['cambios']?></textarea>
                    </div> 
            </div>                    
        </div>
    </div>
</div>

<script src="./js/verificar_cupo.js"></script>
<?php include("../includes/footer.php"); ?>