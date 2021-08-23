<?php 
include("../jornada/navbar.php");
include("./includes/consultas.php");

$hoy = new DateTime('NOW');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $id_mes_actual = $hoy->format('n');
    $mes = get_meses($conexion, $id_mes_actual)[0]['nombre'];
    $anio = $hoy->format('Y');
    $tipo_agente = "Docente";
} else {
    $mes = $_POST['mes'];
    $anio = $_POST['anio'];
    $tipo_agente = $_POST['select'];
}

if (isset($_SESSION['elim_expdte_msg'])) {
    $msg = $_SESSION['elim_expdte_msg'];
    unset($_SESSION['elim_expdte_msg']);
}


?>

<div class="container-fluid">
    <div class="row jumbotron jumbotron-fluid">
        <div class="col-md-10 m-auto">
            <form action="" method="post">
                <div class="form-group mt-4">
                    <div class="row mb-2">
                        <div class="col text-center">
                            <h2 class="">Planilla de productividad</h2>
                        </div>
                    </div>
                    <div class="row col text-center">
                        <select name="select" class="form-control mr-sm-2 col-3" required>
                            <option value="Docente" <?= $tipo_agente == 'Docente' ? 'selected' : '' ?>>Docente</option>
                            <option value="No docente" <?= $tipo_agente == 'No docente' ? 'selected' : '' ?>>No docente</option>
                        </select>
                        <select name="mes" class="form-control mr-sm-2 col-3" required>
                            <option value="" selected disabled>Seleccione un mes</option>
                            <?php foreach (get_meses($conexion) as $_mes) : ?>
                                <option value="<?= $_mes['nombre'] ?>" <?= $_mes['nombre'] == $mes ? 'selected' : '' ?>>
                                    <?= $_mes['nombre'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input class="form-control mr-sm-2 col" type="number" name="anio" placeholder="Ingrese el año" value="<?= $anio ?>" required>
                        <button class="btn btn-outline-success my-2 my-sm-0 d-inline-block" type="submit"><i class="fa fa-search"></i> BUSCAR</button>
                        <!--<a href="desc_exel.php" class="btn btn-outline-success">descargar</a> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    include "includes/msg-box.php";
    if ($tipo_agente == 'Docente') {
        $query_planilla = "SELECT  planilla_productividad_docente.id,planilla_productividad_docente.anio, m1.nombre FROM planilla_productividad_docente,(SELECT * FROM mes WHERE nombre= '$mes') as m1 WHERE m1.id= planilla_productividad_docente.mes_id and anio='$anio'";
        $result_planilla = mysqli_query($conexion, $query_planilla);

        while ($row_planilla = mysqli_fetch_array($result_planilla)) {
            if ($row_planilla > 0) {
                $planilla_id = $row_planilla['id']
    ?>
                <table class="table table-striped table-dark table-sm">
                    <thead>
                        <tr>
                            <th scope="col">UNIVERSIDAD AUTÓNOMA DE ENTRE RÍOS</th>
                            <th scope="col">Facultad: Ciencia y Tecnología</th>
                            <th scope="col">Sede: Chajarí</th>
                            <th scope="col">Planilla: <?php echo $tipo_agente ?></th>
                            <th scope="col">Mes: <?php echo $row_planilla['nombre'] ?></th>
                            <th scope="col">Año: <?php echo $row_planilla['anio'] ?></th>
                        </tr>
                    </thead>
                </table>
            <?php
            }
            $query_docente = "SELECT persona.dni, persona.nombre, m2.id, m2.antiguedad FROM persona,
                                    (SELECT persona_id, id, antiguedad FROM docente,
                                    (SELECT DISTINCT docente_id FROM expediente_docente,
                                    (SELECT * FROM `expediente_planilla_docente` WHERE planilla_productividad_docente_id = '$planilla_id') 
                                    as m1 where m1.expediente_docente_id = expediente_docente.id) 
                                    as m1 where m1.docente_id = docente.id) 
                                    as m2 where m2.persona_id = persona.id;";

            $result_docente = mysqli_query($conexion, $query_docente);
            while ($row_docente = mysqli_fetch_array($result_docente)) {
                $docente_id = $row_docente['id']
            ?>

                <table class="table table-striped table-dark table-sm">
                    <thead class="col-md-12">
                        <tr>
                            <th class="text-center" scope="col">DNI</th>
                            <th class="text-center" scope="col">Agente</th>
                            <th class="text-center" scope="col">Horas descontadas</th>
                            <th class="text-center" scope="col">Total horas/antiguedad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_hs = '0';
                        $hs = '0';
                        $query_hs = "SELECT *FROM expediente_planilla_docente, (SELECT id FROM expediente_docente WHERE docente_id ='$docente_id') as m1 WHERE  m1.id = expediente_docente_id";
                        $result_hs = mysqli_query($conexion, $query_hs);
                        while ($row_hs = mysqli_fetch_array($result_hs)) {
                            $hs = $row_hs['hs_descontadas'];
                            $total_hs = $total_hs + $hs;
                        }
                        ?>
                        <tr>
                            <td scope="row"><?php echo $row_docente['dni'] ?></td>
                            <td class="text-center"><?php echo $row_docente['nombre'] ?></td>
                            <td class="text-center"><?php echo $total_hs ?></td>
                            <td class="text-center"><?php echo $row_docente['antiguedad'] ?></td>
                        </tr>
                        <tr>
                            <table class="table table-striped ml-4">
                                <thead>
                                    <tr>
                                        <th scope="col">Codigo</th>
                                        <th scope="col">Tipo</th>
                                        <th scope="col">Descripcion</th>
                                        <th scope="col">Desde</th>
                                        <th scope="col">Hasta</th>
                                        <th scope="col">Descuento</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <?php
                                $query_expediente = "SELECT * FROM expediente, 
                                        (SELECT * FROM `expediente_docente` WHERE docente_id ='$docente_id') as m1
                                        WHERE m1.expediente_id = expediente.id";
                                $result_expediente = mysqli_query($conexion, $query_expediente);
                                while ($row_expediente = mysqli_fetch_array($result_expediente)) {
                                    $descripcion = $row_expediente['codigo_id'];
                                    $query_descripcion = "SELECT *FROM codigo WHERE id = '$descripcion'";
                                    $result_descripcion = mysqli_query($conexion, $query_descripcion);
                                    while ($row_descripcion = mysqli_fetch_array($result_descripcion)) {
                                        $desc = $row_descripcion['descripcion'];
                                        $tipo_inasistencia = $row_descripcion['tipo_inasistencia_id'];
                                        $descuento = $row_descripcion['con_descuento'];
                                    }
                                    $query_tipo_inasis = "SELECT *FROM tipo_inasistencia WHERE id = '$tipo_inasistencia'";
                                    $result_tipo_inasis = mysqli_query($conexion, $query_tipo_inasis);
                                    while ($row_tipo_inasis = mysqli_fetch_array($result_tipo_inasis)) {
                                        $tipo_inasis = $row_tipo_inasis['nombre'];
                                    }
                                ?>
                                    <tbody>
                                        <tr>
                                            <th scope="row"><?php echo $row_expediente['codigo_id'] ?></th>
                                            <td><?php echo $tipo_inasis ?></td>
                                            <td><?php echo $desc ?></td>
                                            <td><?php echo $row_expediente['fecha_inicio'] ?></td>
                                            <td><?php echo $row_expediente['fecha_fin'] ?></td>
                                            <td><?php if ($descuento == 1) {
                                                    echo "Con descuento";
                                                } else {
                                                    echo "Sin descuento";
                                                } ?></td>
                                            <td>
                                                <a class="btn btn-sm btn-primary" href=<?= "modificar-expediente.php?id={$row_expediente['expediente_id']}" ?>>
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form class="d-inline-block" action="eliminar-expediente.php" method="POST">
                                                    <button class="btn btn-sm btn-danger" type="submit" name="id" value="<?= $row_expediente['expediente_id'] ?>" onclick="return confirm('Seguro que desea eliminar el expediente de ID <?= $row_expediente['expediente_id'] ?>?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                            </table>
                        <?php  } ?>
                        </tr>
                    </tbody>
                <?php } ?>
                </table>
                <?php } else {
                $query_planilla =   "SELECT  planilla_productividad_no_docente.id,planilla_productividad_no_docente.anio, m1.nombre FROM planilla_productividad_no_docente,
                                (SELECT * FROM `mes` WHERE nombre= '$mes') as m1
                                 WHERE m1.id= planilla_productividad_no_docente.mes_id and anio='$anio'";
                $result_planilla = mysqli_query($conexion, $query_planilla);
                while ($row_planilla = mysqli_fetch_array($result_planilla)) {
                    if ($row_planilla > 0) {
                        $planilla_id = $row_planilla['id'];
                ?>
                        <table class="table table-striped table-dark">
                            <thead>
                                <tr>
                                    <th scope="col">UNIVERSIDAD AUTÓNOMA DE ENTRE RÍOS</th>
                                    <th scope="col">Facultad: Ciencia y Tecnología</th>
                                    <th scope="col">Sede: Chajarí</th>
                                    <th scope="col">Planilla: <?php echo $tipo_agente ?></th>
                                    <th scope="col">Mes: <?php echo $row_planilla['nombre'] ?></th>
                                    <th scope="col">Año: <?php echo $row_planilla['anio'] ?></th>
                                </tr>
                            </thead>
                        </table>
                        <?php
                        $query_no_docente = "SELECT persona.dni, persona.nombre, m2.id, m2.antiguedad FROM persona,
                                        (SELECT persona_id, id, antiguedad FROM no_docente,
                                        (SELECT DISTINCT no_docente_id FROM expediente_no_docente,
                                        (SELECT * FROM `expediente_planilla_no_docente` WHERE planilla_productividad_no_docente_id = '$planilla_id') 
                                        as m1 where m1.expediente_no_docente_id = expediente_no_docente.id) 
                                        as m1 where m1.no_docente_id = no_docente.id) 
                                        as m2 where m2.persona_id = persona.id;";

                        $result_no_docente = mysqli_query($conexion, $query_no_docente);
                        while ($row_no_docente = mysqli_fetch_array($result_no_docente)) {
                            $no_docente_id = $row_no_docente['id']

                        ?>
                            <table class="table table-striped table-dark">
                                <thead class="col-md-12">
                                    <tr>
                                        <th scope="col">DNI</th>
                                        <th scope="col">Agente</th>
                                        <th scope="col">Horas descontadas</th>
                                        <th scope="col">Total horas/antiguedad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_hs = '0';
                                    $hs = '0';
                                    $query_hs = "SELECT *FROM expediente_planilla_no_docente,
                            (SELECT id FROM expediente_no_docente WHERE no_docente_id ='$no_docente_id') 
                            as m1 WHERE  m1.id = expediente_no_docente_id";
                                    $result_hs = mysqli_query($conexion, $query_hs);
                                    while ($row_hs = mysqli_fetch_array($result_hs)) {
                                        $hs = $row_hs['hs_descontadas'];
                                        $total_hs = $total_hs + $hs;
                                    }
                                    ?>
                                    <tr>
                                        <td scope="row"><?php echo  $row_no_docente['dni'] ?></td>
                                        <td><?php echo $row_no_docente['nombre'] ?></td>
                                        <td><?php echo $total_hs ?></td>
                                        <td><?php echo $row_no_docente['antiguedad'] ?></td>
                                    </tr>
                                    <tr>
                                        <table class="table table-striped ml-4">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Codigo</th>
                                                    <th scope="col">Tipo</th>
                                                    <th scope="col">Descripcion</th>
                                                    <th scope="col">Desde</th>
                                                    <th scope="col">Hasta</th>
                                                    <th scope="col">Descuento</th>
                                                    <th scope="col">Acciones</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $query_expediente =  "SELECT * FROM expediente, 
                                            (SELECT * FROM `expediente_no_docente` WHERE no_docente_id ='$no_docente_id') as m1
                                            WHERE m1.expediente_id = expediente.id";
                                            $result_expediente = mysqli_query($conexion, $query_expediente);
                                            while ($row_expediente = mysqli_fetch_array($result_expediente)) {
                                                $descripcion = $row_expediente['codigo_id'];
                                                $query_descripcion = "SELECT *FROM codigo WHERE id = '$descripcion'";
                                                $result_descripcion = mysqli_query($conexion, $query_descripcion);
                                                while ($row_descripcion = mysqli_fetch_array($result_descripcion)) {
                                                    $desc = $row_descripcion['descripcion'];
                                                    $tipo_inasistencia = $row_descripcion['tipo_inasistencia_id'];
                                                    $descuento = $row_descripcion['con_descuento'];
                                                }

                                                $query_tipo_inasis = "SELECT *FROM tipo_inasistencia WHERE id = '$tipo_inasistencia'";
                                                $result_tipo_inasis = mysqli_query($conexion, $query_tipo_inasis);
                                                while ($row_tipo_inasis = mysqli_fetch_array($result_tipo_inasis)) {
                                                    $tipo_inasis = $row_tipo_inasis['nombre'];
                                                }
                                            ?>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row"><?php echo $row_expediente['codigo_id'] ?></th>
                                                        <td><?php echo $tipo_inasis ?></td>
                                                        <td><?php echo $desc ?></td>
                                                        <td><?php echo $row_expediente['fecha_inicio'] ?></td>
                                                        <td><?php echo $row_expediente['fecha_fin'] ?></td>
                                                        <td><?php if ($descuento == 1) {
                                                                echo "Con descuento";
                                                            } else {
                                                                echo "Sin descuento";
                                                            } ?></td>
                                                        <td>
                                                            <a class="btn btn-sm btn-primary" href=<?= "modificar-expediente.php?id={$row_expediente['expediente_id']}" ?>>
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <form class="d-inline-block" action="eliminar-expediente.php" method="POST">
                                                                <button class="btn btn-sm btn-danger" type="submit" name="id" value="<?= $row_expediente['expediente_id'] ?>" onclick="return confirm('Seguro que desea eliminar el expediente de ID <?= $row_expediente['expediente_id'] ?>?')">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            <?php } ?>
                                        </table>
                                    </tr>
                                </tbody>
                            </table>
            <?php }
                    }
                }
            }
            ?>
</div>

<?php include("../includes/footer.php") ?>