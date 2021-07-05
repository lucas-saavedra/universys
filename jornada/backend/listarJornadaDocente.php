<?php
include('../includes/db.php');

$query = "SELECT 
      jd.id as jornada_doc_id,
      docente_id ,
      catedra_id,
      jornada_id, 
      docente_nombre.nombre as docente, 
      c.nombre as catedra,
      j.fecha_inicio,
      j.fecha_fin,
      j.nombre as tipo_jornada,
      j.descripcion
      FROM `jornada_docente` as jd
      LEFT JOIN docente_nombre on jd.docente_id = docente_nombre.id
      LEFT JOIN catedra as c on c.id = catedra_id
      LEFT OUTER JOIN v_jornada as j on jd.jornada_id=j.id ";

if (isset($_POST['jornada_doc_id'])) {
  $jd_id = $_POST['jornada_doc_id'];
  $query = $query . " where jd.id = '$jd_id'";
};
$result = mysqli_query($conexion, $query);
if (!$result) {
  die('Query failed' . mysqli_error($conexion));
}
$json = array();
while ($row = mysqli_fetch_array($result)) {
  $json[] = array(
    'jornada_doc_id' => $row['jornada_doc_id'],
    'docente_id' => $row['docente_id'],
    'jornada_id' => $row['jornada_id'],
    'catedra_id' => $row['catedra_id'],
    'catedra' => $row['catedra'],
    'docente' => $row['docente'],
    'fecha_inicio' => $row['fecha_inicio'],
    'fecha_fin' => $row['fecha_fin'],
    'tipo_jornada' => $row['tipo_jornada'],
    'descripcion' => $row['descripcion']
  );
}
$jsonstring = json_encode($json);
echo $jsonstring;
