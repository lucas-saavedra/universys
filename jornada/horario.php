<?php /* include_once("header.php"); */ ?>
<div class="container">
    <div class="row">
        <div class="col">
            
            <form action="" id="horario" method="POST">


                <div class="form-row collapse show multi-collapse" id="">
                    <div class="form-group col-md-6 ">
                        <input class="form-control" readonly aria-describedby="inputGroupPrepend" type="text" id="agente_horarios" placeholder="Click en buscar para seleccionar el agente" aria-label="">
                    </div>
                    <div class="form-group col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span data-toggle="collapse" role="button" type="submit" href="#agente_tabla_horarios" class="btn btn-outline-success input-group-text" id="inputGroupPrepend"><i class="fas fa-search"></i></span>
                            </div>
                            <input class="form-control  input-group-text" aria-describedby="inputGroupPrepend" autofocus type="search" id="search-agente-horario" placeholder="Ingrese el nombre del agente" aria-label="Search">
                        </div>
                    </div>

                    <div class="collapse show multi-collapse col-md-12" id="agente_tabla_horarios">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tbody id="container-agente-horarios">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php include_once("includes/i_agregar_horario.php");  ?>

                <div class="form-group col-md-12 d-flex justify-content-around">
                    <button type="submit" class="btn btn-primary">Aceptar</button>
                    <button type="reset" class="btn btn-secondary">Cancelar</button>
                </div>
            </form>
        </div>

    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col">
            <?php /* include_once("includes/listar_jornadas.php"); */ ?>
        </div>
    </div>
</div>

<?php /* include_once("footer.html") */ ?>