<?php

include "../includes/db.php";
include "../includes/consultas.php";



$query = "SELECT
jornada_agente.id AS jornada_agente_id,
docente_id AS agente_id,
catedra_id,
jornada_agente.jornada_id,
docente_nombre.nombre AS docente,
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
$result = mysqli_query($conexion, $query);
$jornadas = mysqli_fetch_all($result, MYSQLI_ASSOC);


header("Content-Type: aplication/xls");
header("Content-Disposition: attachment; filename=Horarios-2021.xls");

?>
<meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
<table class="table" border="1" style="border-collapse: collapse;">
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
            <td>
                15 a 16
            </td>
            <td>
                <?php foreach (range(0, 6) as $d) : ?>
                    <?php foreach ($jornadas as $j) : ?>
                        if($j['dia_id']==$d){
                    <th><?= $dia['nombre'] ?></th>
            }
        <?php endforeach ?>

    <?php endforeach ?>
    </td>
        </tr>
    </tbody>
</table>