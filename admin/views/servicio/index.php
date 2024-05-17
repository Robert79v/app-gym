<h1>Servicios</h1>
<div class="btn-group" role="group" aria-label="Basic example">
    <button type="button" class="btn btn-primary">Regresar</button>
    <a href="servicio.php?action=create" class="btn btn-success">Nuevo</a>
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Servicio</th>
            <th scope="col">Hora de Inicio</th>
            <th scope="col">Hora de Fin</th>
            <th scope="col">Días a la Semana</th>
            <th scope="col">Opciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($datos as $dato) : ?>
            <tr>
                <th scope="row"><?php echo $dato['id_servicio']; ?></th>
                <td><?php echo $dato['servicio']; ?></td>
                <td><?php echo $dato['hora_inicio']; ?></td>
                <td><?php echo $dato['hora_fin']; ?></td>
                <td><?php echo $dato['dias_semana']; ?></td>
                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="servicio.php?action=update&id_servicio=<?php echo $dato['id_servicio']; ?>"
                        class="btn btn-info">Actualizar</a>
                        <a href="servicio.php?action=delete&id_servicio=<?php echo $dato['id_servicio']; ?>"
                         class="btn btn-danger">Borrar</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<P>Se encontraron <?php echo $app->getCount();?> servicios</P>