<section class="vh-100 bg-light">
  <div class="container py-5 h-100">
    <div class="row d-flex align-items-center justify-content-center h-100">
      <div class="col-md-8 col-lg-7 col-xl-6 text-center">
        <img src="../images/logo.png" class="img-fluid mb-4" alt="Logo de la empresa">
      </div>
      <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
        <form action="login.php?action=login" method="post">
          <!-- Input de Correo -->
          <div class="form-group mb-4">
            <label for="correo" class="text-muted">Correo electrónico:</label>
            <input type="email" id="correo" name="correo" class="form-control form-control-lg" />
          </div>

          <!-- Input de Contraseña -->
          <div class="form-group mb-4">
            <label for="contrasena" class="text-muted">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" class="form-control form-control-lg" />
          </div>

          <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
            <label class="form-check-label" for="form1Example3">Recordarme</label>
          </div>

          <!-- Botón de Inicio de Sesión -->
          <button type="submit" class="btn btn-primary btn-lg btn-block mb-4">Iniciar Sesión</button>

          <hr class="my-4">

          <!-- Opción de Inicio de Sesión con Facebook -->
          <a class="btn btn-primary btn-lg btn-block mb-2" style="background-color: #3b5998" href="#!"
            role="button">
            <i class="fab fa-facebook-f me-2"></i>Continuar con Facebook
          </a>
          <!-- Opción de Inicio de Sesión con Twitter -->
          <a class="btn btn-primary btn-lg btn-block" style="background-color: #55acee" href="#!"
            role="button">
            <i class="fab fa-twitter me-2"></i>Continuar con Twitter</a>

          <div class="text-center mt-3">
            <a href="login.php?action=forgot" class="text-muted">¿Olvidaste tu contraseña?</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
