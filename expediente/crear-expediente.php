<?php include ("../header.html");?>
<?php include ("./navbar.php");?>
<div class="container">
    <div class="row mt-4">
        <div class="col">
            <h3>Crear expediente</h3>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-8">
            <form action="">
                <div class="mb-3 row">
                    <label for="" class="col-sm-2 form-label">Agente</label>
                    <div class="col-sm-10">
                        <select class="form-control form-control-sm" required>
                            <option selected></option>
                            <?php foreach (['Francisca Abreu', 'Jone Sancho', 'Fidel López'] as $idx => $name):?>
                                <option value="<?=$idx?>">
                                    <?=$name?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <div class="col-md-6">
                        <label for="">Fecha de inicio</label>
                        <input type="date" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="">Fecha de fin</label>
                        <input type="date" class="form-control" required>
                    </div>
                </div>

                <div class="card mb-3">
                    <h6 class="card-header">Datos del aviso</h6>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label for="" class="col-sm-2 form-label">Fecha de recepción</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" class="form-control" required />
                            </div>
                        </div>


                        <div class="mb-3 row">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="check-aviso">
                                    <label class="form-check-label" for="check-aviso">
                                        Entregado en término
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="mb-3 row">
                            <label for="" class="col-sm-2 form-label">Descripción</label>
                            <div class="col-sm-10">
                                <textarea class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="" class="col-sm-2 form-label">Documentación</label>
                    <div class="col-sm-10">
                        <select class="form-control form-control-sm" required>
                            <option selected></option>
                            <option value="1">01/01/2021 2:00 LIS</option>
                            <option value="2">01/02/2021 3:00 Cert. Justificacion</option>
                            <option value="3">01/03/2021 4:00 Licencia por licencia</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="" class="col-sm-2 form-label">Código</label>
                    <div class="col-sm-7">
                        <select class="form-control" required>
                            <option selected></option>
                            <?php foreach (['Falta sin aviso', 'Falta injustificada', 'Imprevisto'] as $idx => $name):?>
                                <option value="<?=$idx?>">
                                    <?="$idx - $name"?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" checked id="check-cupo">
                            <label class="form-check-label" for="check-cupo">
                                Cupo superado
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 form-check-label">Estado del cupo</label>
                    <div class="col-sm-10">
                        <input class="form-control" stype="text">
                    </div>
                </div>


                <div class="mb-3 row">
                    <div class="col text-center">

                        <button type="submit" class="btn btn-primary btn-lg">Confirmar</button>
                    </div>
                </div>

        </div>

        </form>
    </div>
</div>
</div>

<?php include("../footer.html"); ?>