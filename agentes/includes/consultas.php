<?php 

    function crear_roles($bd, $id_agente, $rol_ids){
        $rol_vals = [];
        foreach ($rol_ids as $id_rol){
            $rol_vals[] = "($id_agente, $id_rol)";
        }

        $str_vals = implode(',', $rol_vals);

        $insert_roles = "INSERT INTO persona_rol (persona_id, rol_id) VALUES {$str_vals}";

        if (!$result= mysqli_query($bd, $insert_roles)){
            throw new Exception(mysqli_error($bd));
        }
    }

    function _get_agente($bd, $id){
        $where = isset($id) ? "p.id=$id" : '1';
        $sql = "
        SELECT
            p.id,
            nombre,
            email,
            cuil,
            sexo,
            telefono,
            direccion,
            d.id AS id_docente,
            nd.id AS id_no_docente,
            d.total_horas as hs_docente,
            nd.total_horas as hs_no_docente
        FROM
            persona AS p
        LEFT JOIN docente AS d
        ON
            p.id = d.persona_id
        LEFT JOIN no_docente AS nd
        ON
            p.id = nd.persona_id
        WHERE {$where}
        ";
    
        return isset($id) 
        ? mysqli_fetch_assoc(mysqli_query($bd, $sql))
        : mysqli_fetch_all(mysqli_query($bd, $sql), MYSQLI_ASSOC);

    }

?>