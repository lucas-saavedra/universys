<?php  

function get_meses_entre_fechas( $start, $end ){
    $start = strtotime($start);
    $end = strtotime($end);

    $current = $start;
    $meses = array();

    while($current <= $end){
        $meses[] = [date("Y", $current), date("n", $current)];
        $next = date('Y-M-01', $current) . "+1 month";
        $current = strtotime($next);
    }

    return $meses;
}

function crear_p_prod($bd, $anio, $mes, $tipo){

    if ($tipo === 'docente'){
        $sql_insert = "INSERT INTO planilla_productividad_docente(anio, mes_id) VALUES ({$anio}, {$mes})";
    }

    if ($tipo === 'no docente'){
        $sql_insert = "INSERT INTO planilla_productividad_no_docente(anio, mes_id) VALUES ({$anio}, {$mes})";
    }

    if (!$result = mysqli_query($bd, $sql_insert)){
        $error = mysqli_error($bd);
        throw new Exception("Error al crear planilla de productividad {$tipo} mes {$mes} año {$anio}: {$error}");
    }

    return mysqli_insert_id($bd);
}


function asignar_expdte_a_planillas_prod($bd, $id_expdte){

    $expdte = get_expdte($bd, $id_expdte);
    $hs_desc = get_hs_a_desc_expdte($bd, $expdte);
    $meses = get_meses_entre_fechas($expdte['fecha_inicio'], $expdte['fecha_fin']);

    if (!empty($expdte['expdte_docente_id'])){
        $rel_ids = [];
        foreach ($meses as list($anio, $mes)) {

            if (!$planilla = get_p_prod($bd, $anio, $mes, 'docente')){
                $id_planilla = crear_p_prod($bd, $anio, $mes, 'docente');
            }
            else{
                $id_planilla = $planilla['id'];
            }

            $rel_existente = get_rel_planilla($bd, $id_planilla, $expdte['expdte_docente_id'], 'docente');

            if ($rel_existente){
                $rel_ids[] = $rel_existente['id'];
            }
            else{
                $sql_insert = "INSERT INTO expediente_planilla_docente (planilla_productividad_docente_id, expediente_docente_id, hs_descontadas)
                VALUES ({$id_planilla}, {$expdte['expdte_docente_id']}, {$hs_desc})";
    
                if (!$result = mysqli_query($bd, $sql_insert)){
                    $error = mysqli_error($bd);
                    throw new Exception("Error al asignar expdte a planilla: {$error}");
                }

                $rel_ids[] = mysqli_insert_id($bd);
            }

        }

        $expdte_planilla_ids = implode(',',$rel_ids);
        mysqli_query($bd, "DELETE FROM expediente_planilla_docente WHERE expediente_docente_id={$expdte['expdte_docente_id']} AND id NOT IN ({$expdte_planilla_ids})");
    }

    if (!empty($expdte['expdte_no_docente_id'])){
        $rel_ids = [];
        foreach ($meses as list($anio, $mes)) {

            if (!$planilla = get_p_prod($bd, $anio, $mes, 'no_docente')){
                $id_planilla = crear_p_prod($bd, $anio, $mes, 'no docente');
            }
            else{
                $id_planilla = $planilla['id'];
            }

            $rel_existente = get_rel_planilla($bd, $id_planilla, $expdte['expdte_no_docente_id'], 'no_docente');

            if ($rel_existente){
                $rel_ids[] = $rel_existente['id'];
            }
            else{
                $sql_insert = "INSERT INTO expediente_planilla_no_docente 
                (planilla_productividad_no_docente_id, expediente_no_docente_id, hs_descontadas)
                VALUES ({$id_planilla}, {$expdte['expdte_no_docente_id']}, {$hs_desc})";
    
                if (!$result = mysqli_query($bd, $sql_insert)){
                    $error = mysqli_error($bd);
                    throw new Exception("Error al asignar expdte a planilla: {$error}");
                }

                $rel_ids[] = mysqli_insert_id($bd);
            }

            
        }

        $expdte_planilla_ids = implode(',',$rel_ids);
        mysqli_query($bd, "DELETE FROM expediente_planilla_no_docente WHERE expediente_no_docente_id={$expdte['expdte_no_docente_id']} AND id NOT IN ({$expdte_planilla_ids})");
    }
}

?>