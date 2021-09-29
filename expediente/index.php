<title>Planilla de productividad</title>
<?php
include("../jornada/navbar.php");
include("./includes/consultas.php");

$hoy = new DateTime('NOW');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $mes = $hoy->format('n');
    $anio = $hoy->format('Y');
    $tipo_agente = "docente";
} else {
    $mes = $_POST['mes'];
    $anio = $_POST['anio'];
    $tipo_agente = $_POST['select'];
}

if (isset($_SESSION['elim_expdte_msg'])) {
    $msg = $_SESSION['elim_expdte_msg'];
    unset($_SESSION['elim_expdte_msg']);
} elseif (isset($_SESSION['crear_expdte_msg'])) {
    $msg = $_SESSION['crear_expdte_msg'];
    unset($_SESSION['crear_expdte_msg']);
}

$planilla = get_p_prod($conexion, $anio, $mes, $tipo_agente);

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
                            <option value="docente" <?= $tipo_agente == 'docente' ? 'selected' : '' ?>>Docente</option>
                            <option value="no_docente" <?= $tipo_agente == 'no_docente' ? 'selected' : '' ?>>No docente</option>
                        </select>
                        <select name="mes" class="form-control mr-sm-2 col-3" required>
                            <option value="" selected disabled>Seleccione un mes</option>
                            <?php foreach (get_meses($conexion) as $_mes) : ?>
                                <option value="<?= $_mes['id'] ?>" <?= $_mes['id'] == $mes ? 'selected' : '' ?>>
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

    <?php include "includes/msg-box.php"; ?>

    <?php if (isset($planilla['id'])): ?>
        <?php $expdtes = get_expdtes_por_agente($conexion, $planilla['id'], $tipo_agente); ?>
        <table class="table table-dark table-sm my-3">
            <thead>
                <tr>
                    <th scope="col">UNIVERSIDAD AUTÓNOMA DE ENTRE RÍOS</th>
                    <th scope="col">Facultad: Ciencia y Tecnología</th>
                    <th scope="col">Sede: Chajarí</th>
                    <th scope="col">Planilla: <?= $tipo_agente ?></th>
                    <th scope="col">Mes: <?= $planilla['nombre'] ?></th>
                    <th scope="col">Año: <?= $planilla['anio'] ?></th>
                </tr>
            </thead>
        </table>
    
        <?php foreach ($expdtes as $persona_id => $_expdtes): ?>
            <table class="table table-striped table-dark table-sm">
                <tbody>
                    <tr>
                        <td><?=$_expdtes[0]['agente_nombre']?></td>
                        <td><?="DNI: {$_expdtes[0]['agente_dni']}"?></td>
                        <td>
                            Hs descontadas: 
                            <?=array_reduce($_expdtes, function($carry, $item){ return $carry+$item['hs_descontadas'];}, 0)?>
                        </td>
                        <td><?="Total hs: {$_expdtes[0]['agente_antiguedad']}"?></td>
                    </tr>
                    <tr>
                        <table class="table table-striped ml-4 table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Descripcion</th>
                                    <th scope="col">Desde</th>
                                    <th scope="col">Hasta</th>
                                    <th scope="col" class="text-center">Descuento</th>
                                    <th scope="col">Total inasis.</th>
                                    <th scope="col">Hs a descontar</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
    
                            <tbody>
                                <?php foreach ($_expdtes as $_expdte): ?>
                                    <tr>
                                        <td><?=$_expdte['cod']?></td>
                                        <td><?=$_expdte['cod_tipo']?></td>
                                        <td><?=$_expdte['cod_desc']?></td>
                                        <td><?=date("d-m-Y", strtotime($_expdte['fecha_inicio']))?></td>
                                        <td><?=date("d-m-Y", strtotime($_expdte['fecha_fin']))?></td>
                                        <td class="align-middle text-center">
                                            <i class="fa fa-lg fa-<?=$_expdte['con_descuento']? 'check': 'times'?>"></i>
                                        </td>
                                        <td><?=get_inasis_expdte($conexion, $_expdte["expdte_{$tipo_agente}_id"], $tipo_agente)?></td>
                                        <td><?=$_expdte['hs_descontadas']?></td>
                                        <td>
                                            <a 
                                                class="btn btn-sm btn-primary" 
                                                href=<?= "modificar-expediente.php?id={$_expdte['id']}" ?>
                                            >
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form class="d-inline-block" action="eliminar-expediente.php" method="POST">
                                                <button 
                                                    class="btn btn-sm btn-danger" 
                                                    type="submit" 
                                                    name="id" 
                                                    value="<?= $_expdte['id'] ?>" 
                                                    onclick="return confirm('Eliminar el expediente de ID <?= $_expdte['id'] ?>?')"
                                                >
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </tr>
                </tbody>
            </table>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?php include("../includes/footer.php") ?>