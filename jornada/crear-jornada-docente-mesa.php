<?php include("header.html"); ?>
<div class="container">
    <div class="row">
        <div class="col">

            <h1>UNIVERSYS</h1>
            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h3 class="display-6">Ingrese la nueva jornada de mesa</h1>
                </div>
            </div>

            <form action="" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="fecha_inicio">Fecha de incio de la jornada</label>
                        <input type="date" class="form-control" id="fecha_inicio">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fecha_fin">Fecha de fin de la jornada</label>
                        <input type="date" class="form-control" id="fecha_fin">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="">Carrera</label>
                        <select class="form-control" id="">
                            <option>Analisis de Sistemas</option>
                            <option>Prod. Agropecuaria</option>
                            <option>Gestion Ambiental</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Mes</label>
                        <select class="form-control" id="">
                            <option>Enero</option>
                            <option>Febrero</option>
                            <option>Marzo</option>
                            <option>Abril</option>
                            <option>Mayo</option>
                            <option>Junio</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Llamado</label>
                        <select class="form-control" id="">
                            <option>1er llamado</option>
                            <option>2do Llamado</option>
                            <option>3er llamado</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Descripcion de la jornada</label>
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Ingrese aqui la descripcion" id=""></textarea>
                    </div>
                </div>
                <div class="form-group justify-content-between">
                    <button type="submit" class="btn btn-primary">Aceptar</button>
                    <button type="reset" class="btn btn-secondary">Cancelar</button>
                </div>

            </form>

        </div>
    </div>
</div>


<?php include("footer.html") ?>