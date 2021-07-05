  <?php
  include('../includes/db.php');
  $search = $_POST['search'];
  $json = array();

  if (!empty($search)) {
    $query = "SELECT catedra.id as id ,catedra.nombre as nombre, carrera.nombre as carrera ,periodo.nombre as periodo, anio_plan.nombre as anio FROM catedra
    LEFT JOIN carrera ON catedra.carrera_id  = carrera.id
    LEFT JOIN periodo ON catedra.periodo_id = periodo.id
    LEFT JOIN anio_plan ON catedra.anio_plan_id = anio_plan.id
    WHERE catedra.nombre LIKE '$search%'  ";

    $result = mysqli_query($conexion, $query);
    if (!$result) {
      die('Error');
    }
    $json = array();
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
  echo json_encode($json);
  ?>