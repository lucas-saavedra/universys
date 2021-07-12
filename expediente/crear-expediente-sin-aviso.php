<?php include ("../includes/header.php");?>
<?php include('../dataBase.php');?>

<div class="container-fluid">

    <div class="row">
        <div class="col-lg-6 m-auto">
            <form action="" method="post">
                <div class="form-group">
                    <label for="precio">Crear expediente sin aviso</label>
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="expedt">traer expedientes</button>
                </div>
            </form>  
        </div>
    </div>
    <?php 
    if (isset($_POST['expedt'])){
      $query_fecha = "SELECT DISTINCT fecha, docente_id, expediente_docente_id from inasistencia_sin_aviso_docente";
      $result_fecha = mysqli_query($conexion,$query_fecha);
      while($row_fecha = mysqli_fetch_array($result_fecha)) {
        if ($row_fecha['expediente_docente_id'] == Null){
        $fecha= $row_fecha['fecha'];
        $docente= $row_fecha['docente_id'];
          $query_fecha_dia = "select weekday ('$fecha')";
          $result_fecha_dia = mysqli_query($conexion,$query_fecha_dia);
          while($row_fecha_dia = mysqli_fetch_array($result_fecha_dia)) {
            $fecha_dia= $row_fecha_dia[0];


          $query_docente = "SELECT persona.nombre, m1.id FROM persona, (SELECT persona_id, id FROM docente,
          (SELECT DISTINCT docente_id, fecha from inasistencia_sin_aviso_docente where fecha = '$fecha' and docente_id='$docente' ) 
          as m2 WHERE docente.id = m2.docente_id ) as m1 Where m1.persona_id = persona.id;";
          $result_docente = mysqli_query($conexion,$query_docente);
          while($row_docente = mysqli_fetch_array($result_docente)) {
          $docente_id= $row_docente['id'];
          $days = array('Lunes','Martes', 'Miercoles', 'Jueves','Viernes','Sabado','Domingo');
    ?>
<table class="table table-striped table-dark">
  <thead>
    <tr>
      <th scope="col">Agente</th>
      <th scope="col">Dia</th>
      <th class="text-center" scope="col">Inasistencias</th>
      <th scope="col">Horas totales</th>
      <th scope="col">Acciones</th>
    </tr>
  </thead>
  
  <tbody>
   
    <tr>
      <td><?php echo $row_docente['nombre']?></td>
      <td><?php echo $days[$fecha_dia] ?></td>
      <?php 
        $contador="SELECT COUNT(docente_id) from inasistencia_sin_aviso_docente where fecha= '$fecha' and docente_id='$docente'";
        $contador_docente = mysqli_query($conexion,$contador);
        while($row_contador = mysqli_fetch_array($contador_docente)) {
      ?>
      <td class="text-center">
      <?php echo $row_contador[0]?>
      </td>
     
        
        <?php 
            $query_total = "SELECT * FROM inasistencia_sin_aviso_docente WHERE fecha = '$fecha' and docente_id='$docente'";
           $result_total = mysqli_query($conexion,$query_total);
            $val_fin= 0;
            $val_inicio= 0;
            $total = 0;
            while($row_total = mysqli_fetch_array($result_total)) {
              $val_fin= (int)$row_total['hora_fin'];
              $val_inicio= (int)$row_total['hora_inicio'];
              $total += ($val_fin - $val_inicio);
            }
          ?>
      <td><?php echo $total ?></td>
      <td>
          <button type="button" class="fas fa-info-circle fa-lg fa-fw"></button>
      </td>
    </tr>
    <?php 
        }
        ?>
    <tr>
      <table class="table table-striped ml-5">
        <thead>
          <tr>
            <th scope="col">Fecha</th>
            <th scope="col">Hora de ingreso</th>
            <th scope="col">Horas fin</th>
          </tr>
        </thead>
        <tbody>
          <?php 

            $query_inasist = "SELECT * FROM inasistencia_sin_aviso_docente WHERE fecha='$fecha' and docente_id='$docente'";
            $result_inasist = mysqli_query($conexion,$query_inasist);
            while($row_inasist = mysqli_fetch_array($result_inasist)) {
             
          ?>
          <tr>
            <td><?php echo $row_inasist['fecha']?></td>
            <td><?php echo $row_inasist['hora_inicio']?></td>
            <td><?php echo $row_inasist['hora_fin']?></td>
              <?php 
                }
              ?>
          </tr>
        </tbody>
      </table>
    </tr>
    <?php 
        }
      }
    }
  }
}
        ?>
  </tbody>
</table>

</div>


<?php include("../includes/footer.php") ?>