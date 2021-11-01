<?php
include('../includes/db.php');
include('../includes/consultas.php');

$carrera_id = $_POST['carrera_id'];
$anio_plan_id = $_POST['anio_plan_id'];
$json = array();
$sql = "SELECT
  catedra.nombre AS catedra,
  catedra.id AS catedra_id,
  carrera.nombre AS carrera,
  carrera.id AS carrera_id,
  anio_plan.nombre AS anio_plan,
  anio_plan.id AS anio_plan_id
FROM
  catedra
  LEFT JOIN carrera ON catedra.carrera_id = carrera.id
  LEFT JOIN periodo ON periodo.id = catedra.periodo_id
  LEFT JOIN anio_plan ON anio_plan.id = catedra.anio_plan_id
  where carrera_id = $carrera_id and anio_plan_id = $anio_plan_id";

$result = mysqli_query($conexion, $sql);
if (!$result) {
    die('Query failed' . mysqli_error($conexion));
}

while ($row = mysqli_fetch_array($result)) {
    $json[] = array(
        'catedra' => $row['catedra'],
        'catedra_id' => $row['catedra_id'],
        'carrera' => $row['carrera'],
        'carrera_id' => $row['carrera_id'],
        'anio_plan' => $row['anio_plan'],
        'anio_plan_id' => $row['anio_plan_id']
    );
}
$jsonstring = json_encode($json);
echo $jsonstring;
