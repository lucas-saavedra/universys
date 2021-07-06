<?php
include('../includes/db.php');

$query = "SELECT 
jnd.id as jornada_no_doc_id,
no_docente_id,
area_id,
jornada_id, 
agente_nombre.nombre as agente, 
a.nombre as area,
j.fecha_inicio,
j.fecha_fin,
j.tipo_jornada_id,
j.nombre as tipo_jornada,
j.descripcion
FROM `jornada_no_docente` as jnd
LEFT JOIN agente_nombre on jnd.no_docente_id= agente_nombre.id
LEFT JOIN area as a on a.id = jnd.area_id
LEFT OUTER JOIN v_jornada as j on jnd.jornada_id=j.id";

if (isset($_POST['jornada_no_doc_id'])) {
  $jnd_id = $_POST['jornada_no_doc_id'];
  $query = $query . " where jnd.id = '$jnd_id'";
};
$result = mysqli_query($conexion, $query);
if (!$result) {
  die('Query failed' . mysqli_error($conexion));
}
$json = array();
while ($row = mysqli_fetch_array($result)) {
  $json[] = array(
    'jornada_no_doc_id' => $row['jornada_no_doc_id'],
    'jornada_id' => $row['jornada_id'],
    'no_docente_id' => $row['no_docente_id'],
    'area_id' => $row['area_id'],
    'area' => $row['area'],
    'no_docente' => $row['agente'],
    'fecha_inicio' => $row['fecha_inicio'],
    'fecha_fin' => $row['fecha_fin'],
    'tipo_jornada' => $row['tipo_jornada'],
    'tipo_jornada_id' => $row['tipo_jornada_id'],
    'descripcion' => $row['descripcion']
  );
}
$jsonstring = json_encode($json);
echo $jsonstring;
