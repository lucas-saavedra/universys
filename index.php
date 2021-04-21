<?php include "functions.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Universys</title>
    <style>
        h2 {
            color: white;
        }

        nav {
            width: 1100px;
        }
    </style>
    <style type="text/css">
        th {
            text-align: center;
        }

        h5 {
            color: white;

        }

        .texto {
            font-family: Verdana, Helvetica;
            font-weight: bold;
            text-align: center;

        }

        .contn {
            width: 400px;

        }

        td {}

        .botun {
            background: red;
            border: 0px;
            border-color: white;
            width: 42px;
            height: 42px;
        }

        .boton {
            background: black;
            border: 0px;
            border-color: white;
            color: white;
            width: 42px;
            height: 42px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div id="sidebar-container" class="bg-primary">
            <div class="logo">
                <h4 class="text-light p-3">UNIVERSYS</h4>
                <?php
                        session_start();
                        $usuario = $_SESSION['username'];
                        echo "<h5 class='ml-3'> $usuario </h5>";
                        ?>
                <h4 class="text-light p-3"><?php echo $_SESSION['usuario_id']; ?></h4>
                <h4 class="text-light p-3">Hoy es <?php echo fechaArgentina() ?></h4>
            </div>
            <div class="menu">
                <a href="paginaprincipal.php" class="d-block text-light p-3"><i
                        class="icon ion-md-home mr-2 lead"></i>Home</a>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <form action="registrar-asistencia.php" method = "POST">
                    <button class="btn btn-danger" type="submit">Registrar asistencia</button>
                </form>
            </div>
        </div>