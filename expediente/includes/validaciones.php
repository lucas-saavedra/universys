<?php 

include_once('./includes/consultas.php');

function validar_codigo($bd, $id_expdte){
    $expdte = get_expdte($bd, $id_expdte);

    if (!$expdte['confirmado']) return;

    $codigo = get_codigos_inasis($bd, "id={$expdte['codigo_id']}")[0];

    if ($codigo['requiere_aviso'] && !$expdte['aviso_validez']){
        throw new Exception('Error al validar código: El codigo requiere un aviso válido.');
    }

    if ($codigo['requiere_doc'] && !$expdte['doc_validez']){
        throw new Exception('Error al validar código: El codigo requiere una documentación válida.');
    }
}

// Para validar aviso y documentacion tomo solo las fechas, no las horas y minutos

function validar_aviso($bd, $id_expdte){
    $expdte = get_expdte($bd, $id_expdte);

    if (empty($expdte['aviso_id'])) return false;


    $fecha_aviso = datetime_to_date($expdte['aviso_fecha']);
    $fecha_expdte = strtotime($expdte['fecha_inicio']);

    if ($fecha_aviso <= $fecha_expdte){
        mysqli_query($bd, "UPDATE aviso SET validez=1 WHERE id={$expdte['aviso_id']}");
        return true;
    }

    mysqli_query($bd, "UPDATE aviso SET validez=0 WHERE id={$expdte['aviso_id']}");
    return false;
}

function validar_documentacion($bd, $id_expdte){
    $sql = "SELECT fecha_inicio, doc_justificada_id, doc.fecha_recepcion as fecha_doc FROM expediente as e
    LEFT JOIN documentacion_justificada as doc ON e.doc_justificada_id=doc.id
    WHERE e.id={$id_expdte}";

    $expdte = mysqli_fetch_assoc(mysqli_query($bd, $sql));

    if (empty($expdte['doc_justificada_id'])) return false;

    $fecha_limite = proximo_dia_habil($expdte['fecha_inicio']);
    $fecha_doc = datetime_to_date($expdte['fecha_doc']);

    if ($fecha_doc <= $fecha_limite){
        mysqli_query($bd, "UPDATE documentacion_justificada SET entrega_en_termino=1 WHERE id={$expdte['doc_justificada_id']}");
        return true;
    }

    mysqli_query($bd, "UPDATE documentacion_justificada SET entrega_en_termino=0 WHERE id={$expdte['doc_justificada_id']}");
    return false;

}

function proximo_dia_habil($fecha){
    return strtotime("+1 weekday", strtotime($fecha));
}

function datetime_to_date($fecha){
    return strtotime(date("Y-m-d", strtotime($fecha)));
}


?>