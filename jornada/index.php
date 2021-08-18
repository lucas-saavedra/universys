<?php 
include("navbar.php");

?>

<div class="jumbotron jumbotron-fluid">
    <div class="container-fluid">
        <h1 class="h-3">¡Bienvenid@! <?php echo $agente ?> </h1>
        <?php if ($es_personal) { ?>
        <p class="lead">Seleccione el tipo de agente con el que desea trabajar.</p>
        <?php } ?>
        <hr class="my-4">
        <div class="row d-flex justify-content-center">
            <div class="card-deck">
                <div class="card text-center">
                    <div class="card-body" style="width: 14rem; display: flex; align-items:center; justify-content:center">
                        <div>
                            <h5 class="card-title">Asistencia</h5>
                            <button class="btn btn-primary btn-block" type="submit">Docente</button>
                            <button class="btn btn-primary btn-block" type="submit">No Docente</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

<?php include("../includes/footer.php") ?>