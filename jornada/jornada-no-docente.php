<?php include("header.php"); ?>
<?php include("includes/db.php"); ?>
<?php include("includes/consultas.php"); ?>


<div class="container">
    <div class="row">
        <div class="col">
            <h1>JORNADA NO DOCENTE</h1>
            <div id='notif'>
            </div>
            <form action="" id="jornadaNoDocente" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="">Seleccione al agente</label>

                        <select class="form-control" id="noDocenteId" required>
                        <option  selected value="" disabled >Seleccione el agente</option>
                            <?php foreach (get_agentes($conexion) as $agentes) : ?>
                                <option value="<?= $agentes['id'] ?>">
                                    <?= "{$agentes['nombre']}" ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="">Area</label>
                        <select class="form-control" id="areaId" required>
                        <option  selected value="" disabled >Escoja un area</option>
                            <?php foreach (get_areas($conexion) as $areas) : ?>
                                <option value="<?= $areas['id'] ?>">
                                    <?= "{$areas['nombre']}" ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                    <input type="hidden" id="jornadaNoDocenteId">
                    <input type="hidden" id="jornadaId">
              
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
                        <select class="form-control" id="tipoJornadaId" required>
                        <option  selected value="" disabled >Escoja un tipo de jornada</option>
                            <?php foreach (get_tipo_jornadas($conexion) as $tipo_jornadas) : ?>
                                <option value="<?= $tipo_jornadas['id'] ?>">
                                    <?= "{$tipo_jornadas['nombre']}" ?>
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
                            <th scope="col">Agente</th>
                            <th scope="col">Area</th>
                            <th scope="col">Fecha de inicio</th>
                            <th scope="col">Fecha de fin</th>
                            <th scope="col">Tipo de jornada</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col justify-content-between">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="lista_jorn_no_docente">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




<?php include("footer.html") ?>