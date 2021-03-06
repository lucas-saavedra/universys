<?php 

    $ID_COD_SIN_AVISO = 2;

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

    function get_docs($bd){
        $sql = "SELECT doc.*, tj.descripcion as nom_tipo_just, p.nombre as agente_nombre, e.id as expediente_id  
        FROM documentacion_justificada as doc
        INNER JOIN tipo_justificacion as tj ON doc.tipo_justificacion_id=tj.id
        LEFT JOIN persona as p ON p.id = doc.persona_id
        LEFT JOIN expediente as e ON e.doc_justificada_id=doc.id";

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

    function get_p_prod($bd, $anio, $id_mes, $tipo){
        $sql = "SELECT p.*, mes.nombre FROM planilla_productividad_{$tipo} as p 
        LEFT JOIN mes on mes.id=mes_id where anio={$anio} and mes_id={$id_mes}";

        return mysqli_fetch_assoc(mysqli_query($bd, $sql));
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

    function get_inasis_expdte($bd, $id, $tipo){
        $sql = "
        SELECT
            e.id,
            COUNT(i.id) as cantidad
        FROM
            expediente_{$tipo} AS e
        LEFT JOIN inasistencia_sin_aviso_{$tipo} AS i
        ON
            e.id = i.expediente_{$tipo}_id
        GROUP BY
            e.id
        HAVING
            e.id={$id}
        ";

        return mysqli_fetch_assoc(mysqli_query($bd, $sql))['cantidad'];
    }

    function get_rel_planilla($bd, $id_planilla, $id_expdte, $tipo){
        $sql = "SELECT id from expediente_planilla_{$tipo} WHERE planilla_productividad_{$tipo}_id={$id_planilla} AND expediente_{$tipo}_id={$id_expdte}";

        return mysqli_fetch_array(mysqli_query($bd, $sql));

    }

    function get_expdtes_por_agente($bd, $id_planilla, $tipo){
        $sql = "SELECT e.*, et.id as expdte_{$tipo}_id, p.nombre as agente_nombre, p.cuil as agente_dni, 
                ta.total_horas as agente_hs, c.referencia as cod, ti.nombre as cod_tipo, c.descripcion as cod_desc, 
                c.con_descuento, epa.hs_descontadas
                FROM expediente as e 
                INNER JOIN expediente_{$tipo} as et ON e.id=et.expediente_id
                INNER JOIN persona as p on p.id=e.persona_id
                INNER JOIN {$tipo} as ta on ta.id=et.{$tipo}_id
                INNER JOIN codigo as c on c.id=e.codigo_id
                INNER JOIN tipo_inasistencia as ti on ti.id=c.tipo_inasistencia_id
                INNER JOIN expediente_planilla_{$tipo} epa on epa.expediente_{$tipo}_id=et.id
                WHERE epa.planilla_productividad_{$tipo}_id = {$id_planilla}
                ";
        
        $expdtes = mysqli_fetch_all(mysqli_query($bd, $sql), MYSQLI_ASSOC);

        $result = [];
        foreach ($expdtes as $expdte) {
            $result[$expdte['persona_id']][] = $expdte;
        }

        return $result;
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

    function get_catedra($bd,$catedra_id){
        $query_catedra = "SELECT *FROM catedra WHERE 
                             id ='$catedra_id'";
                            

        $result = mysqli_query($bd, $query_catedra);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    function get_hs_a_desc_expdte($bd, $expdte){
        if (!empty($expdte['expdte_docente_id'])){
            $sql = "SELECT hs_descontadas FROM expediente_planilla_docente where expediente_docente_id={$expdte['expdte_docente_id']} LIMIT 1 ";
        }
        else if (!empty($expdte['expdte_no_docente_id'])){
            $sql = "SELECT hs_descontadas FROM expediente_planilla_no_docente where expediente_no_docente_id={$expdte['expdte_no_docente_id']} LIMIT 1";
        }

        $result = mysqli_fetch_row(mysqli_query($bd, $sql));

        return $result ? $result[0] : 0;
    }

    
?>