<div class="container">
    <form action="servicio.php?action=<?php echo($action=='update')?'change&id_servicio='.$datos['id_servicio']:'save'; ?>" method="post" enctype="multipart/form-data">
        <h2><?php echo ($action == 'update') ? 'Editar' : 'Nuevo'; ?> servicio</h2>
        <div class="mb-3">
            <label for="servicio" class="form-label">Servicio:</label>
            <input type="text" class="form-control" id="servicio" name="servicio" placeholder="Captura el servicio" required="required" value="<?php echo (isset($datos["servicio"])) ? $datos["servicio"]:'';?>">
        </div>
        <div class="mb-3">
            <label for="Descripcion" class="form-label">Descripción:</label>
            <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Captura la descripción" required="required" rows="10"><?php echo (isset($datos["descripcion"])) ? $datos["descripcion"] : ''; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="hora_inicio">Elige una hora de inicio (formato 24 horas):</label>
            <input type="time" id="hora_inicio" name="hora_inicio" min="06:00" max="11:59" step="1800" value="<?php echo (isset($datos["hora_inicio"])) ? $datos["hora_inicio"] : '06:00'; ?>">
        </div>
        <div class="mb-3">
            <label for="hora_fin">Elige una hora de fin (formato 24 horas):</label>
            <input type="time" id="hora_fin" name="hora_fin" min="13:00" max="22:00" step="1800" value="<?php echo (isset($datos["hora_fin"])) ? $datos["hora_fin"]:'22:00';?>">
        </div>
        <div class="mb-3">
            <label>Días de la semana:</label><br>
            <input type="checkbox" name="dias_semana[]" value="Lunes"> Lunes<br>
            <input type="checkbox" name="dias_semana[]" value="Martes"> Martes<br>
            <input type="checkbox" name="dias_semana[]" value="Miércoles"> Miércoles<br>
            <input type="checkbox" name="dias_semana[]" value="Jueves"> Jueves<br>
            <input type="checkbox" name="dias_semana[]" value="Viernes"> Viernes<br>
            <input type="checkbox" name="dias_semana[]" value="Sábado"> Sábado<br>
        </div>
        <input type="submit" class="btn btn-primary" name="save" value="Guardar"></input>
    </form>
</div>