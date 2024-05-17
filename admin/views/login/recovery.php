<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex align-items-center justify-content-center h-100">
      <div class="col-md-8 col-lg-7 col-xl-6">
        <img src="logo.php" class="img-fluid" alt="Phone image">
      </div>
      <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
        <form action="login.php?action=recovery&token=<?php echo $token?>" method="post">
        <h1>Establece tu nueva contraseña</h1>  
          <!-- Password input -->
          <div class="form-outline mb-4">
            <input type="password" id="constrasena" name="contrasena" class="form-control form-control-lg" />
            <label class="form-label" for="constrasena">constraseña</label>
          </div>
          <!-- Submit button -->
          <button type="submit" class="btn btn-primary btn-lg btn-block">Enviar</button>
        </form>
      </div>
    </div>
  </div>
</section>