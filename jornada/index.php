<?php include("header.php");

?>

<div class="jumbotron jumbotron-fluid">
    <div class="container-fluid">
        <h1 class="display-4">¡Bienvenido! AGENTE_NOMBRE</h1>
        <p class="lead">Seleccione el tipo de agente con el que desea trabajar.</p>
        <hr class="my-4">
        <div class="row d-flex justify-content-center">
            <div class="card-deck">
                <div class="col-md-6">
                    <div class="card text-center" style="width: 15rem;">
                        <div class="card-body">
                            <h5 class="card-title">Docente</h5>
                            <button class="btn" type="submit"> <a href="agente.php?tipo_agente=<?php echo 'docente' ?>"><i class="fas fa-chalkboard-teacher fa-7x"></i></i></a></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card text-center" style="width: 15rem;">
                        <div class="card-body">
                            <h5 class="card-title">No Nocente</h5>
                            <button class="btn" type="submit"> <a href="agente.php?tipo_agente=<?php echo 'no_docente' ?>"><i class="fas fa-user fa-7x"></i></i></a></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>

<?php include("footer.html") ?>