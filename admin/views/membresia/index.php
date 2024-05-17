<h1>Membresias</h1>
<div class="btn-group" role="group" aria-label="Basic example">
    <button type="button" class="btn btn-primary">Regresar</button>
    <a href="membresia.php?action=create" class="btn btn-success">Nuevo</a>
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Membresía</th>
            <th scope="col">Opciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($datos as $dato) : ?>
            <tr>
                <th scope="row"><?php echo $dato['id_membresia']; ?></th>
                <td><?php echo $dato['membresia']; ?></td>
                <td><?php echo $dato['costo']; ?></td>
                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="membresia.php?action=update&id_membresia=<?php echo $dato['id_membresia']; ?>"
                        class="btn btn-info">Actualizar</a>
                        <a href="membresia.php?action=delete&id_membresia=<?php echo $dato['id_membresia']; ?>"
                         class="btn btn-danger">Borrar</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<P>Se encontraron <?php echo $app->getCount();?> membresias</P>