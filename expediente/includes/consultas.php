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

    function get_codigos_inasis($bd){
        $sql = "SELECT id, nombre, referencia FROM codigo";
        $result = mysqli_query($bd, $sql);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    function get_docs_sin_expdte($bd, $expdte){
        $id_agente = $expdte['persona_id'];
        $id_expdte = $expdte['id'];

        $sql = "SELECT doc.*, tj.descripcion as nom_tipo_just FROM documentacion_justificada as doc 
        INNER JOIN tipo_justificacion as tj ON doc.tipo_justificacion_id=tj.id 
        WHERE doc.persona_id={$id_agente} and 
            doc.id not in (SELECT doc_justificada_id FROM expediente WHERE id != {$id_expdte} and doc_justificada_id is not null);";
        
        $result = mysqli_query($bd, $sql);
        return mysqli_fetch_all(mysqli_query($bd, $sql), MYSQLI_ASSOC);
    }

    function get_expdte($bd, $id){
        $sql_expdte = "SELECT e.*, p.nombre as nom_agente, DATE_FORMAT(av.fecha_recepcion, '%Y-%m-%dT%T') as aviso_fecha, 
        av.descripcion as aviso_desc 
        FROM expediente as e 
        LEFT JOIN aviso as av ON e.aviso_id=av.id
        LEFT JOIN persona as p ON e.persona_id=p.id
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

?>