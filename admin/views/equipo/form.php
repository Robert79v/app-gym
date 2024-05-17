<div class="container">
    <form action="equipo.php?action=<?php echo($action=='update')?'change&id_equipo='.$datos['id_equipo']:'save'; ?>" method="post" enctype="multipart/form-data">
        <h2><?php echo ($action == 'update') ? 'Editar' : 'Nuevo'; ?> equipo</h2>
        <div class="mb-3">
            <label for="equipo" class="form-label">Nombre del Equipo</label>
            <input type="text" class="form-control" id="equipo" name="equipo" placeholder="Captura el nombre del equipo" required="required" value="<?php echo (isset($datos["equipo"])) ? $datos["equipo"]:'';?>">
        </div>
        <div class="form-group mb-3">
            <label for="servicios">Servicios:</label><br>
            <?php
            require_once(__DIR__ . "/../../servicio.class.php");
            $servicioModelo = new Servicio();
            $servicios = $servicioModelo->getAll();

            foreach ($servicios as $servicio) {
                echo '<input type="radio" id="servicio_' . $servicio['id_servicio'] . '" name="servicios[]" value="' . $servicio['id_servicio'] . '">';
                echo '<label for="servicio_' . $servicio['id_servicio'] . '">' . $servicio['servicio'] . '</label><br>';
            }
            ?>
        </div>
        <div class="form-group mb-3">
            <label for="estado">Estado:</label><br>
            <?php
            require_once(__DIR__ . "/../../estado.class.php");
            $estadoModelo = new Estado();
            $estado = $estadoModelo->getAll();

            foreach ($estado as $estado) {
                echo '<input type="radio" id="estado_' . $estado['id_estado'] . '" name="estado[]" value="' . $estado['id_estado'] . '">';
                echo '<label for="estado_' . $estado['id_estado'] . '">' . $estado['estado'] . '</label><br>';
            }
            ?>
        </div>
        <input type="submit" class="btn btn-primary" name="save" value="Guardar"></input>
    </form>
</div>