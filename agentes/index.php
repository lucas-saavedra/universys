<title>Agentes</title>
<?php 
include ("../jornada/navbar.php");
include ("./includes/consultas.php");

?>


<div class="container-fluid">
    <div class="row jumbotron p-1 mb-2">
        <div class="col-lg-7 mx-auto d-flex justify-content-center align-items-center" style="gap:3rem;">
            <h2 class="text-center my-3">
                Agentes
            </h2>
            <a class="btn btn-success" href="crear.php">
                <i class="fa fa-plus"></i> Nuevo agente
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>CUIL</th>
                        <th>Tipos</th>
                        <th>-</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach(_get_agente($conexion, null) as $agente): ?>
                        <tr>
                            <td><?=$agente['nombre']?></td>
                            <td><?=$agente['email']?></td>
                            <td><?=$agente['cuil']?></td>
                            <td>
                                <?php if (isset($agente['id_docente'])): ?>
                                    <span class="badge badge-primary">Docente</span>
                                <?php endif; ?>
                                <?php if (isset($agente['id_no_docente'])): ?>
                                    <span class="badge badge-info">No Docente</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a class="btn btn-info" href=<?="modificar.php?id={$agente['id']}"?>>
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>

            </table>
        </div>
    </div>

</div>


<?php include("../includes/footer.php"); ?>