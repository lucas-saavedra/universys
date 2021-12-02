<?php
include('../includes/db.php');
include('../includes/consultas.php');

$tipo_agente = $_POST['tipo_agente'];
$json = array();
if ($tipo_agente == 'docente') {
    $query = "SELECT
  jornada_agente.id AS jornada_agente_id,
  docente_id AS agente_id,
  catedra_id,
  jornada_agente.jornada_id,
  docente_nombre.nombre AS nombre_agente,
  c.nombre AS catedra,
  c.anio_plan_id AS anio_plan,
  c.carrera_id,
  carrera.nombre AS carrera,
  j.fecha_inicio,
  j.fecha_fin,
  j.tipo_jornada_id,
  j.nombre AS tipo_jornada,
  j.descripcion,
  detalle_jornada.jornada_id,
  detalle_jornada.id AS id,
  hora_inicio,
  hora_fin,
  dia.id AS dia_id,
  dia.nombre
  FROM
  jornada_docente AS jornada_agente
  LEFT JOIN docente_nombre ON jornada_agente.docente_id = docente_nombre.id
  LEFT JOIN catedra AS c
  ON
  c.id = catedra_id
  LEFT OUTER JOIN v_jornada AS j
  ON
  jornada_agente.jornada_id = j.id
  LEFT JOIN carrera ON c.carrera_id = carrera.id
  LEFT JOIN detalle_jornada ON jornada_agente.jornada_id = detalle_jornada.jornada_id
  LEFT JOIN dia ON detalle_jornada.dia = dia.id";
} else {
    $query = "SELECT
    jornada_agente.id AS jornada_agente_id,
    no_docente_id AS agente_id,
    area_id,
    jornada_agente.jornada_id,
    agente_nombre.nombre AS nombre_agente,
    a.nombre AS area,
    j.fecha_inicio,
    j.fecha_fin,
    j.tipo_jornada_id,
    j.nombre AS tipo_jornada,
    j.descripcion,
    detalle_jornada.jornada_id,
    detalle_jornada.id AS id,
    hora_inicio,
    hora_fin,
    dia.id AS dia_id,
    dia.nombre
FROM
    jornada_no_docente AS jornada_agente
LEFT JOIN agente_nombre ON jornada_agente.no_docente_id = agente_nombre.id
LEFT JOIN AREA AS a
ON
    a.id = jornada_agente.area_id
LEFT JOIN v_jornada AS j
ON
    jornada_agente.jornada_id = j.id
LEFT JOIN detalle_jornada ON detalle_jornada.jornada_id = jornada_agente.jornada_id
LEFT JOIN dia ON detalle_jornada.dia = dia.id";
}

if (isset($_POST['filtroFechaInicio']) && isset($_POST['filtroFechaFin'])) {

    $filtroFechaInicio = $_POST['filtroFechaInicio'];
    $filtroFechaFin = $_POST['filtroFechaFin'];
    if ($_POST['filtroFechaInicio'] <> null && $_POST['filtroFechaFin'] <> null) {
        $query = $query . " WHERE fecha_inicio >=  '$filtroFechaInicio' and fecha_fin  <= '$filtroFechaFin' ";
    } else if (($_POST['filtroFechaInicio'] <> null && $_POST['filtroFechaFin'] == null)) {
        $query = $query . " WHERE fecha_inicio >=  '$filtroFechaInicio'";
    } else if (($_POST['filtroFechaInicio'] == null && $_POST['filtroFechaFin'] <> null)) {
        $query = $query . " WHERE fecha_fin  <= '$filtroFechaFin'";
    } else {
        $query = $query . " WHERE 1";
    }
} else {
    $query = $query . " WHERE 1";
}


if (isset($_POST['filtroTipoJornadaId'])) {
    if (($_POST['filtroTipoJornadaId']) <> null) {
        $tipoJornadaId = $_POST['filtroTipoJornadaId'];
        $query = $query . " and j.tipo_jornada_id='$tipoJornadaId' ";
    }
}

if (isset($_POST['filtroCarreraId'])) {
    if (($_POST['filtroCarreraId']) <> null) {
        $filtroCarreraId = $_POST['filtroCarreraId'];
        $query = $query . " and c.carrera_id='$filtroCarreraId' ";
    }
}




$ini = date("Y", strtotime($_POST['filtroFechaInicio']));
$fin = date("Y", strtotime($_POST['filtroFechaFin']));
$fecha = $ini == $fin ? $ini : $ini . '=>' . $fin;
$carrera = get_carreras($conexion);
$jornada = ['1er_Cuatrimestre', '2do_Cuatrimestre', 'Anual'];
?>

<?php


header('Content-type: application/vnd.ms-excel');
$archivo = $tipo_agente == 'docente' ? $carrera[$_POST['filtroCarreraId'] - 1]['nombre'] . '-' . $jornada[$tipoJornadaId - 1] . $fecha : 'No Docente - ' . date("d-m-Y", strtotime($_POST['filtroFechaInicio'])) . ' a ' . date("d-m-Y", strtotime($_POST['filtroFechaFin']));
header("Content-Disposition: attachment; filename=$archivo.xls");
header("Pragma: no-cache");
header("Expires: 0");

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
</head>


<?php
if (mysqli_num_rows(mysqli_query($conexion, $query)) != 0) {

?>
    <?php if ($tipo_agente == 'docente') { ?>
        <?php foreach (range(1, 3) as $anio_plan) : ?>
            <?php

            $result = mysqli_query($conexion,  $query . "  and c.anio_plan_id ='$anio_plan' ");

            if (!$result) {
                die('Query failed' . mysqli_error($conexion));
            }
            if (mysqli_num_rows($result) != 0) {
                $jornadas = mysqli_fetch_all($result, MYSQLI_ASSOC);

                $ini = [];
                $fin = [];
                foreach ($jornadas as $j) {
                    array_push($ini, $j['hora_inicio']);
                    array_push($fin, $j['hora_fin']);
                }
                $max = date("H", strtotime(max($fin)));
                $min = date("H", strtotime(min($ini)));

            ?>

                <table id='testTable' class="table table-striped " border="1" style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th scope="col" colspan="7" style="text-align:center">
                                <?= $anio_plan ?>º AÑO - <?= $carrera[$_POST['filtroCarreraId'] - 1]['nombre'] ?> - <?= $fecha . '-' . $jornadas[0]['tipo_jornada']  ?><?php   ?>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                Horarios
                            </th>

                            <?php foreach (get_dia($conexion) as $dia) : ?>
                                <th scope="col"><?= $dia['nombre'] ?></th>
                            <?php endforeach ?>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (range($min, $max) as $h) : ?>
                            <tr>
                                <th>
                                    <?= date("H:i", mktime($h, '00')); ?>
                                </th>

                                <?php foreach (range(0, 5) as $d) : ?>

                                    <td style="text-align:center"><?php $cont = 0;
                                                                    foreach ($jornadas as $j) {

                                                                        $horario_ini = date("H", strtotime($j['hora_inicio']));
                                                                        $horario_fin = date("H", strtotime($j['hora_fin']));

                                                                        if ($j['dia_id'] == $d &&  ($h >= $horario_ini &&  $h <= $horario_fin) && $j['anio_plan'] == $anio_plan) {
                                                                            $cont = $cont + 1;
                                                                            if ($cont > 1) {
                                                                                echo '<hr>';
                                                                            }
                                                                            echo '<strong>' . $j['nombre_agente'] . '</strong> <br>' . $j['catedra'];
                                                                        }
                                                                    }  ?>
                                    </td>
                                <?php endforeach ?>

                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <br>
            <?php } ?>
        <?php endforeach ?>

        <!-- NO DOCENTE -->
    <?php } else {
        $tipo = get_tipo_jornadas($conexion, 'no_docente') ?>

        <?php foreach (range(5, 7) as $tipo_jornada) : ?>
            <?php
            $result = mysqli_query($conexion,  $query . "  and j.tipo_jornada_id ='$tipo_jornada' ");

            if (!$result) {
                die('Query failed' . mysqli_error($conexion));
            }
            if (mysqli_num_rows($result) != 0) {
                $jornadas = mysqli_fetch_all($result, MYSQLI_ASSOC);

                $ini = [];
                $fin = [];
                foreach ($jornadas as $j) {
                    array_push($ini, $j['hora_inicio']);
                    array_push($fin, $j['hora_fin']);
                }
                $max = date("H", strtotime(max($fin)));
                $min = date("H", strtotime(min($ini)));
            ?>
                <table class="table" border="1" style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th colspan="7">
                                Horarios No Docente Turno: <?= $tipo[$tipo_jornada - 5]['nombre'] ?> - <?= $fecha ?><?php   ?>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                Horarios
                            </th>

                            <?php foreach (get_dia($conexion) as $dia) : ?>
                                <th><?= $dia['nombre'] ?></th>
                            <?php endforeach ?>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (range($min, $max) as $h) : ?>
                            <tr>
                                <th>
                                    <?= date("H:i", mktime($h, '00')); ?>
                                </th>
                                <?php foreach (range(0, 5) as $d) : ?>

                                    <td style="text-align:center">
                                        <?php $contNd = 0;
                                        foreach ($jornadas as $j) {
                                            $horario_ini = date("H", strtotime($j['hora_inicio']));
                                            $horario_fin = date("H", strtotime($j['hora_fin']));

                                            if ($j['dia_id'] == $d &&  ($h >= $horario_ini &&  $h <= $horario_fin) && $j['tipo_jornada_id'] == $tipo_jornada) {
                                                $contNd = $contNd + 1;
                                                if ($contNd > 1) {
                                                    echo '<hr>';
                                                }
                                                echo '<strong>' . $j['nombre_agente'] . '</strong><br>' . $j['area'];
                                            }
                                        }  ?>
                                    </td>
                                <?php endforeach ?>

                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <br>
            <?php } ?>
        <?php endforeach ?>
    <?php } ?>
 
<?php
}
