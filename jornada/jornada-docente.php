<?php include("header.php"); ?>
<?php include("includes/db.php"); ?>
<?php include("includes/consultas.php"); ?>


<div class="container">
    <div class="row">
        <div class="col">
            <h1>JORNADA DOCENTE</h1>
            <div id='notif'>
            </div>
            <form action="" id="jornadaDocente" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="">Seleccione al docente</label>
                        <select class="form-control" id="docenteId" required>
                        <option  selected value="" disabled >Seleccione el docente</option>
                            <?php foreach (get_docentes($conexion) as $docentes) : ?>
                                <option value="<?= $docentes['id'] ?>">
                                    <?= "{$docentes['nombre']}" ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                </div>
                <div class="form-row d-flex flex-nowrap">
                    <div class="form-group col-md-11 col-lg-11 ">
                        <input class="form-control"  type="text" value="" required id="catedra" placeholder="Click aquí para seleccionar la catedra" aria-label="">
                    </div>
                    <input type="hidden"  id="catedraIdInput">
                    <input type="hidden" id="jornadaDocenteId">
                    <input type="hidden" id="jornadaId">
                    <div class="form-group">
                        <a type="button" class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-plus"></i></a>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="fecha_inicio">Fecha de incio de la jornada</label>
                        <input required type="date" class="form-control" id="fechaFin">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fecha_fin">Fecha de fin de la jornada</label>
                        <input required type="date" class="form-control" id="fechaInicio">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="">Tipo de jornada</label>
                        <select required class="form-control" id="tipoJornadaId">
                            <option  selected value="" disabled >Seleccione la jornada</option>
                            <?php foreach (get_tipo_jornadas_docentes($conexion) as $tipo_jornada) : ?>
                                <option value="<?= $tipo_jornada['id'] ?>">
                                    <?= "{$tipo_jornada['nombre']}" ?>
                                </option>
                            <?php endforeach; ?>     
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Descripcion de la jornada</label>
                    <div class="form-floating">
                        <textarea id='descripcion' required name="detalle" class="form-control" placeholder="Ingrese aqui la descripcion" style="height: 100px"></textarea>
                    </div>
                </div>
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
                            <th scope="col">Docente</th>
                            <th scope="col">Catedra</th>
                            <th scope="col">Fecha de inicio</th>
                            <th scope="col">Fecha de fin</th>
                            <th scope="col">Tipo de jornada</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col justify-content-between">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="lista_jorn_docente">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="container">
                <div class="row py-5">
                    <div class="col">
                        <div class="form-group">
                            <input class="form-control" autofocus type="search" id="search" placeholder="Ingrese la catedra" aria-label="Search">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Catedra</th>
                                            <th scope="col">Carrera</th>
                                            <th scope="col">Periodo</th>
                                            <th scope="col">Año</th>
                                            <th scope="col justify-content-between">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="container">

                                        <!-- AJAX AQUI CATEDRAs -->

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



<?php include("footer.html") ?>