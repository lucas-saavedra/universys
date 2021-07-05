  <?php
  include('../includes/db.php');
  $catedraId = $_POST['catedraId'];
  $json = array();

  if (!empty($catedraId)) {
    $query = "SELECT catedra.id as id ,catedra.nombre as nombre, carrera.nombre as carrera,periodo.nombre as periodo, anio_plan.nombre as anio FROM catedra
    LEFT JOIN carrera ON catedra.carrera_id  = carrera.id
    LEFT JOIN periodo ON catedra.periodo_id = periodo.id
    LEFT JOIN anio_plan ON catedra.anio_plan_id = anio_plan.id
    WHERE catedra.id = $catedraId";
    $result= mysqli_query($conexion, $query);
    if(!$result){
      die('Falló');
    }
    while ($row = mysqli_fetch_array($result)) {
      $json[] = array(
        'id' => $row['id'],
        'nombre' => $row['nombre'],
        'carrera' => $row['carrera'],
        'periodo' => $row['periodo'],
        'anio' => $row['anio']
      );
    }
  }
  $jsonstring = json_encode($json[0]);
  echo $jsonstring;
  
  ?>