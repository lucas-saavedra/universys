<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Universys</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>

</head>
<?php include("includes/db.php"); ?>
<?php include("includes/consultas.php"); ?>
<?php $tipo_agente = $_SESSION['tipo_agente']; ?>
<input type="hidden" id="tipo_agente" tipo_agente="<?php echo $tipo_agente ?>">
<input type="hidden" id="id_agente">
<input type="hidden" id="jornada_agente_id">
<div class="container-fluid">
  <div class="row">
    <div class="col">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/universys/jornada">Universys</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="/universys/jornada/agente.php">Inicio <span class="sr-only">(current)</span></a>
            </li>
          </ul>
          <span class="navbar-text">
            Usted está trabajando con el tipo de agente: <?php echo $_SESSION['tipo_agente'] ?>
          </span>
        </div>
      </nav>
    </div>
  </div>
</div>


<body>
  <div id='notif'></div>

  <div class="position-fixed bottom-0 right-0 p-3" style="z-index: 5; right: 0; bottom: 0;">
    <div id="toastNotif" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
      <div class="toast-header">
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="toast-body" id="toast_notif">
      </div>
    </div>
  </div>