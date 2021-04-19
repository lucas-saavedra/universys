<?php
    include('dataBase.php');


    $query = "SELECT *FROM docentes ";
    $result = mysqli_query($conn,$query);

    
    while($row = mysqli_fetch_array($result)) {
    
    $json[] = array(
        'id'=>$row['id'],
        'nombre'=> $row['nombre']
    );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>