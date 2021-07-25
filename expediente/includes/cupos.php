<?php

function verificar_cupo_codigo($bd, $id_expdte){
    $expdte = get_expdte($bd, $id_expdte);
    $cupos = get_codigo_cupos($bd, $expdte['codigo_id']);

    // Expedientes de la persona en los q se usa el codigo.
    $sql = "SELECT id,fecha_inicio,fecha_fin FROM expediente 
    WHERE persona_id={$expdte['persona_id']} AND codigo_id={$expdte['codigo_id']}";

    $expdtes_codigo = mysqli_fetch_all(mysqli_query($bd, $sql), MYSQLI_ASSOC);
    // $expdtes_codigo = array_map(
    //     function($v){return ['fecha_inicio'=>$v[0], 'fecha_fin'=>$v[1]];},
    //     [
    //         [$expdte['fecha_inicio'], $expdte['fecha_fin']], 
    //         ['2021-6-2','2021-6-2'],
    //         ['2021-6-10','2021-6-10'],
    //         ['2021-7-10','2021-7-12'],
    //         ['2020-8-5','2020-8-7'],
    //         ['2019-10-1','2019-11-5'],
    //     ]
    // );
    foreach ($cupos as $cupo) {
        $rango = get_datos_rango($cupo['rango']);

        if ($rango['tiempo'] == 'm'){
            $rango_cupo = get_rango_cupo_por_mes($expdte, $rango);

            $contador_keys = array_map(
                function($v){return "$v[1]-$v[0]";},
                get_meses_entre_fechas(
                    $rango_cupo['fecha_inicio']->format('d-m-Y'), 
                    $rango_cupo['fecha_fin']->format('d-m-Y')
                )
            );
            $sumador_usos = 'sum_usos_por_mes';
            $verificar_cupo = 'verificar_cupo_mes';
        }
        else if ($rango['tiempo'] == 'a'){
            $rango_cupo = get_rango_cupo_por_anio($expdte, $rango);
            $contador_keys = $rango_cupo['anios_totales'];
            $sumador_usos = 'sum_usos_por_anio';
            $verificar_cupo = 'verificar_cupo_anio';
        }
        else{
            throw New Exception("Tipo de rango desconocido: {$rango['tiempo']}");
        }

        $anios_expdte = $rango_cupo['anios_expdte'];
        $usos = array_combine($contador_keys, array_fill(0, count($contador_keys), 0));

        foreach ($expdtes_codigo as $_expdte_cod) {
            $fi = new DateTime($_expdte_cod['fecha_inicio']);
            $ff = new DateTime($_expdte_cod['fecha_fin']);

            // Si el rango del expdte no se solapa en ningun punto con el rango del cupo, lo ignoramos
            if (!($rango_cupo['fecha_inicio'] <= $ff && $rango_cupo['fecha_fin'] >= $fi )) continue;
            // Acoto el rango del expdte para q abarque solo las fechas q interesan contabilizar
            $fi = $fi < $rango_cupo['fecha_inicio'] ? clone $rango_cupo['fecha_inicio']: $fi;
            $ff = $ff > $rango_cupo['fecha_fin'] ? clone $rango_cupo['fecha_fin']: $ff;

            // Contabilizo los dias del rango
            $sumador_usos($fi, $ff, $usos);
        }

        print_r($usos);
        echo '<br>';

        list($cupo_superado, $rango_afectado) = $verificar_cupo($usos, $rango, $cupo['cantidad_max_dias'], $anios_expdte);

        if ($cupo_superado){
            $fechas = array_keys($rango_afectado);
    
            $start = $fechas[0];
            $end = end($fechas);

            $total_usos = array_sum($rango_afectado);

            return [
                'cupo_superado' => true,
                'msg' => "Se superó el cupo máximo de días 
                        ({$cupo['cantidad_max_dias']} cada {$rango['cantidad']} {$rango['tiempo']}) para el código. 
                        Entre el {$start} y el {$end} se usó un total de {$total_usos} días.",
            ];
        }
    }

    return ['cupo_superado'=> false, 'msg'=> 'El cupo para este código aun no ha sido superado.'];

}

function get_rango_cupo_por_mes($expdte, $info_rango){
    $anios_expdte = get_anios_entre_fechas($expdte['fecha_inicio'], $expdte['fecha_fin']);

    $fi = new DateTime($expdte['fecha_inicio']);
    $ff = new DateTime($expdte['fecha_fin']);

    $rangos = get_rango_meses($anios_expdte, $info_rango['cantidad']);

    $rangos_cupo = array_values(array_filter($rangos, function ($v) use ($fi, $ff){
        return $fi <= $v[1] && $ff >= $v[0];
    }));

    return [
        'fecha_inicio' => $rangos_cupo[0][0]->modify('first day of this month'),
        'fecha_fin' => end($rangos_cupo)[1]->modify('last day of this month'),
        'anios_expdte' => $anios_expdte,
    ];
}

function get_rango_cupo_por_anio($expdte, $info_rango){
    
    $anios_expdte = get_anios_entre_fechas($expdte['fecha_inicio'], $expdte['fecha_fin']);

    $anios_totales = range($anios_expdte[0] - ($info_rango['cantidad']-1), end($anios_expdte));
    $_end = end($anios_totales);

    return [
        'fecha_inicio' => new DateTime("$anios_totales[0]-1-1"),
        'fecha_fin' => new DateTime("$_end-12-31"),
        'anios_expdte' => $anios_expdte,
        'anios_totales'=> $anios_totales,
    ];
}

function verificar_cupo_anio($usos, $rango, $max_dias, $anios_expdte){
    $cupo_superado = false;
    $rango_afectado = [];
    foreach($anios_expdte as $idx=>$anio){
        $grupo = array_slice($usos, $idx, $rango['cantidad'], true);
        $total_dias = array_sum($grupo);

        if ($total_dias > $max_dias){
            $rango_afectado = $grupo;
            $cupo_superado = true;
            break;
        }
    }

    return [$cupo_superado, $rango_afectado]; 
}

function verificar_cupo_mes($usos, $rango, $max_dias, $anios_expdte){
    $cupo_superado = false;
    $rango_afectado = [];

    foreach(array_chunk($usos, $rango['cantidad'], true) as $grupo){
        $total_dias = array_sum($grupo);
        if ($total_dias > $max_dias){
            $rango_afectado = $grupo;
            $cupo_superado = true;
            break;
        }
    }
    return [$cupo_superado, $rango_afectado];
}

function sum_usos_por_mes($f_inicio, $f_fin, &$usos){
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

function sum_usos_por_anio($f_inicio, $f_fin, &$usos){
    $current = clone $f_inicio;

    while($current <= $f_fin){
        $anio = $current->format('Y');
        if ($anio == $f_fin->format('Y')){
            $usos[$anio] += date_diff($f_fin, $current)->format('%a') + 1;
        }
        else{
            $usos[$anio] += date_diff(new DateTime("$anio-12-31"), $current)->format('%a') + 1;
        }

        $anio+=1;
        $current = new DateTime("{$anio}-1-1");
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

function get_anios_entre_fechas($start, $end){
    $start = strtotime($start);
    $end = strtotime($end);
    return range(date('Y', $start), date('Y',$end));
}

function get_datos_rango($rango){
    $regex = '/(\d+) (a|m)/i';
    $matches = [];
    preg_match_all($regex, $rango, $matches, PREG_PATTERN_ORDER);

    if (empty($matches)) throw new Exception("El formato del rango '{$rango}' es invalido");

    return ['cantidad' => $matches[1][0], 'tiempo' => $matches[2][0]];
}

?>