<?php include("header.php"); ?>
<?php include("backend/db.php"); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-6">
            <h1>UNIVERSYS</h1>
            <?php if (isset($_SESSION['message'])) { ?>
                <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['message'] ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php session_unset();
            } ?>
            <form action="/universys/jornada/backend/mostrar-jornada.php" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="fecha_inicio">Fecha de incio de la jornada</label>
                        <input type="date" class="form-control" name="inicio">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fecha_fin">Fecha de fin de la jornada</label>
                        <input type="date" class="form-control" name="fin">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Tipo de jornada</label>
                    <select class="form-control" name="tipo">
                        <option value="1">1er Cuatrimestre</option>
                        <option value="2">2do Cuatrimestre</option>
                        <option value="A">Anual</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Descripcion de la jornada</label>
                    <div class="form-floating">
                        <textarea name="detalle" class="form-control" placeholder="Ingrese aqui la descripcion" style="height: 100px"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Aceptar</button>
                    <button type="reset" class="btn btn-secondary">Cancelar</button>
                </div>

            </form>
        </div>
        <div class="col-md-12 col-lg-6">
            <h3>Jornadas agregadas</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Nº</th>
                            <th scope="col">Fecha de inicio</th>
                            <th scope="col">Fecha de fin</th>
                            <th scope="col">Tipo de jornada</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                <?php $query="Select * from jornada";
                $jornadas=mysqli_query($conexion,$query);

                while ($row= mysqli_fetch_array($jornadas)){ ?>

                    <tr>
                    <th > <?php echo $row['id'] ?></th>
                    <td > <?php echo $row['fecha_inicio'] ?></td>
                    <td > <?php echo $row['fecha_fin'] ?></td>
                    <td > <?php echo $row['tipo_jornada_id'] ?></td>
                    <td > <?php echo $row['descripcion'] ?></td>
                    <td > 
                        <a href=""><i class="fas fa-marker"></i></a>
                        <a href=""><i class="fas fa-trash"></i></a>
                       
                    </tr>

                <?php } ?>

                       
    
                    </tbody>
                </table>
            </div>


        </div>
    </div>
</div>


<?php include("footer.html") ?>