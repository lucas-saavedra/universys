<?php 

if ($_SERVER['REQUEST_METHOD'] != 'POST') exit;

include('../dataBase.php');
include('./includes/cupos.php');

function validar($val){
    return isset($_POST['expdte'][$val]) && $_POST['expdte'][$val] != "";
}


$date_err = ['msg_type' => 'danger', 'msg' => 'Seleccione un rango de fechas valido'];

if (!validar('persona_id')){
    echo json_encode(['msg_type' => 'danger', 'msg' => 'Seleccione un agente válido']);
    exit;
}

if (!validar('fecha_inicio') || !validar('fecha_fin')){
    echo json_encode($date_err);
    exit;
}

if (new DateTime($_POST['expdte']['fecha_inicio']) > new DateTime($_POST['expdte']['fecha_fin'])){
    echo json_encode($date_err);    
    exit;
}

if (!validar('codigo_id')){
    echo json_encode(['msg_type' => 'danger', 'msg' => 'Seleccione un codigo válido']);
    exit;
}

echo json_encode(verificar_cupo_codigo($conexion, $_POST['expdte']));


?>