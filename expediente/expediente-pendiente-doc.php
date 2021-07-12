<?php include ("../includes/header.php");?>
<?php include('../dataBase.php');?>

<div class="container-fluid">

    <div class="row">
        <div class="col-md-10 m-auto">
            <form action="" method="post">
                <div class="form-group">
                    <label for="precio">expediente pendiente de documentación</label>
                    <button class="btn btn-outline-success my-2 my-sm-0" name="expedt_sin_doc" type="submit">Traer documentacion</button>
                </div>
            </form>  
        </div>
    </div>
    <?php
        if (isset($_POST['expedt_sin_doc'])){
    ?>
    <table class="table table-striped table-dark">
    <thead>
        <tr>
        <th scope="col">Agente</th>
        <th scope="col">Fecha de inicio</th>
        <th scope="col">Codigo</th>
        <th scope="col">Aviso</th>
        <th scope="col">Archivo</th>
        <th scope="col">Acción</th>
        </tr>
    </thead>
    <?php 
        $query_sin_doc = "SELECT *FROM expediente,(SELECT id FROM `codigo` WHERE requiere_doc=1) as m1 
        WHERE m1.id = expediente.codigo_id";
        
        $result_sin_doc = mysqli_query($conexion,$query_sin_doc);
        while ($row_sin_doc = mysqli_fetch_array($result_sin_doc)){
            $persona =  $row_sin_doc['persona_id'];
            $query_docente = "SELECT *FROM persona Where id = '$persona'";
            $result_docente = mysqli_query($conexion,$query_docente);
            while($row_docente = mysqli_fetch_array($result_docente)){
    ?>
    <tbody>
        <tr>
        <td><?php echo $row_docente ['nombre']?></td>
        <td><?php echo $row_sin_doc['fecha_inicio']?></td>
        <td><?php echo $row_sin_doc['codigo_id']?></td>
        <td><?php if( $row_sin_doc['aviso_id'] == NULL){ 
           echo 'Sin aviso';}
           else{echo 'aviso valido';}?>
           
           </td>
        <td style="color:blue"><?php if( $row_sin_doc['doc_justificada_id'] == NULL){ 
           echo 'Sin Documentación';}?></td>
        <td> <button>Agregar Doc</button></td>
    <?php
        }
    }
}
    ?>
 </table>

</div>
<?php include("../includes/footer.php"); ?>