<?php
ob_start();
?>
<?php include("../jornada/navbar.php");
include ("./includes/consultas.php");
include "../includes/db.php";


if (($_SERVER['REQUEST_METHOD'] !== 'POST') || (!isset($_POST['select']))) {
  $tipo_agente = "Docente";
} else {
  $tipo_agente = $_POST['select'];
}

?>
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-5 m-auto">
      <form action="" method="post">
        <div class="form-group text-center">
          <h2 class="col-md-12 text-center">Inasistencias</h2>
          <div class=" row m-auto col">
            <select name="select" class="form-control mr-sm-2 col-3" required>
              <option value="Docente" <?= $tipo_agente == 'Docente' ? 'selected' : '' ?>>Docente</option>
              <option value="No docente" <?= $tipo_agente == 'No docente' ? 'selected' : '' ?>>No docente</option>
            </select>
            <button class="btn btn-outline-success my-2 my-sm-0 col" type="submit">BUSCAR.</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <?php



  if ($tipo_agente == 'Docente') {
    ?>
<p>Las inasistencias de un mismo diá se agrupan en un solo expediente, este dice la cantidad de 
  inasistencias que contiene y la cantidad de horas que se ausento el docente ese diá<p>
<?php
    $query_fecha = "SELECT DISTINCT fecha, docente_id, expediente_docente_id from inasistencia_sin_aviso_docente";
    $result_fecha = mysqli_query($conexion, $query_fecha);

    while ($row_fecha = mysqli_fetch_array($result_fecha)) {
      if ($row_fecha['expediente_docente_id'] == Null) {
        $fecha = $row_fecha['fecha'];
        $docente = $row_fecha['docente_id'];
        $query_fecha_dia = "select weekday ('$fecha')";
        $result_fecha_dia = mysqli_query($conexion, $query_fecha_dia);

        while ($row_fecha_dia = mysqli_fetch_array($result_fecha_dia)) {
          $fecha_dia = $row_fecha_dia[0];
          $query_docente = "SELECT persona.nombre, m1.id FROM persona, 
                            (SELECT persona_id, id FROM docente,
                            (SELECT DISTINCT docente_id, fecha from inasistencia_sin_aviso_docente 
                            where fecha = '$fecha' and docente_id='$docente' ) as m2 
                            WHERE docente.id = m2.docente_id ) as m1 
                            Where m1.persona_id = persona.id;";
          $result_docente = mysqli_query($conexion, $query_docente);

          while ($row_docente = mysqli_fetch_array($result_docente)) {
            $docente_id = $row_docente['id'];
            $days = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo');
  ?>
            <table class="table table-striped table-dark">
             <!--  <thead>
                <tr>
                  <th scope="col">Agente</th>
                  <th class="text-center" scope="col">Dia</th>
                  <th class="text-center" scope="col">Inasistencias</th>
                  <th class="text-center" scope="col">Horas totales</th>

                </tr>
              </thead> -->
              <tbody>
                <tr class="table-secondary text-dark">
                  <td class="col-3 pl-4"><?php echo $row_docente['nombre'] ?></td>
                  <td class="text-center col-3"><?php echo $days[$fecha_dia], ' ( ', $fecha,' )' ?></td>
                  <?php
                  $contador = "SELECT COUNT(docente_id) from inasistencia_sin_aviso_docente where fecha= '$fecha' and docente_id='$docente'";
                  $contador_docente = mysqli_query($conexion, $contador);
                  while ($row_contador = mysqli_fetch_array($contador_docente)) {
                  ?>
                    <td class="text-center col-3"><?php echo 'Inasistencias: ' .$row_contador[0] ?></td>

                    <?php
                    $query_total = "SELECT * FROM inasistencia_sin_aviso_docente WHERE fecha = '$fecha' and docente_id='$docente'";
                    $result_total = mysqli_query($conexion, $query_total);
                    $val_fin = 0;
                    $val_inicio = 0;
                    $total = 0;
                    while ($row_total = mysqli_fetch_array($result_total)) {
                      $val_fin = (int)$row_total['hora_fin'];
                      $val_inicio = (int)$row_total['hora_inicio'];
                      $total += ($val_fin - $val_inicio);
                    }
                    ?>
                    <td class="text-center col-3"><?php echo 'Horas faltadas: '.$total ?></td>

                </tr>
              <?php
                  }
              ?>
              <tr>
                <table class="table ml-3 table-sm ">
                  <thead>
                    <tr>
                      <th scop="col">ID</th>
                      <th scope="col">Catedra</th>
                      <th scope="col">Jornada</th>
                      <th scope="col">Hora de ingreso</th>
                      <th scope="col">Horas fin</th>
                      <th scope="col">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $query_inasist = "SELECT * FROM inasistencia_sin_aviso_docente WHERE fecha='$fecha' and docente_id='$docente'";
                    $result_inasist = mysqli_query($conexion, $query_inasist);
                    while ($row_inasist = mysqli_fetch_array($result_inasist)) {
                      $catedra_id = $row_inasist['catedra_id'];
                      foreach (get_catedra($conexion,$catedra_id)as $get_catedra):
                        $catedra = $get_catedra['nombre'];
                      endforeach;
                    ?>
                      <tr>
                        <td class="col-1"><?php echo $row_inasist['id'] ?></td>
                        <td class="col-2"><?php 
                        if ($catedra_id == null) {
                          echo "... ";
                        }else{
                        echo $catedra;
                        }
                        
                        ?></td>
                        <td class="col-2"><?php echo $row_inasist['descripcion'] ?></td>
                        <td class="col-2"><?php echo $row_inasist['hora_inicio'] ?></td>
                        <td class="col-2"><?php echo $row_inasist['hora_fin'] ?></td>
                        <td class="col-2">
                          <form class="d-inline-block" action="inasistencia_delete.php" method="POST">
                              <input type="hidden" name=docente_id value="<?= $docente_id ?>">
                              <input type="hidden" name=hora_inicio value="<?= $row_inasist['hora_inicio'] ?>">
                              <input type="hidden" name=hora_fin value="<?= $row_inasist['hora_fin']?>">
                              <input type="hidden" name=fecha_dia value="<?=  $fecha_dia ?>">
                              <input type="hidden" name=fecha value="<?=  $fecha ?>">
                              <button class="btn btn-sm btn-danger" type="submit" name="id_docente" value="<?= $row_inasist['id'] ?>" onclick="return confirm('Al eliminar la inasistencia ID <?= $row_inasist['id'] ?> generara una asistencia para el registro ¿Desea continuar? ')">
                              <i class="fa fa-trash"></i>
                          </button>
                          </form>
                          <form class="d-inline-block" action="eliminar_inasis.php" method="POST">
                              <button class="btn btn-sm btn-danger" type="submit" name="id_docente" value="<?= $row_inasist['id'] ?>" onclick="return confirm('Se eliminar la inasistencia ID <?= $row_inasist['id'] ?>')">
                              <i class="fa fa-edit"></i>
                          </button>
                          </form>
                        </td>
                      <?php
                    }
                      ?>
                      </tr>
                  </tbody>
                </table>
              </tr>
              </tbody>

            </table>
    <?php }
        }
      }
    } ?>
    <form action="" method="post">
      <button class="btn btn-secondary pull-right" type="submit" name="generar" onclick="return confirm('Se crearan expedientes para las inasistencias docentes.¿Desea continuar?')">Generar expedientes</button>
    </form>
    <?php
  } else {
    ?>
<p>Las inasistencias de un mismo dia se agrupan en un solo expediente, este dice la cantidad de 
  inasistencais que contiene y la cantidad de horas que se ausento el no docente ese dia<p>
<?php
    $query_fecha = "SELECT DISTINCT fecha, no_docente_id, expediente_no_docente_id from inasistencia_sin_aviso_no_docente";
    $result_fecha = mysqli_query($conexion, $query_fecha);
    while ($row_fecha = mysqli_fetch_array($result_fecha)) {
      if ($row_fecha['expediente_no_docente_id'] == Null) {
        $fecha = $row_fecha['fecha'];
        $no_docente = $row_fecha['no_docente_id'];
        $query_fecha_dia = "select weekday ('$fecha')";
        $result_fecha_dia = mysqli_query($conexion, $query_fecha_dia);
        while ($row_fecha_dia = mysqli_fetch_array($result_fecha_dia)) {
          $fecha_dia = $row_fecha_dia[0];

          $query_no_docente = "SELECT persona.nombre, m1.id FROM persona, (SELECT persona_id, id FROM no_docente, (SELECT DISTINCT no_docente_id, fecha from inasistencia_sin_aviso_no_docente where fecha = '$fecha' and no_docente_id='$no_docente' ) as m2 WHERE no_docente.id = m2.no_docente_id ) as m1 Where m1.persona_id = persona.id;";
          $result_no_docente = mysqli_query($conexion, $query_no_docente);
          while ($row_no_docente = mysqli_fetch_array($result_no_docente)) {
            $no_docente_id = $row_no_docente['id'];
            $days = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo');
    ?>
            <table class="table table-striped table-dark">
           <!--    <thead>
                <tr>
                  <th scope="col">Agente</th>
                  <th class="text-center" scope="col">Dia</th>
                  <th class="text-center" scope="col">Inasistencias</th>
                  <th class="text-center" scope="col">Horas totales</th>

                </tr>
              </thead> -->
              <tbody>
              <tr class="table-secondary text-dark">
                  <td class="col-3 pl-4"><?php echo $row_no_docente['nombre'] ?></td>
                  <td class="text-center col-3"><?php echo $days[$fecha_dia], ' ( ', $fecha,' )' ?></td>
                  <?php
                  $contador = "SELECT COUNT(no_docente_id) from inasistencia_sin_aviso_no_docente where fecha= '$fecha' and no_docente_id='$no_docente'";
                  $contador_no_docente = mysqli_query($conexion, $contador);
                  while ($row_contador = mysqli_fetch_array($contador_no_docente)) {
                  ?>
                    <td class="text-center col-3"><?php echo 'Inasistencias: '.$row_contador[0] ?></td>
                    <?php
                    $query_total = "SELECT * FROM inasistencia_sin_aviso_no_docente WHERE fecha = '$fecha' and no_docente_id='$no_docente'";
                    $result_total = mysqli_query($conexion, $query_total);
                    $val_fin = 0;
                    $val_inicio = 0;
                    $total = 0;
                    while ($row_total = mysqli_fetch_array($result_total)) {
                      $val_fin = (int)$row_total['hora_fin'];
                      $val_inicio = (int)$row_total['hora_inicio'];
                      $total += ($val_fin - $val_inicio);
                    }
                    ?>
                    <td class="text-center col-3"><?php echo'Horas faltadas: '. $total ?></td>

                </tr>
              <?php } ?>
              <tr>
                <table class="table ml-3 table-sm ">
                  <thead>
                    <tr>
                      <th scop="col">id</ht>
                      <th scope="col">Area</th>
                      <th scope="col">Hora de ingreso</th>
                      <th scope="col">Horas fin</th>
                      <th scope="col">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $query_inasist = "SELECT * FROM inasistencia_sin_aviso_no_docente WHERE fecha='$fecha' and no_docente_id='$no_docente'";
                    $result_inasist = mysqli_query($conexion, $query_inasist);
                    while ($row_inasist = mysqli_fetch_array($result_inasist)) {
                    ?>
                      <tr>
                        <td class="col-1"><?php echo $row_inasist['id'] ?></td>
                        <td class="col-3"><?php echo $row_inasist['area'] ?></td>
                        <td class="col-3"><?php echo $row_inasist['hora_inicio'] ?></td>
                        <td class="col-3"><?php echo $row_inasist['hora_fin'] ?></td>
                        <td class="col-2">
                          <form class="d-inline-block" action="inasistencia_delete.php" method="POST">
                          <input type="hidden" name=no_docente_id value="<?= $no_docente ?>">
                          <input type="hidden" name=hora_inicio value="<?= $row_inasist['hora_inicio'] ?>">
                          <input type="hidden" name=hora_fin value="<?= $row_inasist['hora_fin']?>">
                          <input type="hidden" name=fecha_dia value="<?=  $fecha_dia ?>">
                          <input type="hidden" name=fecha value="<?=  $fecha ?>">
                          <button class="btn btn-sm btn-danger" type="submit" name="id_no_docente" value="<?= $row_inasist['id'] ?>" onclick="return confirm('Al eliminar la inasistencia ID <?= $row_inasist['id'] ?> generara una asistencia para el registro ¿Desea continuar?')">
                          <i class="fa fa-trash"></i>
                      </button>
                          </form>
                          <form class="d-inline-block" action="eliminar_inasis.php" method="POST">
                              <button class="btn btn-sm btn-danger" type="submit" name="id_no_docente" value="<?= $row_inasist['id'] ?>" onclick="return confirm('Se eliminar la inasistencia ID <?= $row_inasist['id'] ?>')">
                              <i class="fa fa-edit"></i>
                          </button>
                          </form>
                        </td>
                      <?php  } ?>
                      </tr>
                  </tbody>
                </table>
              </tr>
              </tbody>

            </table>
    <?php  }
        }
      }
    } ?>
    <form action="" method="post">
      <button class="btn btn-secondary pull-right" type="submit" name="generar_no_docente" onclick="return confirm('Se crearan expedientes para las inasistencias no docentes.¿Desea continuar?')">Generar expedientes</button>
    </form>

  <?php }

  if (isset($_POST['generar'])) {

    $query_generar = "SELECT docente_id, fecha,expediente_docente_id FROM `inasistencia_sin_aviso_docente` where expediente_docente_id is NULL GROUP BY docente_id, fecha";
    $result_generar = mysqli_query($conexion, $query_generar);
    while ($row_generar = mysqli_fetch_array($result_generar)) {
      $docente = $row_generar['docente_id'];
      $fecha = $row_generar['fecha'];

      $query_docente = "SELECT persona_id FROM docente WHERE id='$docente'";
      $result_docente = mysqli_query($conexion, $query_docente);
      while ($row_docente = mysqli_fetch_array($result_docente)) {
        $persona = $row_docente['persona_id'];
      }

      $insertar_expediente = "INSERT INTO expediente(persona_id,fecha_inicio,fecha_fin,confirmado,codigo_id) VALUES( '$persona','$fecha','$fecha','0','2')";
      if (($result_insertar = mysqli_query($conexion, $insertar_expediente)) === false) {
        die(mysqli_error($conexion));
      }
      $id = mysqli_insert_id($conexion);

      $insertar_expediente_docente = "INSERT INTO expediente_docente(expediente_id,docente_id) VALUES( '$id','$docente')";
      if (($result_insertar_docente = mysqli_query($conexion, $insertar_expediente_docente)) === false) {
        die(mysqli_error($conexion));
      }
      $id_expdt_docente = mysqli_insert_id($conexion);


      $query_modificacion = "UPDATE inasistencia_sin_aviso_docente set expediente_docente_id='" . $id_expdt_docente . "' WHERE docente_id='" . $docente . "' AND fecha='" . $fecha . "'";
      $result_modificacion = mysqli_query($conexion, $query_modificacion) or die("error" . mysqli_error($conexion));


      $query_mes = "SELECT EXTRACT(month FROM DATE '$fecha')";
      $result_mes = mysqli_query($conexion, $query_mes) or die("error" . mysqli_error($conexion));
      while ($row_mes = mysqli_fetch_array($result_mes)) {
        $mes = $row_mes[0];
      }

      $query_anio = "SELECT EXTRACT(year FROM DATE '$fecha')";
      $result_anio = mysqli_query($conexion, $query_anio) or die("error" . mysqli_error($conexion));
      while ($row_anio = mysqli_fetch_array($result_anio)) {
        $anio = $row_anio[0];
      }

      $query_pprod = "SELECT * FROM planilla_productividad_docente WHERE mes_id = '$mes' AND anio = '$anio'";
      $result_pprod = mysqli_query($conexion, $query_pprod);

      if (mysqli_num_rows($result_pprod) == 0) {
        $query_crear_pprod = "INSERT into planilla_productividad_docente (mes_id, anio) VALUES ('$mes','$anio')";
        $result_crear_pprod = mysqli_query($conexion, $query_crear_pprod);
      }
      $result_pprod = mysqli_query($conexion, $query_pprod);

      while ($row_pprod = mysqli_fetch_array($result_pprod)) {
        $pprod = $row_pprod[0];
      }
      $total = 0;
      $hora_inicio = 0;
      $hora_fin = 0;
      $query_horas = "SELECT * FROM inasistencia_sin_aviso_docente WHERE docente_id = '$docente' and fecha = '$fecha'";
      $result_horas = mysqli_query($conexion, $query_horas) or die("error" . mysqli_error($conexion));
      while ($row_horas = mysqli_fetch_array($result_horas)) {
        $hora_inicio = (int)$row_horas['hora_inicio'];
        $hora_fin = (int)$row_horas['hora_fin'];
        $total = $total + ($hora_fin - $hora_inicio);
      }


      $planilla_expdt = "INSERT INTO expediente_planilla_docente (planilla_productividad_docente_id, expediente_docente_id, hs_descontadas) VALUES ('$pprod','$id_expdt_docente',$total)";
      $result_planilla_expdt = mysqli_query($conexion, $planilla_expdt) or die("error" . mysqli_error($conexion));
      $result_pprod = mysqli_query($conexion, $query_pprod) or die("error" . mysqli_error($conexion));
    }
   
    $ActualizarDespuesDe = 1;
    header('Refresh: '.$ActualizarDespuesDe);
  }
  if (isset($_POST['generar_no_docente'])) {
    $query_generar = "SELECT no_docente_id, fecha,expediente_no_docente_id FROM `inasistencia_sin_aviso_no_docente` where expediente_no_docente_id is NULL GROUP BY no_docente_id, fecha";
    $result_generar = mysqli_query($conexion, $query_generar);
    while ($row_generar = mysqli_fetch_array($result_generar)) {
      $no_docente = $row_generar['no_docente_id'];
      $fecha = $row_generar['fecha'];

      $query_no_docente = "SELECT persona_id FROM no_docente WHERE id='$no_docente'";
      $result_no_docente = mysqli_query($conexion, $query_no_docente);
      while ($row_no_docente = mysqli_fetch_array($result_no_docente)) {
        $persona = $row_no_docente['persona_id'];
      }

      $insertar_expediente = "INSERT INTO expediente(persona_id,fecha_inicio,fecha_fin,codigo_id) VALUES( '$persona','$fecha','$fecha','2')";
      if (($result_insertar = mysqli_query($conexion, $insertar_expediente)) === false) {
        die(mysqli_error($conexion));
      }
      $id = mysqli_insert_id($conexion);

      $insertar_expediente_no_docente = "INSERT INTO expediente_no_docente(expediente_id,no_docente_id) VALUES( '$id','$no_docente')";
      if (($result_insertar_no_docente = mysqli_query($conexion, $insertar_expediente_no_docente)) === false) {
        die(mysqli_error($conexion));
      }
      $id_expdt_no_docente = mysqli_insert_id($conexion);



      $query_modificacion = "UPDATE inasistencia_sin_aviso_no_docente set expediente_no_docente_id='" . $id_expdt_no_docente . "' WHERE no_docente_id='" . $no_docente . "' AND fecha='" . $fecha . "'";
      $result_modificacion = mysqli_query($conexion, $query_modificacion) or die("error" . mysqli_error($conexion));

      $query_mes = "SELECT EXTRACT(month FROM DATE '$fecha')";
      $result_mes = mysqli_query($conexion, $query_mes) or die("error" . mysqli_error($conexion));
      while ($row_mes = mysqli_fetch_array($result_mes)) {
        $mes = $row_mes[0];
      }

      $query_anio = "SELECT EXTRACT(year FROM DATE '$fecha')";
      $result_anio = mysqli_query($conexion, $query_anio) or die("error" . mysqli_error($conexion));
      while ($row_anio = mysqli_fetch_array($result_anio)) {
        $anio = $row_anio[0];
      }

      $query_pprod = "SELECT * FROM planilla_productividad_no_docente WHERE mes_id = '$mes' AND anio = '$anio'";
      $result_pprod = mysqli_query($conexion, $query_pprod);
      if (mysqli_num_rows($result_pprod) == 0) {
        $query_crear_pprod = "INSERT into planilla_productividad_no_docente (mes_id, anio) VALUES ('$mes','$anio')";
        $result_crear_pprod = mysqli_query($conexion, $query_crear_pprod);
      }
      $result_pprod = mysqli_query($conexion, $query_pprod);
      while ($row_pprod = mysqli_fetch_array($result_pprod)) {
        $pprod = $row_pprod[0];
      }

      $total = 0;
      $hora_inicio = 0;
      $hora_fin = 0;

      $query_horas = "SELECT * FROM inasistencia_sin_aviso_no_docente WHERE no_docente_id = '$no_docente' and fecha = '$fecha'";
      $result_horas = mysqli_query($conexion, $query_horas) or die("error" . mysqli_error($conexion));
      while ($row_horas = mysqli_fetch_array($result_horas)) {
        $hora_inicio = (int)$row_horas['hora_inicio'];
        $hora_fin = (int)$row_horas['hora_fin'];
        $total = $total + ($hora_fin - $hora_inicio);
      }


      $planilla_expdt = "INSERT INTO expediente_planilla_no_docente (planilla_productividad_no_docente_id, expediente_no_docente_id, hs_descontadas) VALUES ('$pprod','$id_expdt_no_docente',$total)";
      $result_planilla_expdt = mysqli_query($conexion, $planilla_expdt) or die("error" . mysqli_error($conexion));
      $result_pprod = mysqli_query($conexion, $query_pprod) or die("error" . mysqli_error($conexion));
    }
    $ActualizarDespuesDe = 1;
    header('Refresh: '.$ActualizarDespuesDe);
  }
 

  ?>
  </tbody>
  </table>

</div>

<?php include("../includes/footer.php") ?>
<?php
ob_end_flush();
?>