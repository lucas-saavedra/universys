<?php include ("../includes/header.php");?>
<?php include('../dataBase.php');?>

<?php 

//                                          JORNADA DOCENTE

$fecha = date("Y-n-j");
$sol = (strtotime($fecha) - 3600);
$fecha_anterior = date("Y-n-j", $sol);
echo ($fecha_anterior);
$query_fecha_dia = "select weekday ('$fecha_anterior')";
$result_fecha_dia = mysqli_query($conexion,$query_fecha_dia);
while($row_fecha_dia = mysqli_fetch_array($result_fecha_dia)) {
    $fecha_dia= $row_fecha_dia[0];
}

    $query_jornada_docente = "SELECT DISTINCT docente_id,jornada_id, catedra_id FROM jornada_docente";
    $result_jornada_docente = mysqli_query($conexion,$query_jornada_docente);
    while ($row_jornada_docente = mysqli_fetch_array($result_jornada_docente)){
        $docente =  $row_jornada_docente['docente_id'];
        $jornada = $row_jornada_docente['jornada_id'];

        $query_jornada = "SELECT *FROM jornada WHERE id='$jornada'";
        $result_jornada = mysqli_query($conexion,$query_jornada);
        while ($row_jornada = mysqli_fetch_array($result_jornada)){
            $fecha_inicio = $row_jornada['fecha_inicio'];
            $fecha_fin = $row_jornada['fecha_fin'];
        }


            if (strtotime($fecha_inicio) < strtotime($fecha_anterior) and strtotime($fecha_fin) > strtotime($fecha_anterior)){
                $query_detalle_jornada = "SELECT *FROM detalle_jornada WHERE jornada_id = '$jornada' and dia='$fecha_dia'";
                $result_detalle_jornada = mysqli_query($conexion,$query_detalle_jornada);
                while ($row_detalle_jornada = mysqli_fetch_array($result_detalle_jornada)){
                    $id_detalle=$row_detalle_jornada['id'];
                    $hora_inicio= $row_detalle_jornada['hora_inicio'];
                    $hora_fin= $row_detalle_jornada['hora_fin'];
                    $query_asistencia = "SELECT *FROM asistencia_docente WHERE detalle_jornada_id = '$id_detalle' AND fecha = '$fecha_anterior' and docente_id='$docente'";
                    $result_asistencia = mysqli_query($conexion,$query_asistencia);
                    if (mysqli_num_rows($result_asistencia) == 0){

                        $query_inasistencia = "SELECT *FROM inasistencia_sin_aviso_docente WHERE 
                        fecha='$fecha_anterior' AND docente_id='$docente' AND hora_inicio='$hora_inicio' AND hora_fin='$hora_fin'";
                         $result_inasistencia = mysqli_query($conexion,$query_inasistencia);
                         if (mysqli_num_rows($result_inasistencia) == 0){

                            $insert_falta = "INSERT INTO inasistencia_sin_aviso_docente (docente_id,fecha,hora_inicio,hora_fin,dia) 
                                                    VALUES('$docente','$fecha_anterior','$hora_inicio','$hora_fin','$fecha_dia')";
                            if (($result_insert_falta = mysqli_query($conexion,$insert_falta)) === false) {
                            die(mysqli_error($conexion));  
                            }
                        }else{
                          
                        }
                    }else{
                           
                        }

                }
            }
        
    }

////////////////////////////////////////////

//                                          JORNADA NO DOCENTE

$query_jornada_no_docente = "SELECT DISTINCT no_docente_id,jornada_id, area_id FROM jornada_no_docente";
$result_jornada_no_docente = mysqli_query($conexion,$query_jornada_no_docente);
while ($row_jornada_no_docente = mysqli_fetch_array($result_jornada_no_docente)){
    $no_docente =  $row_jornada_no_docente['no_docente_id'];
    $jornada = $row_jornada_no_docente['jornada_id'];

    $query_jornada = "SELECT *FROM jornada WHERE id='$jornada'";
    $result_jornada = mysqli_query($conexion,$query_jornada);
    while ($row_jornada = mysqli_fetch_array($result_jornada)){
        $fecha_inicio = $row_jornada['fecha_inicio'];
        $fecha_fin = $row_jornada['fecha_fin'];
    }


        if (strtotime($fecha_inicio) < strtotime($fecha_anterior) and strtotime($fecha_fin) > strtotime($fecha_anterior)){
            $query_detalle_jornada = "SELECT *FROM detalle_jornada WHERE jornada_id = '$jornada' and dia='$fecha_dia'";
            $result_detalle_jornada = mysqli_query($conexion,$query_detalle_jornada);
            while ($row_detalle_jornada = mysqli_fetch_array($result_detalle_jornada)){
                $id_detalle=$row_detalle_jornada['id'];
                $hora_inicio= $row_detalle_jornada['hora_inicio'];
                $hora_fin= $row_detalle_jornada['hora_fin'];
                $query_asistencia = "SELECT *FROM asistencia_no_docente WHERE detalle_jornada_id = '$id_detalle' AND fecha = '$fecha_anterior' and no_docente_id='$no_docente'";
                $result_asistencia = mysqli_query($conexion,$query_asistencia);
                if (mysqli_num_rows($result_asistencia) == 0){

                    $query_inasistencia = "SELECT *FROM inasistencia_sin_aviso_no_docente WHERE 
                    fecha='$fecha_anterior' AND no_docente_id='$no_docente' AND hora_inicio='$hora_inicio' AND hora_fin='$hora_fin'";
                     $result_inasistencia = mysqli_query($conexion,$query_inasistencia);
                     if (mysqli_num_rows($result_inasistencia) == 0){

                        $insert_falta = "INSERT INTO inasistencia_sin_aviso_no_docente (no_docente_id,fecha,hora_inicio,hora_fin,dia) 
                                                VALUES('$no_docente','$fecha_anterior','$hora_inicio','$hora_fin','$fecha_dia')";
                        if (($result_insert_falta = mysqli_query($conexion,$insert_falta)) === false) {
                        die(mysqli_error($conexion));  
                        }
                    }else{
                        
                    }
                }else{
                        
                    }

            }
        }
    
}


///////////////////////////////////////////////

//                                  JORNADA MESA DE EXAMEN


$query_jornada_docente = "SELECT DISTINCT docente_id, det_jornada_id, mesa_examen_id FROM jornada_docente_mesa";
$result_jornada_docente = mysqli_query($conexion,$query_jornada_docente);
while ($row_jornada_docente = mysqli_fetch_array($result_jornada_docente)){
    $docente =  $row_jornada_docente['docente_id'];
    $detalle_jornada = $row_jornada_docente['det_jornada_id'];
    $mesa_examen = $row_jornada_docente['mesa_examen_id'];
  

    $query_mesa = "SELECT jornada_id FROM mesa_examen WHERE id = '$mesa_examen'";
    $result_mesa = mysqli_query($conexion,$query_mesa);
    while ($row_mesa = mysqli_fetch_array($result_mesa)){ 
        $jornada =  $row_mesa['jornada_id'];
           
    }
        $query_jornada = "SELECT *FROM jornada WHERE id='$jornada'";
        $result_jornada = mysqli_query($conexion,$query_jornada);
        while ($row_jornada = mysqli_fetch_array($result_jornada)){
            $fecha_inicio = $row_jornada['fecha_inicio'];
            $fecha_fin = $row_jornada['fecha_fin'];
            
        }


            if (strtotime($fecha_inicio) < strtotime($fecha_anterior) and strtotime($fecha_fin) > strtotime($fecha_anterior)){
                
                $query_detalle_jornada = "SELECT *FROM detalle_jornada WHERE id = '$detalle_jornada' AND dia='$fecha_dia'";
                $result_detalle_jornada = mysqli_query($conexion,$query_detalle_jornada);
                while ($row_detalle_jornada = mysqli_fetch_array($result_detalle_jornada)){
                    $hora_inicio= $row_detalle_jornada['hora_inicio'];
                    $hora_fin= $row_detalle_jornada['hora_fin'];
                    echo ('detalle jornada');
                    $query_asistencia = "SELECT *FROM asistencia_docente WHERE detalle_jornada_id = '$detalle_jornada' AND fecha = '$fecha_anterior' and docente_id='$docente'";
                    $result_asistencia = mysqli_query($conexion,$query_asistencia);
                    if (mysqli_num_rows($result_asistencia) == 0){
                       

                        $query_inasistencia = "SELECT *FROM inasistencia_sin_aviso_docente WHERE 
                        fecha='$fecha_anterior' AND docente_id='$docente' AND hora_inicio='$hora_inicio' AND hora_fin='$hora_fin'";
                        $result_inasistencia = mysqli_query($conexion,$query_inasistencia);
                        if (mysqli_num_rows($result_inasistencia) == 0){
                           

                            $insert_falta = "INSERT INTO inasistencia_sin_aviso_docente (docente_id,fecha,hora_inicio,hora_fin,dia) 
                                                    VALUES('$docente','$fecha_anterior','$hora_inicio','$hora_fin','$fecha_dia')";
                            if (($result_insert_falta = mysqli_query($conexion,$insert_falta)) === false) {
                            die(mysqli_error($conexion));  
                            }
                        }else{
                            
                        }
                    }else{
                           
                        }

                }
            }
        
}
    header("Location: crear-expediente-sin-aviso.php");
?>