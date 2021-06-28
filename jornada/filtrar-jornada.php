<?php include("header.php"); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <h4 class="display-6">Ingrese la nueva jornada</h4>
            <form action="" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="fecha_inicio">Año de la jornada docente</label>
                        <input type="date" class="form-control" id="fecha_inicio">
                    </div>
                     <div class="form-group col-md-6"">
                    <label for="">Tipo de jornada</label>
                    <select class="form-control" id="">
                        <option>1er Cuatrimestre</option>
                        <option>2do Cuatrimestre</option>
                        <option>Anual</option>
                    </select>
                </div>
                </div>
            
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    <button type="reset" class="btn btn-secondary">Cancelar</button>
                </div>

            </form>
            <h3>Jornadas agregadas</h3>
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Nº</th>
                        <th scope="col">Tipo de jornada</th>
                        <th scope="col">Fecha de inicio</th>
                        <th scope="col">Fecha de fin</th>
                        <th scope="col">Descripcion</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>1er Cuatrimestre</td>
                        <td>01/02/2021</td>
                        <td>01/06/2021</td>
                        <td>Lorem ipsum dolor sit i quiat porro illum quos! Nam </td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td> 2do Cuatrimestre</td>
                        <td>01/02/2021</td>
                        <td>01/06/2021</td>
                        <td>Lorem ipsum dolor sit i quiat porro illum quos! Nam </td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td> Anual</td>
                        <td>01/02/2021</td>
                        <td>01/06/2021</td>
                        <td>Lorem ipsum dolor sit i quiat porro illum quos! Nam </td>
                    </tr>
                </tbody>
            </table>


        </div>
    </div>

    <?php include("footer.html") ?>