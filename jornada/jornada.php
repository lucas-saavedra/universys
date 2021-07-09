<?php include("header.php"); ?>
<?php include("includes/db.php"); ?>
<?php include("includes/consultas.php"); ?>
<?php $tipo_agente  = 'docente';?>
<div class="container">
    <div class="row">
        <div class="col">
          
            <h1>JORNADA <?PHP echo $tipo_agente ?> </h1>
            <div id='notif'>
            </div>
            <form action="" id="jornada" method="POST">

            
                <?php include("includes/jornada.php"); ?>
                <?php if ($tipo_agente == 'docente') {
                    include("includes/elegir_catedra.php");
                } else {
                    include("includes/elegir_area.php");
                }
                ?>

                <div class="form-group col-md-12 d-flex justify-content-around">
                    <button type="submit" class="btn btn-primary">Aceptar</button>
                    <button type="reset" class="btn btn-secondary">Cancelar</button>
                </div>

            </form>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h3>Jornadas agregadas</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>

                            <th scope="col">Nº</th>
                            <?php if ($tipo_agente == 'docente') { ?>
                                <th scope="col">Docente</th>
                                <th scope="col">Catedra</th>
                            <?php } else { ?>
                                <th scope="col">Agente</th>
                                <th scope="col">Area</th>

                            <?php }  ?>

                            <th scope="col">Fecha de inicio</th>
                            <th scope="col">Fecha de fin</th>
                            <th scope="col">Tipo de jornada</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col justify-content-between">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="listar_jornadas">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>





<?php include("footer.html") ?>