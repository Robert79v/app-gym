<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gimnasio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Ferretería</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Catálogos
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="servicio.php">Servicios</a></li>
                <li><a class="dropdown-item" href="membresia.php">Membresías</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="empleado.php">Empleados</a></li>
                <li><a class="dropdown-item" href="socio.php">Socios</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="pago.php">Pagos</a></li>
            </ul>
            </li>
        </ul>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="login,php?action=logout.php">Logout</a>
        </li>
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-info" type="submit">Search</button>
        </form>
        </div>
    </div>
  </nav>