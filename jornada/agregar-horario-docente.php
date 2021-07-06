<?php include("header.php"); ?>
<?php include("../jornada/includes/db.php"); ?>
<div class="container">
    <div class="row">
        <div class="col">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">Universys</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

            </nav>
            <h2 class="display-6">Ingrese el nuevo horario</h1>
                <form action="" method="POST">
                    <label for="search_docente"> Ingrese el docente </label>
                    <div class="form-row">
                        <div class="form-group col-md-11">
                            <input class="form-control " type="search" placeholder="Ingrese el nombre del docente" aria-label="Search">
                        </div>
                        <div class="form-group col-md-1">
                            <a class="btn btn-outline-success " data-toggle="collapse" role="button" type="submit" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Buscar</a>
                        </div>

                        <div class="collapse col-md-12" id="collapseExample">

                            <div class="form-group">
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
                            <label for="">Catedra</label>
                            <select class="form-control" id="">
                                <option>BD</option>
                                <option>Informatica</option>
                                <option>Etc</option>
                            </select>
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3 ">
                            <label for="">Día</label>
                            <select class="form-control" id="">
                                <option>Lunes</option>
                                <option>Martes</option>
                                <option>Miercoles</option>
                                <option>Jueves</option>
                                <option>Viernes</option>
                                <option>Sabado</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="hora_inicio">Inicio</label>
                            <input type="time" class="form-control" id="hora_inicio">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="hora_fin">Fin</label>
                            <input type="time" class="form-control" id="hora_fin">
                        </div>
                        <div class="form-group col-md-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Agregar</button>

                        </div>
                    </div>
                </form>

                <h2 class="display-6">Horarios Agregados</h2>
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Nº</th>
                            <th scope="col">Catedra</th>
                            <th scope="col">Dia</th>
                            <th scope="col">Hora Inicio</th>
                            <th scope="col">Hora Fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Informatica</td>
                            <td>Lunes</td>
                            <td>14:00</td>
                            <td>16:00</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Base de datos</td>
                            <td>Martes</td>
                            <td>14:00</td>
                            <td>16:00</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Programacion</td>
                            <td>Miercoles</td>
                            <td>14:00</td>
                            <td>16:00</td>
                        </tr>
                    </tbody>
                </table>





        </div>
    </div>
</div>


<?php include("footer.html") ?>