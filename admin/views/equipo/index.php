<h1>Equipos</h1>
<div class="btn-group" role="group" aria-label="Basic example">
    <button type="button" class="btn btn-primary">Regresar</button>
    <a href="equipo.php?action=create" class="btn btn-success">Nuevo</a>
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Equipo</th>
            <th scope="col">Servicio</th>
            <th scope="col">Estado</th>
            <th scope="col">Opciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($datos as $dato) : ?>
            <tr>
                <th scope="row"><?php echo $dato['id_equipo']; ?></th>
                <td><?php echo $dato['equipo']; ?></td>
                <td><?php echo $dato['servicio']; ?></td>
                <td><?php echo $dato['estado']; ?></td>
                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="equipo.php?action=update&id_equipo=<?php echo $dato['id_equipo']; ?>"
                        class="btn btn-info">Actualizar</a>
                        <a href="equipo.php?action=delete&id_equipo=<?php echo $dato['id_equipo']; ?>"
                         class="btn btn-danger">Borrar</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<P>Se encontraron <?php echo $app->getCount();?> equipos</P>