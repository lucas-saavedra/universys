<?php include("../includes/header.php"); ?>

<?php include("includes/consultas.php");  ?>

<?php if (isset($_GET['tipo_agente'])) {
  $tipo_agente =  $_GET['tipo_agente'];
} else {
  $tipo_agente = 'docente';
}
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (!isset($_SESSION['agente'])) {
  $agente = $_SESSION['agente'];
  $agente_id = $_SESSION['agente_id'];
  header("Location: ../index.php ");
}
$es_personal = false;
$es_mesa = false;
$es_coord = false;

if (isset($_SESSION['agente_personal'])) {
  $es_personal =  $_SESSION['agente_personal'];
}
if (isset($_SESSION['agente_mesa_entrada'])) {
  $es_mesa =  $_SESSION['agente_mesa_entrada'];
}
if (isset($_SESSION['agente_coord'])) {
  $es_mesa =  $_SESSION['agente_coord'];
}

$agente = $_SESSION['agente'];
?>
<input type="hidden" id="tipo_agente" tipo_agente="<?php echo $tipo_agente ?>">
<input type="hidden" id="id_agente">
<input type="hidden" id="jornada_agente_id">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/universys/jornada">Universys</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#"> Asistencia <span class="sr-only">(current)</span></a>
      </li>
      <?php if ($es_personal) {  ?>
        <li class="nav-item ">
          <a class="nav-link" href="../expediente/crear-expediente.php">Expedientes </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Jornadas
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="../jornada/agente.php?tipo_agente=<?php echo $tipo_agente ?>">Jornada Agente</a>
            <a class="dropdown-item" href="../jornada/mesa.php">Jornada de Mesa</a>
          </div>
        </li>
      <?php } ?>
      <?php if ($es_mesa) { ?>
        <li class="nav-item">
          <a class="nav-link" href="../expediente/subir-documentacion.php">Documentacion</a>
        </li>
      <?php } ?>
    </ul>
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
      <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $agente ?> <i class="fas fa-user fa-fw"></i>
        </a>
        <div class="dropdown-menu  dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="../includes/logout.php">Salir</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
</div>



<!-- 
<div class="container-fluid">
  <div class="row">
    <div class="col-md-4">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="#">Active</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>
      </ul>
    </div>
  </div>
</div>

 -->
<div id='notif'></div>