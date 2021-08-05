<input type="hidden" id="catedraIdInput">
<div class="form-row">
    <div class="form-group col-md-12">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="btn btn-outline-success input-group-text" id="inputGroupPrepend" data-toggle="collapse" role="button" type="submit" href="#catedraCollapse" aria-expanded="false" aria-controls="collapseExample">Buscar</span>
            </div>
           
                <input class="form-control"  autocomplete="off" autofocus type="search" id="search" placeholder="Ingrese la catedra" aria-label="Search">
            
            <!--             <input class="form-control" readonly aria-describedby="inputGroupPrepend" type="text" id="catedra" placeholder="Click en buscar para seleccionar la catedra" aria-label="">
 -->
        </div>
    </div>
</div>

<div class="form-row">
    <div class="collapse col-md-12" id="catedraCollapse">
        <div class="table-responsive">
            <table class="table table-sm">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Catedra</th>
                        <th scope="col">Carrera</th>
                        <th scope="col">Periodo</th>
                        <th scope="col">Año</th>
                        <th scope="col " class="d-flex justify-content-end">Acciones</th>
                    </tr>
                </thead>
                <tbody id="container_catedra">

                    <!-- AJAX AQUI CATEDRAs -->

                </tbody>
            </table>
        </div>

    </div>
</div>