<?php
include('includes/header.php');

if ($_POST) {
  session_start();
  $usuario = $_POST['usuario'];
  $clave = $_POST['clave'];
  $query_persona = "SELECT * from persona where email = '$usuario' and contrasenia = '$clave'";
  $result_persona = mysqli_query($conexion, $query_persona);

  if (mysqli_num_rows($result_persona) > 0) {
    $persona = mysqli_fetch_assoc($result_persona);
    $persona_id = $persona['id'];
    $query_rol = "SELECT rol.nombre as rol from persona 
    RIGHT join persona_rol on persona.id = persona_rol.persona_id
    RIGHT JOIN rol on rol.id = persona_rol.rol_id
    WHERE persona_id='$persona_id'";
    $result_rol = mysqli_query($conexion, $query_rol);
    $roles = mysqli_fetch_all($result_rol, MYSQLI_ASSOC);

    if (mysqli_num_rows($result_rol) > 0) {
      foreach ($roles as $rol) :
        switch ($rol['rol']) {
          case 'admin':
            $_SESSION['admin'] = true;
            $_SESSION['agente_personal'] = true;
            $_SESSION['agente_mesa_entrada'] = true;
            $_SESSION['agente_coord'] = true;
            break;
          case 'personal':
            $_SESSION['agente_personal'] = true;
            break;
          case 'mesa_entrada':
            $_SESSION['agente_mesa_entrada'] = true;
            break;
          case 'coordinacion':
            $_SESSION['agente_coord'] = true;
            break;
          default:
            $_SESSION['agente_personal'] = false;
            $_SESSION['agente_mesa_entrada'] = false;
            $_SESSION['agente_coord'] = false;
            $_SESSION['admin'] = false;
            break;
        }
      endforeach;
    };
    $_SESSION['agente'] = $persona['nombre'];
    $_SESSION['agente_id'] = $persona['id'];
    header("location: ./jornada/index.php");
  } else {
    $_SESSION['message'] = 'Usuario y/o contraseña incorrecto';
    $_SESSION['message_type'] = 'danger';
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

      <?php if (isset($_SESSION['message'])) { ?>
        <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
          <?= $_SESSION['message'] ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php unset($_SESSION['message']);
      } ?>

    </div>
  </div>

</div>
<?php include('includes/footer.php'); ?>