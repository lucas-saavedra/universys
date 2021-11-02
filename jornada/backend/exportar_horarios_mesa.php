<?php
include('../includes/db.php');
include('../includes/consultas.php');
$mesa_id = $_GET['mesa_id'];
$query = "SELECT DISTINCT
*,detalle_jornada.dia as dia_id, persona.nombre as nombre_agente,
 detalle_jornada.descripcion as descripcion_dia_mesa
 ,jornada.descripcion as descripcion_jornada,carrera.nombre as carrera
FROM
mesa_examen
LEFT JOIN jornada ON jornada.id = mesa_examen.jornada_id
LEFT JOIN detalle_jornada ON detalle_jornada.jornada_id = mesa_examen.jornada_id
LEFT JOIN jornada_docente_mesa ON jornada_docente_mesa.det_jornada_id = detalle_jornada.id
LEFT JOIN docente ON docente.id = jornada_docente_mesa.docente_id
LEFT JOIN persona ON persona.id = docente.persona_id
LEFT JOIN carrera on carrera.id = carrera_id
WHERE
mesa_examen.id =$mesa_id";
$result = mysqli_query($conexion, $query);
if (!$result) {
    die('Query failed' . mysqli_error($conexion));
}
if (mysqli_num_rows($result) != 0) {
    $jornadas_mesa = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
if (mysqli_num_rows(mysqli_query($conexion, $query)) != 0) {

    $ini = [];
    $fin = [];
    foreach ($jornadas_mesa as $j) {
        array_push($ini, $j['hora_inicio']);
        array_push($fin, $j['hora_fin']);
    }

    $date1 = new DateTime($j['fecha_inicio']);
    $date2 = new DateTime($j['fecha_fin']);
    while ($date1 <= $date2) {
        /* echo $date1->format('Y-m-d') . ' '; */
        $dia = $date1;
        if ($dia->format('w') == 1) {
            $fecha_lunes = $date1;
            break;
        }
        $date1->modify('+1 day');
    }
    $max = date("H", strtotime(max($fin)));
    $min = date("H", strtotime(min($ini)));
    $meses = array(
        1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
        "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
    );
    $fin = date("Y", strtotime($jornadas_mesa[0]['fecha_fin']));
    $fin_mes = date("m", strtotime($jornadas_mesa[0]['fecha_fin']));

    /*  header('Content-type: application/vnd.ms-excel'); */
    $carrera = get_carreras($conexion);
    $archivo = "Mesa Examen_Turno-" . $meses[$fin_mes] . "_Llamado-" . $jornadas_mesa[0]['llamado_id'] . '_' . $fin . '_' . $jornadas_mesa[0]['carrera'];
    /* header("Content-Disposition: attachment; filename=$archivo.xls");
    header("Pragma: no-cache");
    header("Expires: 0"); */
?>
    <meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
    <?php ob_start(); ?>
    <table class="table" border="1" style="border-collapse: collapse; ">
        <thead>
            <tr>
                <th colspan="5">
                    Mesa Examen - Turno <?= $meses[$fin_mes] . ' - Llamado: ' . $jornadas_mesa[0]['llamado_id'] . ' - ' ?><?= $fin . ' - ' ?> <?= $jornadas_mesa[0]['carrera'] ?>
                </th>
            </tr>
            <tr>
                <th>Fecha</th>
                <th>Dia</th>
                <th>Catedras</th>
                <th>Docentes</th>
                <th>Horario</th>
            </tr>

        </thead>
        <tbody>


            <?php $dias = get_dia($conexion);
            foreach (range(0, 5) as $d) : ?>
                <tr>
                    <td style="text-align: center;">
                        <?php echo $fecha_lunes->format('d-m-Y') . ' ';
                        $fecha_lunes->modify('+1 day'); ?>
                    <td><?= $dias[$d]['nombre'] ?> </td>
                    <?php

                    echo   '<td >';
                    foreach ($jornadas_mesa as $j) {
                        if ($j['dia_id'] == $d) {
                            $elements = explode(",", $j['descripcion_dia_mesa']);
                            $par = 0;
                            foreach ($elements as $e) {
                                if ($par % 2 == 0) {
                                    echo $e . '<br>';
                                } else {
                                    echo $e . ' - ';
                                }
                                $par++;
                            }
                            break;
                        }
                    }
                    echo '</td>';
                    echo '<td >';
                    foreach ($jornadas_mesa as $j) {
                        if ($j['dia_id'] == $d) {
                            echo $j['nombre_agente'] . '<br>';
                        }
                    }
                    echo '</td>';
                    ?>
                    <td>
                        <?php foreach ($jornadas_mesa as $j) {
                            if ($j['dia_id'] == $d) {
                                echo $j['hora_inicio'];
                                break;
                            }
                        } ?>
                    </td>
                </tr>

            <?php endforeach ?>

        </tbody>
    </table>

<?php


} ?>