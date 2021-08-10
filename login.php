
<title>Universys-Login</title>
<?php include('includes/header.php'); 

session_unset();?>
<head>
  <title></title>
</head>

<link rel="stylesheet" href="https://bootswatch.com/4/darkly/bootstrap.min.css">
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-8 col-lg-6 text-center">
        <form action="backend/login.php" method="POST" id="loginForm">
          <h1 class="h3 mb-3 font-weight-normal"><i class="fab fa-connectdevelop"></i>Universys</h1>
          <div class="form-group text-left">
            <label for="inputEmail">Email</label>
            <input type="email" name="usuario" id="inputEmail" class="form-control" placeholder="Email" required=""
              autofocus="">
          </div>
          <div class="form-group text-left">
            <label for="inputPassword">Contraseña</label>
            <input type="password" name="clave" id="inputPassword" class="form-control" placeholder="Contraseña"
              required="">
          </div>
          <button class="btn btn-lg btn-primary btn-block" type="submit">Ingresar</button>
          <p class="mt-5 mb-3 text-muted">© 2021-2021</p>
        </form>
      </div>
    </div>
  </div>


   <?php include('includes/footer.php'); ?> 