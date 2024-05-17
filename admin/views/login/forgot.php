<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex align-items-center justify-content-center h-100">
      <div class="col-md-8 col-lg-7 col-xl-6">
        <h1 class="mb-4">Ingresa tu correo para recuperación</h1>
      </div>
      <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
        <form action="login.php?action=reset" method="post">
          <!-- Input de Correo -->
          <div class="form-outline mb-4">
            <input type="email" id="correo" name="correo" class="form-control form-control-lg" />
            <label class="form-label" for="correo">Dirección de correo electrónico</label>
          </div>
          <!-- Botón de Envío -->
          <button type="submit" class="btn btn-primary btn-lg btn-block">Recuperar</button>
        </form>
      </div>
    </div>
  </div>
</section>
