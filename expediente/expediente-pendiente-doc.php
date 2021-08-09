<?php include("../includes/header.php"); ?>


<div class="container-fluid">

    <div class="row">
        <div class="col-md-5 m-auto">
            <form action="" method="post">
                <div class="form-group text-center">
                    <h2 class="col-md-12">Expedientes pendientes de documentación</h2>
                    <div class="row m-auto col">
                        <select name="select" class="form-control mr-sm-2 col">
                            <option value="Docente">Docente </option>
                            <option value="No docente">No docente </option>
                        </select>
                        <button class="btn btn-outline-success my-2 my-sm-0 col" name="expedt_sin_doc" type="submit">BUSCAR.</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    if (isset($_POST['expedt_sin_doc'])) {
        $tipo_agente = $_POST['select'];
        if ($tipo_agente == 'Docente') {
    ?>
            <h3>EXPEDIENTES:<small class="text-muted"> DOCENTE</small></h3>

            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                        <th scope="col">ID expdt</th>
                        <th scope="col">Agente</th>
                        <th scope="col">Fecha de inicio</th>
                        <th scope="col">Codigo</th>
                        <th scope="col">Aviso</th>
                        <th scope="col">Archivo</th>
                        <th scope="col">Acción</th>
                    </tr>
                </thead>
                <?php
                $query_sin_doc = "SELECT expediente.id , persona_id FROM expediente,(SELECT id FROM `codigo` WHERE requiere_doc=1) as m1 WHERE m1.id = expediente.codigo_id And expediente.doc_justificada_id is NULL";
                $result_sin_doc = mysqli_query($conexion, $query_sin_doc);
                while ($row_sin_doc = mysqli_fetch_array($result_sin_doc)) {
                    $persona =  $row_sin_doc['persona_id'];
                    $expdt_id = $row_sin_doc['id'];

                    $query_tipo_agente = "SELECT *FROM expediente_docente WHERE expediente_id ='$expdt_id'";
                    $result_tipo_agente = mysqli_query($conexion, $query_tipo_agente);
                    while ($row_tipo_agente = mysqli_fetch_array($result_tipo_agente)) {

                        $expdt_docente_id = "SELECT *FROM expediente WHERE id='$expdt_id'";
                        $result_expdt_docente_id = mysqli_query($conexion, $expdt_docente_id);
                        while ($row_expdt_docente_id = mysqli_fetch_array($result_expdt_docente_id)) {

                            $query_docente = "SELECT *FROM persona Where id = '$persona'";
                            $result_docente = mysqli_query($conexion, $query_docente);
                            while ($row_docente = mysqli_fetch_array($result_docente)) {

                ?>
                                <tbody>
                                    <tr>
                                        <td><?= $expdt_id ?></td>
                                        <td><?php echo $row_docente['nombre'];
                                        } ?></td>
                                        <td><?php echo $row_expdt_docente_id['fecha_inicio'] ?></td>
                                        <td><?php echo $row_expdt_docente_id['codigo_id'] ?></td>
                                        <td><?php if ($row_expdt_docente_id['aviso_id'] == NULL) {
                                                echo 'Sin aviso';
                                            } else {
                                                echo 'aviso valido';
                                            } ?></td>
                                        <td style="color:blue"><?php if ($row_expdt_docente_id['doc_justificada_id'] == NULL) {
                                                                    echo 'Sin Documentación';
                                                                } ?></td>
                                        <td><a class="btn btn-primary" href="modificar-expediente.php?id=<?= $expdt_id ?>">Agregar doc</a></td>
                            <?php
                        }
                    }
                }
            } else {
                            ?>
                            <h3>EXPEDIENTES: <small class="text-muted"> NO DOCENTE</small></h3>
                            <table class="table table-striped table-dark">
                                <thead>
                                    <tr>
                                        <th scope="col">ID expdt</th>
                                        <th scope="col">Agente</th>
                                        <th scope="col">Fecha de inicio</th>
                                        <th scope="col">Codigo</th>
                                        <th scope="col">Aviso</th>
                                        <th scope="col">Archivo</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                </thead>
                                <?php
                                $query_sin_doc = "SELECT expediente.id , persona_id FROM expediente,(SELECT id FROM `codigo` WHERE requiere_doc=1) as m1 WHERE m1.id = expediente.codigo_id And expediente.doc_justificada_id is NULL";
                                $result_sin_doc = mysqli_query($conexion, $query_sin_doc);
                                while ($row_sin_doc = mysqli_fetch_array($result_sin_doc)) {
                                    $persona =  $row_sin_doc['persona_id'];
                                    $expdt_id = $row_sin_doc['id'];

                                    $query_tipo_agente = "SELECT *FROM expediente_no_docente WHERE expediente_id ='$expdt_id'";
                                    $result_tipo_agente = mysqli_query($conexion, $query_tipo_agente);
                                    while ($row_tipo_agente = mysqli_fetch_array($result_tipo_agente)) {
                                        $expdt_no_docente_id = "SELECT *FROM expediente WHERE id='$expdt_id'";
                                        $result_expdt_no_docente_id = mysqli_query($conexion, $expdt_no_docente_id);
                                        while ($row_expdt_no_docente_id = mysqli_fetch_array($result_expdt_no_docente_id)) {

                                            $query_no_docente = "SELECT *FROM persona Where id = '$persona'";
                                            $result_no_docente = mysqli_query($conexion, $query_no_docente);
                                            while ($row_no_docente = mysqli_fetch_array($result_no_docente)) {
                                ?>
                                                <tbody>
                                                    <tr>
                                                        <td><a href="modificar-expediente.php?id=<?= $expdt_id ?>"></a></td>
                                                        <td><?php echo $row_no_docente['nombre'];
                                                        } ?></td>
                                                        <td><?php echo $row_expdt_no_docente_id['fecha_inicio'] ?></td>
                                                        <td><?php echo $row_expdt_no_docente_id['codigo_id'] ?></td>
                                                        <td><?php if ($row_expdt_no_docente_id['aviso_id'] == NULL) {
                                                                echo 'Sin aviso';
                                                            } else {
                                                                echo 'aviso valido';
                                                            } ?></td>
                                                        <td style="color:blue"><?php if ($row_expdt_no_docente_id['doc_justificada_id'] == NULL) {
                                                                                    echo 'Sin Documentación';
                                                                                } ?></td>
                                                        <td> <button>Agregar</button></td>
                                                    </tr>
                                <?php
                                        }
                                    }
                                }
                            }
                        }
                                ?>
                            </table>

</div>
<?php include("../includes/footer.php"); ?>