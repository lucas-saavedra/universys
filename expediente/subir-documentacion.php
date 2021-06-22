<?php include ("../header.html");?>

<div class="container">
    <div class="row">
        <div class="col g-4">
            <h3>Subir documentación</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 g-4">
            <form action="">
                <div class="mb-3 row">
                    <label for="" class="col-sm-2 col-form-label">Fecha de recepción</label>
                    <div class="col-sm-10">
                        <input type="datetime-local" class="form-control" required />
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="col-sm-2 form-label">Agente</label>
                    <div class="col-sm-10">
                        <select class="form-select form-select-sm" required>
                            <option selected></option>
                            <option value="1">Francisca Abreu </option>
                            <option value="2">Jone Sancho</option>
                            <option value="3">Fidel López</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="" class="col-sm-2 form-label">Archivo</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="file" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="" class="col-sm-2 form-label">Tipo de documentación</label>
                    <div class="col-sm-10">
                        <select class="form-select" required>
                            <option selected></option>
                            <option value="1">LIS </option>
                            <option value="2">LIS + Certificado</option>
                            <option value="3">Justificacion</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="col-sm-2 form-label">Descripción</label>
                    <div class="col-sm-10">
                        <textarea class="form-control"></textarea>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include("../footer.html"); ?>