<?php include ("../includes/header.php");?>

<div class="container-fluid">

    <div class="row">
        <div class="col-8 m-auto">
            <form action="" method="post">
                <div class="form-group">
                    <h2 class="col-md-8">Planilla de productividad</h2>
                    <div class="row">
                        <input class="form-control mr-sm-2 col-md-4" type="search" placeholder="ingrese fecha" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0 col-md-2" type="submit">Buscar.</button>
                    </div>
                </div>
            </form>  
        </div>
    </div>
    <table class="table table-striped table-dark">
        <thead>
            <tr>
                <th scope="col">UNIVERSIDAD AUTÓNOMA DE ENTRE RÍOS</th>
                <th scope="col">Facultad: Ciencia y Tecnología</th>
                <th scope="col">Sede: Chajarí</th>
                <th scope="col">Mes: Febrero</th>
                <th scope="col">Año: 2021</th>
            </tr>
        </thead>
    </table>
    <table class="table table-striped table-dark">
        <thead class="col-md-12">
            <tr>
                <th scope="col">DNI</th>
                <th scope="col">Agente</th>
                <th scope="col">Días</th>
                <th scope="col">Total horas</th>
            </tr>
        </thead>
        <tbody >
            <tr>
                <td scope="row">35226898</td>
                <td>Rellan alejandro</td>
                <td>20</td>
                <td>5</td>
            </tr>
            <tr>
                <table class="table table-striped ml-5">
                    <thead>
                        <tr>
                            <th scope="col">Codigo</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Desde</th>
                            <th scope="col">Hasta</th>
                            <th scope="col">Descuento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">2</th>
                            <td>Justificada</td>
                            <td>2/6/2021</td>
                            <td>4/6/2021</td>
                            <td><input type="checkbox"></input></td>
                        </tr>
                        <tr>
                            <th scope="row">7</th>
                            <td>Insistencia</td>
                            <td>15/6/2021</td>
                            <td>15/6/2021</td>
                            <td><input type="checkbox"></input></td>
                        </tr>
                        <tr>
                            <th scope="row">9</th>
                            <td>Licencia</td>
                            <td>20/6/2021</td>
                            <td>29/7/2021</td>
                            <td><input type="checkbox"></input></td>
                        </tr>
                    </tbody>
                </table>
            </tr>
            </tr>
        </tbody>
    </table>
    <table class="table table-striped table-dark">
        <thead class="col-md-12">
            <tr>
                <th scope="col">DNI</th>
                <th scope="col">Agente</th>
                <th scope="col">Días</th>
                <th scope="col">Total horas</th>
            </tr>
        </thead>
        <tbody >
            <tr>
                <td scope="row">35226898</td>
                <td>savedra lucas</td>
                <td>20</td>
                <td>5</td>
            </tr>
            <tr>
                <table class="table table-striped ml-5">
                    <thead>
                        <tr>
                            <th scope="col">Codigo</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Desde</th>
                            <th scope="col">Hasta</th>
                            <th scope="col">Descuento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">2</th>
                            <td>Justificada</td>
                            <td>2/6/2021</td>
                            <td>4/6/2021</td>
                            <td><input type="checkbox"></input></td>
                        </tr>
                        <tr>
                            <th scope="row">7</th>
                            <td>Insistencia</td>
                            <td>15/6/2021</td>
                            <td>15/6/2021</td>
                            <td><input type="checkbox"></input></td>
                        </tr>
                        <tr>
                            <th scope="row">9</th>
                            <td>Licencia</td>
                            <td>20/6/2021</td>
                            <td>29/7/2021</td>
                            <td><input type="checkbox"></input></td>
                        </tr>
                    </tbody>
                </table>
            </tr>
            </tr>
        </tbody>
    </table>
</div>




<?php include ("../includes/footer.php") ?>