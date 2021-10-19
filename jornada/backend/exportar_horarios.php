<?php

include "../includes/db.php";
include "../includes/consultas.php";

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
$jornadas = mysqli_fetch_all($result, MYSQLI_ASSOC);

/* header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=nombre_del_archivo.xls");
header("Pragma: no-cache");
header("Expires: 0"); */

$ini = [];
$fin = [];
foreach ($jornadas as $j) {
    array_push($ini, $j['hora_inicio']);
    array_push($fin, $j['hora_fin']);
}
$max = date("H", strtotime(max($fin)));
$min = date("H", strtotime(min($ini)));

?>
<meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
<table class="table" border="1" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th colspan="9">
                1º AÑO - ANALISIS DE SISTEMAS - 2021
            </th>

        </tr>
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
            <?php foreach (range($min, $max) as $h) : ?>
                <td>
                    <?= date("H:i", mktime($h, '00')); ?>
                </td>
                <td>
                    <?php foreach (range(0, 6) as $d) : ?>

                <th><?php foreach ($jornadas as $j) {
                            $horario_ini = date("H", strtotime($j['hora_inicio']));
                            $horario_fin = date("H", strtotime($j['hora_fin']));

                            if ($j['dia_id'] == $d &&  ($h >= $horario_ini &&  $h <= $horario_fin)) {
                                echo $j['nombre_agente'] . '-' . $j['catedra'] . '<br>';
                            }
                        }  ?>
                </th>
            <?php endforeach ?>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>






<?php


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
$jornadas = mysqli_fetch_all($result, MYSQLI_ASSOC);


$arr = [];
foreach ($jornadas as $j) {
    array_push($arr, $j['hora_inicio'] . ' ' . $j['hora_fin']);
}
$horas = array_unique($arr);

?>

<meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
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