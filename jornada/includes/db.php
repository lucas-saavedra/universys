<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
$conexion = mysqli_connect(
    "localhost",
    "root",
    "",
    "universys2"
)or die(mysqli_error($mysqli));
?>