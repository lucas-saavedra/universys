<?php include("navbar.php");

if (!isset($_SESSION['admin']) || $_SESSION['admin'] <> 'true' ) {
    header("Location: ../index.php ");
}

?>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Rol</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $roles = get_roles($conexion);
                            while ($row = mysqli_fetch_array($roles)) {    ?>
                                <tr>
                                    <td><?php echo $row['persona'] ?></td>
                                    <td><?php echo $row['rol'] ?></td>
                                </tr>
                            <?php }  ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<?php include("footer.php") ?>