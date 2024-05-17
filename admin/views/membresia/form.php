<div class="container">
    <form action="membresia.php?action=<?php echo($action=='update')?'change&id_membresia='.$datos['id_membresia']:'save'; ?>" method="post" enctype="multipart/form-data">
        <h2><?php echo ($action == 'update') ? 'Editar' : 'Nuevo'; ?> membresia</h2>
        <div class="mb-3">
            <label for="membresia" class="form-label">Membresia:</label>
            <input type="text" class="form-control" id="membresia" name="membresia" placeholder="Captura el membresia" required="required" value="<?php echo (isset($datos["membresia"])) ? $datos["membresia"]:'';?>">
        </div>
        <div class="mb-3">
            <label for="costo" class="form-label">Costo:</label>
            <input type="number" class="form-control" id="costo" name="costo" placeholder="Captura el costo" required="required" value="<?php echo (isset($datos["costo"])) ? $datos["costo"]:'';?>">
        </div>
        <input type="submit" class="btn btn-primary" name="save" value="Guardar"></input>
    </form>
</div>