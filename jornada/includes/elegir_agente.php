
<div class="form-row collapse show multi-collapse" >
    <div class="form-group col-md-6 ">
        <input class="form-control" readonly aria-describedby="inputGroupPrepend" type="text" id="agente" placeholder="Click en buscar para seleccionar el agente" aria-label="">
    </div>
    <div class="form-group col-md-6">
        <div class="input-group">
            <div class="input-group-prepend">
                <span data-toggle="collapse" role="button" type="submit" href="#agente_tabla" class="btn btn-outline-success input-group-text" id="inputGroupPrepend"><i class="fas fa-search"></i></span>
            </div>
            <input autocomplete="off" class="form-control  input-group-text" aria-describedby="inputGroupPrepend" autofocus type="search" id="search-agente" placeholder="Ingrese el nombre del agente" aria-label="Search">
        </div>
    </div>

    <div class="collapse show multi-collapse col-md-12" id="agente_tabla" >
        <div class="table-responsive">
            <table class="table table-sm">
                <tbody id="container-agente">
                </tbody>
            </table>
        </div>
    </div>
</div>