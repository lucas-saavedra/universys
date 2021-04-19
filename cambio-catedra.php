<?php
include ('dataBase.php');

$catedra = $_POST['id'];
$dia = $_POST['id_dia'];
$hora = $_POST['id_hora'];



$query = "UPDATE tablas SET  id_catedra = '$catedra' WHERE id_dia = '$dia' and id_hora = '$hora'";
$result = mysqli_query($conn,$query);

echo 'el cambio esta echo';


?>