<h1>Pagos</h1>
<div class="btn-group" role="group" aria-label="Basic example">
    <button type="button" class="btn btn-primary">Regresar</button>
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">ID Socio</th>
            <th scope="col">ID Servicio</th>
            <th scope="col">Socio</th>
            <th scope="col">Servicio</th>
            <th scope="col">Membresía</th>
            <th scope="col">Método de Pago</th>
            <th scope="col">Opciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($datos as $dato) : ?>
            <tr>
                <td><?php echo $dato['id_socio']; ?></td> <!-- Muestra el ID del socio -->
                <td><?php echo $dato['id_servicio']; ?></td> <!-- Muestra el ID del servicio -->
                <td><?php echo $dato['socio']; ?></td>
                <td><?php echo $dato['servicio']; ?></td>
                <td><?php echo $dato['membresia']; ?></td>
                <td><?php echo $dato['descripcion']; ?></td>
                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="pago.php?action=delete&id_socio=<?php echo $dato['id_socio']; ?>&id_servicio=<?php echo $dato['id_servicio']; ?>"
                         class="btn btn-danger">Borrar</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<p>Se encontraron <?php echo $app->getCount();?> pagos</p>
