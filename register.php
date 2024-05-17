<?php include('header_sin_nada.php'); ?>

<section class="vh-100 bg-light">
  <div class="container py-5 h-100">
    <div class="row d-flex align-items-center justify-content-center h-100">
      <div class="col-md-8 col-lg-7 col-xl-6 text-center">
        <img src="images/logo.png" class="img-fluid mb-4" alt="logo">
      </div>
      <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
        <form action="process.php" method="post">
          <!-- Nombre input -->
          <div class="form-group mb-4">
            <label for="nombre" class="text-muted">Nombre:</label>
            <input type="text" id="nombre" name="nombre" class="form-control form-control-lg" />
          </div>

          <!-- Primer Apellido input -->
          <div class="form-group mb-4">
            <label for="primer_apellido" class="text-muted">Primer Apellido:</label>
            <input type="text" id="primer_apellido" name="primer_apellido" class="form-control form-control-lg" />
          </div>

          <!-- Segundo Apellido input -->
          <div class="form-group mb-4">
            <label for="segundo_apellido" class="text-muted">Segundo Apellido:</label>
            <input type="text" id="segundo_apellido" name="segundo_apellido" class="form-control form-control-lg" />
          </div>

          <!-- Correo Electrónico input -->
          <div class="form-group mb-4">
            <label for="correo" class="text-muted">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" class="form-control form-control-lg" />
          </div>

          <!-- Contraseña input -->
          <div class="form-group mb-4">
            <label for="contrasena" class="text-muted">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" class="form-control form-control-lg" />
          </div>

          <!-- Botón de Registro -->
          <button type="submit" class="btn btn-primary btn-lg btn-block mb-4">Registrarse</button>
        </form>
      </div>
    </div>
  </div>
</section>
