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


/* if (isset($_POST['filtroAreaId'])) {
    if (($_POST['filtroAreaId']) <> null) {
        $filtroAreaId = $_POST['filtroAreaId'];
        $query = $query . " and area_id='$filtroAreaId' ";
    }
} */

/* if (isset($_POST['jornada_agente_id']) && isset($_POST['agente_id'])) {
    $jd_id = $_POST['jornada_agente_id'];
    $agente_id = $_POST['agente_id'];
    if ($tipo_agente == 'docente') {
        $query = $query . " WHERE docente_id ='$agente_id' and jornada_agente.id ='$jd_id' ";
    } else {
        $query = $query . " WHERE no_docente_id ='$agente_id' and jornada_agente.id ='$jd_id' ";
    }
} else {
    if (isset($_POST['jornada_agente_id'])) {
        $jd_id = $_POST['jornada_agente_id'];
        $query = $query . " where jornada_agente.id =$jd_id";
    } else if (isset($_POST['agente_id'])) {
        $agente_id = $_POST['agente_id'];

        if ($tipo_agente == 'docente') {
            $query = $query . " WHERE docente_id ='$agente_id' ";
        } else {
            $query = $query . " WHERE no_docente_id ='$agente_id' ";
        }
    }
}
 */
/*
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
LEFT JOIN dia ON detalle_jornada.dia = dia.id order by hora_inicio";
*/




$ini = date("Y", strtotime($_POST['filtroFechaInicio']));
$fin = date("Y", strtotime($_POST['filtroFechaFin']));
$fecha = $ini == $fin ? $ini : $ini . '=>' . $fin;
$carrera = get_carreras($conexion);

/* header('Content-type: application/vnd.ms-excel');
$archivo =  $tipo_agente == 'docente' ?  $carrera[$_POST['filtroCarreraId'] - 1]['nombre'] . '-' . $fecha . ' - ' . $jornadas[0]['tipo_jornada'] : 'No Docente - ' .  date("d-m-Y", strtotime($_POST['filtroFechaInicio'])) . ' a ' .  date("d-m-Y", strtotime($_POST['filtroFechaFin']));
header("Content-Disposition: attachment; filename=$archivo.xls");
header("Pragma: no-cache");
header("Expires: 0"); */
?>
<meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
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

                <table class="table" border="1" style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th colspan="7">

                                <?= $anio_plan ?>º AÑO - <?= $carrera[$_POST['filtroCarreraId'] - 1]['nombre'] ?> - <?= $fecha . '-' . $jornadas[0]['tipo_jornada']  ?><?php   ?>
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

                                    <th style="text-align:center"><?php foreach ($jornadas as $j) {
                                                                        $horario_ini = date("H", strtotime($j['hora_inicio']));
                                                                        $horario_fin = date("H", strtotime($j['hora_fin']));

                                                                        if ($j['dia_id'] == $d &&  ($h >= $horario_ini &&  $h <= $horario_fin) && $j['anio_plan'] == $anio_plan) {
                                                                            echo $j['nombre_agente'] . '<br>' . $j['catedra'] . '<br>';
                                                                        }
                                                                    }  ?>
                                    </th>
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
                                        <?php foreach ($jornadas as $j) {
                                            $horario_ini = date("H", strtotime($j['hora_inicio']));
                                            $horario_fin = date("H", strtotime($j['hora_fin']));

                                            if ($j['dia_id'] == $d &&  ($h >= $horario_ini &&  $h <= $horario_fin) && $j['tipo_jornada_id'] == $tipo_jornada) {
                                                echo $j['nombre_agente'] . '<br>' . $j['area'] . '<br>';
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




/* 

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
LEFT JOIN dia ON detalle_jornada.dia = dia.id order by hora_inicio";
$result = mysqli_query($conexion, $query);
$jornadas = mysqli_fetch_all($result, MYSQLI_ASSOC); */

/* 
$arr = [];
foreach ($jornadas as $j) {
    array_push($arr, $j['hora_inicio'] . ' ' . $j['hora_fin']);
}
$horas = array_unique($arr);
 */
?>

<!-- <meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
 -->
<!-- <table class="table" border="1" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th>
                Horarios
            </th>
            <th>
                <?php foreach (get_dia($conexion) as $dia) : ?>
            <th><?= $dia['nombre'] ?></th>
        <?php endforeach ?>
        </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php foreach ($horas as $h) : ?>
                <td>
                    <?= $h ?>
                </td>
                <td>
                    <?php foreach (range(0, 6) as $d) : ?>

                <th><?php foreach ($jornadas as $j) {
                            if ($j['dia_id'] == $d && $h == ($j['hora_inicio'] . ' ' . $j['hora_fin'])) {
                                echo $j['nombre_agente'] . '-' . $j['catedra'];
                            }
                        } ?>
                </th>
            <?php endforeach ?>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>  -->