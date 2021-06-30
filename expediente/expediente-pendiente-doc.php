<?php include ("../includes/header.php");?>

<div class="container-fluid">

    <div class="row">
        <div class="col-md-10 m-auto">
            <form action="" method="post">
                <div class="form-group">
                    <label for="precio">expediente pendiente de documentación</label>
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Traer documentacion</button>
                </div>
            </form>  
        </div>
    </div>

    <table class="table table-striped table-dark">
    <thead>
        <tr>
        <th scope="col">Agente</th>
        <th scope="col">Tipo de documentacion</th>
        <th scope="col">Fecha de entrega</th>
        <th scope="col">Archivo</th>
        <th scope="col">¿Entrego en termino?</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <td scope="row">Alejandro</td>
        <td>lis + certificado</td>
        <td>12/12/12</td>
        <td style="color:blue">lis y certificado de alejandro rellan</td>
        <td>Si</td>
 </table>
</div>
<?php include("../includes/footer.php"); ?>