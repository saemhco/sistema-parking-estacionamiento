<?php
session_start();
if (isset($_SESSION['emailUser']) != "") {
  include('../config/config.php');
  $IdUser     = $_SESSION['IdUser'];
  $rolUser     = $_SESSION['rol'];
  $email      = $_SESSION['emailUser'];
  header('location: dashboard/');
}
?>
<!DOCTYPE html>
<html lang="es">
<?php include('basesLogin/head.php'); ?>

<body class="d-flex align-items-center min-vh-100">
  <?php include('msjs.php'); ?>
  <?php include("dashboard/bases/loader.html"); ?>

  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
        <div class="auth auth-form-light parking-auth-card shadow-sm p-4 p-md-5">
          <div class="brand-logo text-center mb-4">
            <a href="./">
              <img src="assets/custom/imgs/logo.png" alt="Parking" class="parking-logo img-fluid" />
            </a>
          </div>
          <h2 class="text-center mb-4 fs-4 fw-bold text-dark">Iniciar sesión</h2>
          <form action="acciones/login/acciones_login.php" method="post" class="pt-2" autocomplete="off">
            <div class="mb-3">
              <label for="emailUser" class="form-label visually-hidden">Email</label>
              <input type="email" name="emailUser" id="emailUser" class="form-control form-control-lg" required placeholder="Email" />
            </div>
            <div class="mb-3">
              <label for="passwordUser" class="form-label visually-hidden">Clave</label>
              <input type="password" name="passwordUser" id="passwordUser" class="form-control form-control-lg" placeholder="Clave" required />
            </div>
            <div class="d-grid gap-2 mt-4">
              <button type="submit" class="btn btn-primary btn-lg fw-semibold">
                Iniciar sesión
              </button>
            </div>
            <p class="text-center mt-4 mb-0 small text-muted">
              ¿Nuevo aquí? <a href="crearCuenta.php" class="text-primary fw-medium">Crear una cuenta</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php include('basesLogin/footerJS.html'); ?>
</body>

</html>