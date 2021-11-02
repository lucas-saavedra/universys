<?php 

include "../includes/db.php";
include "includes/consultas.php";


$planilla = get_p_prod($conexion, $_GET['anio'], $_GET['mes'], $_GET['tipo']);


if (!isset($planilla['id'])){
  header('Location: index.php');
  exit();
} 

$expdtes = get_expdtes_por_agente($conexion, $planilla['id'], $_GET['tipo']);

$inicio_mes = new DateTime("1-{$_GET['mes']}-{$_GET['anio']}");
$total_dias = $inicio_mes->modify('last day of this month')->format('j');

$periodo = "{$_GET['mes']}-{$_GET['anio']}";

header("Content-Type: aplication/xls");
header("Content-Disposition: attachment; filename=Planilla Productividad [{$periodo}].xls");

?>
<meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
<table class="table" border="1" style="border-collapse: collapse;">
  <thead>
    <tr>
      <th>
        UNIVERSIDAD AUTONOMA DE E.RÍOS FACULTAD DE CIENCIA Y TECNOLOGÍA SEDE CHAJARÍ
        MES: <?=$planilla['nombre']?>
        AÑO: <?=$planilla['anio']?>
      </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="3">
        <table border="1" style="border-collapse: collapse;">
          <thead>
            <th>DNI</th>
            <th>Apellido y Nombres</th>
            <?php foreach(range(1,$total_dias) as $dia): ?>
              <th><?=$dia?></th>
            <?php endforeach ?>
            <th>Hs. a descontar</th>
            <th>Cargo/Total Hs.</th>
          </thead>
          <tbody>
            <?php foreach ($expdtes as $persona_id => $_expdtes): ?>
              <tr>
                <td><?=$_expdtes[0]['agente_dni']?></td>
                <td><?=$_expdtes[0]['agente_nombre']?></td>

                <?php foreach(range(1,$total_dias) as $dia): 
                  $expdtes_en_dia = array_filter($_expdtes, function($e) use ($dia, $periodo){
                    $fecha = strtotime("{$dia}-{$periodo}");
                    return $fecha >= strtotime($e['fecha_inicio']) && $fecha <= strtotime($e['fecha_fin']);
                  })
                ?>
                  <td>
                    <?=implode(',', array_map(function($e){
                      return $e['cod'];
                    }, $expdtes_en_dia))?>
                  </td>
                <?php endforeach ?>

                <td>
                  <?=array_reduce($_expdtes, function($carry, $item){ return $carry+$item['hs_descontadas'];}, 0)?>
                </td>

                <td>
                  <?=$_expdtes[0]['agente_antiguedad']?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>