<?php 
    function get_agentes($bd){
        $sql = "SELECT p.id, p.nombre, d.id AS docente_id, nd.id AS no_docente_id FROM 
        persona AS p 
        LEFT JOIN docente AS d ON d.persona_id=p.id 
        LEFT JOIN no_docente AS nd ON nd.persona_id=p.id";
        $result = mysqli_query($bd, $sql);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    function get_tipos_documentacion($bd){
        $sql = "SELECT id, descripcion FROM tipo_justificacion";
        $result = mysqli_query($bd, $sql);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    function get_codigos_inasis($bd, $where=1){
        $sql = "SELECT * FROM codigo WHERE $where";
        return mysqli_fetch_all(mysqli_query($bd, $sql), MYSQLI_ASSOC);
    }

    function get_docs_sin_expdte($bd, $expdte=null){

        $filter_agente = 1;
        $filter_expdte = 1;

        if (!is_null($expdte)){
            $filter_agente = "doc.persona_id={$expdte['persona_id']}";
            $filter_expdte = "id!={$expdte['id']}";
        }

        $sql = "SELECT doc.*, tj.descripcion as nom_tipo_just, p.nombre as agente_nombre FROM documentacion_justificada as doc 
        INNER JOIN tipo_justificacion as tj ON doc.tipo_justificacion_id=tj.id
        LEFT JOIN persona as p ON p.id = doc.persona_id
        WHERE $filter_agente and 
            doc.id not in (SELECT doc_justificada_id FROM expediente WHERE $filter_expdte and doc_justificada_id is not null);";
        
        $result = mysqli_query($bd, $sql);
        return mysqli_fetch_all(mysqli_query($bd, $sql), MYSQLI_ASSOC);
    }

    function get_expdte($bd, $id){
        $sql_expdte = "SELECT e.*, p.nombre as nom_agente, DATE_FORMAT(av.fecha_recepcion, '%Y-%m-%dT%T') as aviso_fecha, 
        av.descripcion as aviso_desc, av.validez as aviso_validez, doc.entrega_en_termino as doc_validez,
        ed.id as expdte_docente_id, e_nd.id as expdte_no_docente_id
        FROM expediente as e 
        LEFT JOIN aviso as av ON e.aviso_id=av.id
        LEFT JOIN persona as p ON e.persona_id=p.id
        LEFT JOIN documentacion_justificada as doc ON e.doc_justificada_id=doc.id
        LEFT JOIN expediente_docente as ed on e.id = ed.expediente_id 
        LEFT JOIN expediente_no_docente as e_nd on e.id=e_nd.expediente_id
        WHERE e.id={$id}";
        
        return mysqli_fetch_assoc(mysqli_query($bd, $sql_expdte));
    }

    function get_p_prod_docente($bd, $anio, $mes){
        $sql_planilla = "SELECT * FROM planilla_productividad_docente where anio={$anio} and mes_id={$mes}";
        return mysqli_fetch_assoc(mysqli_query($bd, $sql_planilla));
    }

    function get_p_prod_no_docente($bd, $anio, $mes){
        $sql_planilla = "SELECT * FROM planilla_productividad_no_docente where anio={$anio} and mes_id={$mes}";
        return mysqli_fetch_assoc(mysqli_query($bd, $sql_planilla));
    }

    function get_p_prod_asociadas($bd, $id_expdte){
        $sql_docente = "SELECT pp.mes_id, pp.anio FROM expediente_planilla_docente as ep 
        LEFT JOIN expediente_docente as ed ON ep.expediente_docente_id=ed.id
        LEFT JOIN planilla_productividad_docente as pp ON ep.planilla_productividad_docente_id=pp.id
        WHERE ed.expediente_id={$id_expdte}";

        $sql_no_docente = "SELECT pp.mes_id, pp.anio FROM expediente_planilla_no_docente as ep 
        LEFT JOIN expediente_no_docente as ed ON ep.expediente_no_docente_id=ed.id
        LEFT JOIN planilla_productividad_no_docente as pp ON ep.planilla_productividad_no_docente_id=pp.id
        WHERE ed.expediente_id={$id_expdte}";

        return [
            'Docente' => mysqli_fetch_all(mysqli_query($bd, $sql_docente), MYSQLI_NUM),
            'No docente' => mysqli_fetch_all(mysqli_query($bd, $sql_no_docente), MYSQLI_NUM),
        ];
    }

    function get_codigo_cupos($bd, $id_codigo){
        $sql = "SELECT cantidad_max_dias, tipo, longitud FROM cupo WHERE codigo_id={$id_codigo}";
        return mysqli_fetch_all(mysqli_query($bd, $sql), MYSQLI_ASSOC);
    }

    function get_meses($bd, $id_mes=null){

        $where = isset($id_mes) ? "id={$id_mes}": "1";

        $sql = "SELECT * FROM mes where $where";

        return mysqli_fetch_all(mysqli_query($bd, $sql), MYSQLI_ASSOC);
    }



////////////////////////              ALE             ///////////////////////////

    function get_jornada_docente($bd,$docente){
        $query_jornada_docente = "SELECT *FROM jornada_docente WHERE docente_id = '$docente'";
        $result = mysqli_query($bd, $query_jornada_docente);
       
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
       
    }
    function get_jornada_no_docente($bd,$no_docente){
        $query_jornada_no_docente = "SELECT *FROM jornada_no_docente WHERE no_docente_id = '$no_docente'";
        $result = mysqli_query($bd, $query_jornada_no_docente);
       
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
       
    }

    function get_jornada($bd,$jornada){
        $query_jornada ="SELECT *FROM jornada WHERE id='$jornada'";
        $result = mysqli_query($bd, $query_jornada);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    function get_det_jornada($bd,$jornada_id,$hora_inicio,$hora_fin,$dia){
        $query_det_jornada = "SELECT *FROM detalle_jornada WHERE 
                             jornada_id ='$jornada_id' AND 
                             hora_inicio ='$hora_inicio' AND
                             hora_fin ='$hora_fin' AND
                             dia ='$dia'";

        $result = mysqli_query($bd, $query_det_jornada);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }



    
?>