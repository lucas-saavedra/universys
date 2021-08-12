<?php include("../includes/header.php"); ?>

<?php include("includes/consultas.php");  ?>

<?php if (isset($_GET['tipo_agente'])) {
  $tipo_agente =  $_GET['tipo_agente'];
}
/* if (session_status() !== PHP_SESSION_ACTIVE) session_start(); */
$agente = $_SESSION['agente'];
$agente_id = $_SESSION['agente_id'];
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

              <a class="nav-link" href="/universys/jornada/agente.php?tipo_agente=<?php echo $tipo_agente ?>">Inicio <span class="sr-only">(current)</span></a>
            </li>
            <?php if ($es_personal) {  ?>
              <li class="nav-item ">
                <a class="nav-link" href="../expediente/crear-expediente.php">Expedientes<span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../expediente/confirmar-p-productividad.php">Planilla de producción </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../expediente/crear-expediente-sin-aviso.php">Expediente sin aviso </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../expediente/expediente-pendiente-doc.php">Pendientes de documentación </a>
              </li>
              <li class="nav-item">
                <a class="btn btn-outline-success my-2 my-sm-0" href="../expediente/generar_inasistencia.php">Generar inasistencias </a>
              </li>
            <?php } ?>
            <?php if ($es_mesa) { ?>
              <li class="nav-item ">
                <a class="nav-link" href="../expediente/crear-expediente.php">Documentacion<span class="sr-only">(current)</span></a>
              </li>
            <?php } ?>
          </ul>
          <?php if ($es_personal) {  ?>
            <span>
              <div class="dropdown mx-3">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Tipo de agente
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="agente.php?tipo_agente=<?php echo 'docente' ?>">Docente</a>
                  <a class="dropdown-item" href="agente.php?tipo_agente=<?php echo 'no_docente' ?>">No Docente</a>
                </div>
              </div>
            </span>
          <?php } ?>
          <span>
            <div class="dropdown mx-3">

              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo $agente ?> <i class="fas fa-user fa-fw"></i>
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="../includes/logout.php">Salir</a>
              </div>
            </div>
          </span>











        </div>
      </nav>
    </div>
  </div>
</div>



<div id='notif'></div>

<div class="position-fixed bottom-0 right-0 p-3" style="z-index: 7000; right: 0; bottom: 0;">
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