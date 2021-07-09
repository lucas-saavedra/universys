<input type="hidden" id="tipo_agente" tipo_agente="<?PHP echo $tipo_agente ?>">
<input type="hidden" id="jornadaId">
<input type="hidden" id="id_agente">
<input type="hidden" id="jornada_agente_id">


<div class="form-row">
<div class="form-group col-md-6">
        <input class="form-control" readonly aria-describedby="inputGroupPrepend" type="text" id="agente" placeholder="Click en buscar para seleccionar el agente" aria-label="">
    </div>
    <div class="form-group col-md-6">
        <div class="input-group">
            <div class="input-group-prepend">
                <span data-toggle="collapse" role="button" type="submit" href="#agente_tabla" class="btn btn-outline-success input-group-text" id="inputGroupPrepend"><i class="fas fa-search"></i></span>
            </div>
            <input class="form-control  input-group-text" aria-describedby="inputGroupPrepend" autofocus type="search" id="search-agente" placeholder="Ingrese el nombre del agente" aria-label="Search">
        </div>
    </div>
    


    <div class="collapse show col-md-12" id="agente_tabla">
        <div class="table-responsive">
            <table class="table">
                <!--  <thead class="thead-light">
                    <tr>
                        <th scope="col">Nombre</th>

                        <th scope="col " class="d-flex justify-content-end">Acciones</th>
                    </tr>
                </thead> -->
                <tbody id="container-agente">

                    <!-- AJAX AQUI CATEDRAs -->

                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- <div class="form-row">
    <div class="form-group col-md-12">
        <label for="fecha_inicio">Seleccione el agente</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="btn btn-outline-success input-group-text" id="inputGroupPrepend" data-toggle="collapse" role="button" type="submit" href="#agente_tabla" aria-expanded="false" aria-controls="collapseExample">Buscar</span>
            </div>
        </div>
    </div>
</div> -->
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="fecha_inicio">Fecha de incio de la jornada</label>
        <input required type="date" class="form-control" id="fechaInicio">
    </div>
    <div class="form-group col-md-6">
        <label for="fecha_fin">Fecha de fin de la jornada</label>
        <input required type="date" class="form-control" id="fechaFin">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-12">
        <label for="">Tipo de jornada</label>
        <select class="form-control" id="tipoJornadaId" required>
            <option selected value="" disabled>Escoja un tipo de jornada</option>
            <?php foreach (get_tipo_jornadas($conexion, $tipo_agente) as $tipo_jornadas) : ?>
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