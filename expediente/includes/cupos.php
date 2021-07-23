<?php

function verificar_cupo_codigo($bd, $id_expdte){
    $expdte = get_expdte($bd, $id_expdte);
    $cupos = get_codigo_cupos($bd, $expdte['codigo_id']);

    $sql = "SELECT id,fecha_inicio,fecha_fin FROM expediente 
    WHERE persona_id={$expdte['persona_id']} AND codigo_id={$expdte['codigo_id']}";

    // Expedientes de la persona que usan el codigo.
    $expdtes_codigo = mysqli_fetch_all(mysqli_query($bd, $sql), MYSQLI_ASSOC);
    $cupo_superado = false;

    print_r($expdtes_codigo);
    echo '<br>';

    foreach ($cupos as $cupo) {
        $rango = get_datos_rango($cupo['rango']);
        // Calculamos el rango segun los datos del cupo, sobre el q queremos contar los dias.
        $rango_cupo = get_rango_del_cupo($rango, $expdte['fecha_inicio'], $expdte['fecha_fin']);
        
        $_meses_cupo = array_map(function($v){return "$v[1]-$v[0]";},
            get_meses_entre_fechas(
                $rango_cupo['fecha_inicio']->format('d-m-Y'), 
                $rango_cupo['fecha_fin']->format('d-m-Y')
            )
        );

        $usos = array_combine($_meses_cupo, array_fill(0, count($_meses_cupo), 0));


        foreach ($expdtes_codigo as $exp) {
            $fi = new DateTime($exp['fecha_inicio']);
            $ff = new DateTime($exp['fecha_fin']);
            // Si el rango del expdte no se solapa en ningun punto con el rango del cupo, lo ignoramos
            if (!($rango_cupo['fecha_inicio'] <= $ff && $rango_cupo['fecha_fin'] >= $fi )) continue;
            
            // Acoto el rango del expdte para q abarque solo las fechas q interesan contabilizar
            $fi = $fi < $rango_cupo['fecha_inicio'] ? clone $rango_cupo['fecha_inicio']: $fi;
            $ff = $ff > $rango_cupo['fecha_fin'] ? clone $rango_cupo['fecha_fin']: $ff;

            // Contabilizo los dias del rango
            sum_usos_codigo($fi, $ff, $usos);
        }

        print_r($usos);
        echo '<br>';


        foreach(array_chunk($usos, $rango['cantidad'], true) as $grupo){
            $total_dias = array_sum($grupo);
            $_dates = array_keys($grupo);
            $_start = $_dates[0];
            $_end = end($_dates);
            if ($total_dias > $cupo['cantidad_max_dias']){
                echo "Se supero el cupo maximo de dias: {$cupo['cantidad_max_dias']}. Entre el {$_start} y el {$_end} se uso el codigo {$total_dias} veces <br>";
                $cupo_superado = true;
                break;
            }
        }
    }

}

function get_rango_del_cupo($rango, $fi, $ff){
    $meses = get_rango_meses([2021,2022], $rango['cantidad']);

    $rangos = array_values(array_filter($meses, function ($v) use ($fi, $ff){
        return new DateTime($fi) <= $v[1] && new DateTime($ff) >= $v[0];
    }));

    return [
        'fecha_inicio' => $rangos[0][0]->modify('first day of this month'),
        'fecha_fin' => end($rangos)[1]->modify('last day of this month'),
    ];
}

function sum_usos_codigo($f_inicio, $f_fin, &$usos){
    $current = clone $f_inicio;

    while ($current <= $f_fin){
        $mes = $current->format('n-Y');
        if ($mes == $f_fin->format('n-Y')){
            $usos[$mes] += date_diff($f_fin, $current)->format('%a') + 1;
        }
        else{
            $usos[$mes] += ($current->format('t') - $current->format('j')) + 1;
        }
        $current->modify('first day of this month');
        $current->modify('+1 month');

    }
}


function get_rango_meses($anios, $groups){
    $result = [];
    foreach($anios as $anio){
        foreach(array_chunk(range(1,12), $groups) as $r){
            $f1 = new DateTime("$anio-$r[0]");
            $end = end($r);
            $f2 = new DateTime("$anio-$end");
            $result[] = [
                $f1->modify("first day of this month"), 
                $f2->modify("last day of this month"),
            ];
        }
    }
    return $result;
}

function get_datos_rango($rango){
    $regex = '/(\d+) (a|m)/i';
    $matches = [];
    preg_match_all($regex, $rango, $matches, PREG_PATTERN_ORDER);

    if (empty($matches)) throw new Exception("El formato del rango '{$rango}' es invalido");

    return ['cantidad' => $matches[1][0], 'tiempo' => $matches[2][0]];
}

?>