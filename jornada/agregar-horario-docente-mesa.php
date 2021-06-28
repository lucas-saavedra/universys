<?php include("header.php"); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h2 class="display-6">Ingrese el nuevo horario de mesa de examen</h1>
                <form action="" method="POST">
                    <label for="search_docente"> Ingrese el docente </label>
                    <div class="form-row">
                        <div class="form-group col-md-11">
                            <input class="form-control " type="search" placeholder="Ingrese el nombre del docente" aria-label="Search">
                        </div>
                        <div class="form-group col-md-1">
                            <button class="btn btn-outline-success " type="submit">Buscar</button>
                        </div>
                    </div>
                    <div class="form-row">
                      
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
                        <div class="form-group col-md-5 ">
                            <label for="">Fecha</label>
                            <input type="date" class="form-control" id="hora_inicio">

                        </div>
                        <div class="form-group col-md-3">
                            <label for="hora_inicio">Inicio</label>
                            <input value="16:00" type="time" class="form-control" id="hora_inicio">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="hora_fin">Fin</label>
                            <input value="21:00" type="time" class="form-control" id="hora_fin">
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