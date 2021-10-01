  <?php
  include('../includes/db.php');

  $tipo_agente = $_POST['tipo_agente'];
  $json = array();
  if (!empty($_POST['agente_id'])) {
    $agente_id = $_POST['agente_id'];
    $sql = "SELECT $tipo_agente.id,nombre, persona.id as persona_id FROM $tipo_agente left join persona on $tipo_agente.persona_id = persona.id
    WHERE $tipo_agente.id = $agente_id;
    ";
    
  } else if (!empty($_POST['search_agente'])) {
    $search_agente = $_POST['search_agente'];
    $sql = "SELECT $tipo_agente.id,nombre,persona.id as persona_id FROM $tipo_agente left join persona on $tipo_agente.persona_id = persona.id
    WHERE persona.nombre LIKE '$search_agente%'
    ";
  }

  $result = mysqli_query($conexion, $sql);
  if (!$result) {
    die('Error');
  }
  while ($row = mysqli_fetch_array($result)) {
    $json[] = array(
      'id' => $row['id'],
      'nombre' => $row['nombre'],
      'persona_id' => $row['persona_id'],
    );
  }


  echo json_encode($json);

  ?>