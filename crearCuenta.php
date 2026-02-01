<!DOCTYPE html>
<html lang="es">
<?php include('basesLogin/head.php'); ?>

<body class="d-flex align-items-center min-vh-100 py-4">
  <?php include('msjs.php'); ?>
  <?php include("dashboard/bases/loader.html"); ?>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-8">
        <div class="auth auth-form-light parking-auth-card shadow-sm p-4 p-md-5">
          <div class="brand-logo text-center mb-4">
            <a href="./">
              <img src="assets/custom/imgs/logo.png" alt="Parking" class="parking-logo img-fluid" />
            </a>
          </div>
          <h2 class="text-center mb-4 fs-4 fw-bold text-dark">Crear cuenta</h2>
          <form action="acciones/login/CreateUser.php" method="post" autocomplete="off">
            <div class="row g-3">
              <div class="col-12 col-md-6">
                <label for="nombre_completo" class="form-label">Nombre completo</label>
                <input type="text" name="nombre_completo" id="nombre_completo" class="form-control form-control-lg" required placeholder="Nombre completo" />
              </div>
              <div class="col-12 col-md-6">
                <label for="din" class="form-label">DNI / CIF</label>
                <input type="text" name="din" id="din" class="form-control form-control-lg" placeholder="DNI / CIF" required />
              </div>
              <div class="col-12">
                <label for="direccion_completa" class="form-label">Dirección completa</label>
                <input type="text" name="direccion_completa" id="direccion_completa" class="form-control form-control-lg" placeholder="Dirección completa" required />
              </div>
              <div class="col-12 col-md-6">
                <label for="passwordUser" class="form-label">Clave</label>
                <input type="password" name="passwordUser" id="passwordUser" class="form-control form-control-lg" placeholder="Clave" required />
              </div>
              <div class="col-12 col-md-6">
                <label for="emailUser" class="form-label">Email</label>
                <input type="email" name="emailUser" id="emailUser" class="form-control form-control-lg" placeholder="Email" required />
              </div>
              <div class="col-12 col-md-6">
                <label for="tlf" class="form-label">Teléfono</label>
                <input type="text" name="tlf" id="tlf" class="form-control form-control-lg" placeholder="Teléfono" required />
              </div>
              <div class="col-12 col-md-6">
                <label for="conocido_por" class="form-label">¿Cómo nos conoció?</label>
                <select name="conocido_por" id="conocido_por" class="form-select form-select-lg">
                  <option value="Seleccione">Seleccione</option>
                  <option value="Ya soy cliente">Ya soy cliente</option>
                  <option value="Google">Google</option>
                  <option value="Teléfono">Teléfono</option>
                  <option value="Un Amigo">Un Amigo</option>
                  <option value="Internet">Internet</option>
                  <option value="Periódico">Periódico</option>
                  <option value="Folleto">Folleto</option>
                  <option value="Radio">Radio</option>
                </select>
              </div>
              <div class="col-12">
                <label for="observaciones" class="form-label">Observaciones</label>
                <textarea name="observaciones" id="observaciones" class="form-control" placeholder="Observaciones" rows="3"></textarea>
              </div>
              <div class="col-12">
                <div class="form-check">
                  <input type="checkbox" name="terminos" value="1" id="terminos" class="form-check-input" checked />
                  <label class="form-check-label" for="terminos">Acepto los términos de uso</label>
                </div>
              </div>
              <div class="col-12">
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary btn-lg fw-semibold">
                    Crear mi cuenta
                  </button>
                </div>
              </div>
            </div>
            <div class="mt-3">
              <a href="./" class="auth-link text-dark text-decoration-none small" title="Volver">
                <i class="bi bi-arrow-left-circle me-1"></i> Volver
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php include('basesLogin/footerJS.html'); ?>
</body>

</html>