<?php

include("dataBase.php");
$dia = $_POST['dia'];
$hora = $_POST['hora'];


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

?>