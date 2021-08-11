<?php
include('includes/header.php');
session_start();
if ($_POST) {
  $usuario = $_POST['usuario'];
  $clave = $_POST['clave'];
  $query_persona = "SELECT *from persona where email = '$usuario' and contrasenia = '$clave'";
  $result_persona = mysqli_query($conexion, $query_persona);
  function obtener_area($persona_id,$area_id, $conexion)
  {
    $query_area = "SELECT * FROM no_docente 
  left join persona on persona.id= no_docente.persona_id
  RIGHT JOIN  jornada_no_docente on jornada_no_docente.no_docente_id=no_docente.id
  WHERE persona.id='$persona_id' AND jornada_no_docente.area_id= '$area_id' ";
    $result_area = mysqli_query($conexion, $query_area);
    return mysqli_num_rows($result_area);
  }

  if (mysqli_num_rows($result_persona) > 0) {
    $persona = mysqli_fetch_assoc($result_persona);
    $persona_id = $persona['id'];
    /* $sql = "SELECT id FROM jornada_no_docente WHERE jornada_no_docente.no_docente_id = 
    (SELECT id FROM no_docente where no_docente.persona_id = '$id_agente') AND jornada_no_docente.area_id = 1";
    $result = mysqli_query($conexion, $sql); */

    if (obtener_area($persona_id,1, $conexion) > 0) {
      $_SESSION['agente_personal'] = true;
    }
    if (obtener_area($persona_id ,7, $conexion) > 0) {
      $_SESSION['agente_mesa_entrada'] = true;
    }
    if (obtener_area($persona_id,2, $conexion) > 0) {
      $_SESSION['agente_mesa_coord'] = true;
    }

    $_SESSION['agente'] = $persona['nombre'];
    $_SESSION['agente_id'] = $persona['id'];
    header("location: ./jornada/index.php");
  } else {
    echo 'Datos incorrectos';
  }
}

?>

<head>
  <title>Universys-Login</title>
</head>

<link rel="stylesheet" href="https://bootswatch.com/4/darkly/bootstrap.min.css">
<div class="container">
  <div class="row justify-content-center mt-5">
    <div class="col-md-8 col-lg-6 text-center">
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="loginForm">
        <h1 class="h3 mb-3 font-weight-normal"><i class="fab fa-connectdevelop"></i>Universys</h1>
        <div class="form-group text-left">
          <label for="inputEmail">Email</label>
          <input type="email" name="usuario" id="inputEmail" class="form-control" placeholder="Email" required="" autofocus="">
        </div>
        <div class="form-group text-left">
          <label for="inputPassword">Contraseña</label>
          <input type="password" name="clave" id="inputPassword" class="form-control" placeholder="Contraseña" required="">
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Ingresar</button>
        <p class="mt-5 mb-3 text-muted">© 2021-2021</p>
      </form>
    </div>
  </div>
</div>


<?php include('includes/footer.php'); ?>