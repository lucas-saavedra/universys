<?php 
include("navbar.php");

 if (!isset($_SESSION['agente'])){
    header("Location: ../index.php ");
  } 
?>


<div class="jumbotron jumbotron-fluid">
    <div class="container-fluid">

        <h1 class="display-4">¡Bienvenid@! <?php echo $agente ?> </h1>
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

                <?php if ($es_personal) { ?>
                    <div class="card text-center" style="width: 14rem;">
                        <div class="card-body">
                            <h5 class="card-title">Docente</h5>
                            <button class="btn" type="submit"> <a href="agente.php?tipo_agente=<?php echo 'docente' ?>"><i class="fas fa-chalkboard-teacher fa-6x"></i></i></a></button>
                        </div>
                    </div>


                    <div class="card text-center" style="width: 14rem;">
                        <div class="card-body">
                            <h5 class="card-title">No Nocente</h5>
                            <button class="btn" type="submit"> <a href="agente.php?tipo_agente=<?php echo 'no_docente' ?>"><i class="fas fa-user fa-6x"></i></i></a></button>
                        </div>
                    </div>


                    <div class="card text-center" style="width: 14rem;">
                        <div class="card-body">
                            <h5 class="card-title">Crear expediente</h5>
                            <button type="button" class="btn"><a class="btn" href="../expediente/crear-expediente.php"><i class="fas fa-file-alt fa-6x"></i></a></button>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($es_mesa) { ?>
                    <div class="card text-center" style="width: 14rem;">
                        <div class="card-body">
                            <h5 class="card-title">Documentacion</h5>
                            <button type="button" class="btn"><a class="btn" href="../expediente/crear-expediente.php"><i class="fas fa-file-alt fa-6x"></i></a></button>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>


    </div>
</div>

<?php include("../includes/footer.php") ?>