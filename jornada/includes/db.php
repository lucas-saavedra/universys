<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
$conexion = mysqli_connect(
    "localhost",
    "root",
    "",
    "universys"
)or die(mysqli_error($mysqli));
