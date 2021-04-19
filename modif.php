<?php

include('dataBase.php');

$dia = $_POST['dia'];
$hora = $_POST['hora'];


$query = "SELECT *FROM tablas WHERE id_dia='$dia' AND id_hora='$hora'";
$result = mysqli_query($conn,$query);


$json=array();
$row = mysqli_fetch_assoc($result);
        
    if($row['id_docente'] == null & $row['id_catedra'] == null ){
        $json[] = array(
            'hora'=> $row['id_hora'],
            'dia'=> $row['id_dia'],
            'docente' => $row['id_docente'],
            'catedra'=> $row['id_catedra']
            );

        $jsonstring = json_encode($json);
        echo $jsonstring;
        }else if($row['id_docente'] <> null & $row['id_catedra'] == null ){
            echo ' entro al docente';
            $query = "select id_hora, id_dia, docentes.nombre, catedras.nombre from tablas, catedras, docentes
            where (id_dia='$dia' and id_hora='$hora') and (tablas.id_docente=docentes.id)";
            $result = mysqli_query($conn,$query);

            $json=array();
            $row = mysqli_fetch_array($result);
                $json[] = array(
                    'hora'=> $row[0],
                    'dia'=> $row[1],
                    'docente' => $row[2],
                    'catedra'=> $row[3]
                    
                );


        }else if ($row['id_docente'] == null & $row['id_catedra'] != null ){

            $query = "select id_hora, id_dia, docentes.nombre, catedras.nombre from tablas, catedras, docentes
            where (id_dia='$dia' and id_hora='$hora') and ( tablas.id_catedra=catedras.id)";
            $result = mysqli_query($conn,$query);

            $json=array();
            $row = mysqli_fetch_array($result);
                $json[] = array(
                    'hora'=> $row[0],
                    'dia'=> $row[1],
                    'docente' => '',
                    'catedra'=> $row[3]
                    
                );
        }else{
            $query = "select id_hora, id_dia, docentes.nombre, catedras.nombre from tablas, catedras, docentes
            where (id_dia='$dia' and id_hora='$hora') and (tablas.id_docente=docentes.id and tablas.id_catedra=catedras.id)";
            $result = mysqli_query($conn,$query);

            $json=array();
            $row = mysqli_fetch_array($result);
                $json[] = array(
                    'hora'=> $row[0],
                    'dia'=> $row[1],
                    'docente' => $row[2],
                    'catedra'=> $row[3]
                    
                );

            $jsonstring = json_encode($json);
            echo $jsonstring;
            }
            
?>