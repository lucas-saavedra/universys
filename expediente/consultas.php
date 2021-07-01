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
        $sql_expdte = "SELECT e.*, p.nombre as nom_agente FROM expediente as e 
        INNER JOIN persona as p ON e.persona_id=p.id and e.id={$id}";

        return mysqli_fetch_assoc(mysqli_query($bd, $sql_expdte));
    }

?>