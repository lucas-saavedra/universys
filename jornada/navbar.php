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
$es_admin = false;
$es_alumn = false;
$es_director = false;


if (isset($_SESSION['agente_director_de_carrera'])) {
  $es_director =  $_SESSION['agente_director_de_carrera'];
}
if (isset($_SESSION['agente_alumnado'])) {
  $es_alumn =  $_SESSION['agente_alumnado'];
}

if (isset($_SESSION['admin'])) {
  $es_admin =  $_SESSION['admin'];
}
if (isset($_SESSION['agente_personal'])) {
  $es_personal =  $_SESSION['agente_personal'];
}
if (isset($_SESSION['agente_mesa_entrada'])) {
  $es_mesa =  $_SESSION['agente_mesa_entrada'];
}
if (isset($_SESSION['agente_coord'])) {
  $es_coord =  $_SESSION['agente_coord'];
}
$agente = $_SESSION['agente'];
?>
<input type="hidden" id="tipo_agente" tipo_agente="<?php echo $tipo_agente ?>">
<input type="hidden" id="id_agente">
<input type="hidden" id="jornada_agente_id">
<input type="hidden" id="persona_id">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/universys/jornada">Universys</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav mr-auto">
      <?php if ($es_personal || $es_coord || $es_director ||$es_alumn) {  ?>
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
      <?php if ($es_personal || $es_coord) {  ?>
        <li class="nav-item">
          <a class="nav-link" href="../agentes/">Agentes</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link" href="../expediente/">Productividad</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Expedientes
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="../expediente/crear-expediente.php">Cargar expediente</a>
            <a class="dropdown-item" href="../expediente/expediente-pendiente-doc.php">Sin documentacion</a>
          </div>
        </li>
        <li class="nav-item ">
          <a class="nav-link" href="../expediente/crear-expediente-sin-aviso.php">Inasistencias</a>
        </li>
      <?php } ?>
      <?php if ($es_mesa) { ?>
        <li class="nav-item">
          <a class="nav-link" href="../documentacion/index.php">Documentación</a>
        </li>
      <?php } ?>
      <?php if ($es_admin) { ?>
        <li class="nav-item">
          <a class="nav-link" href="../jornada/privilegios.php">Privilegios</a>
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
<div id='notif'></div>