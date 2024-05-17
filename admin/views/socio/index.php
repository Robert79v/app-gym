<h1>Socios</h1>
<div class="btn-group" role="group" aria-label="Basic example">
    <button type="button" class="btn btn-primary">Regresar</button>
    <a href="socio.php?action=create" class="btn btn-success">Nuevo</a>
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Nombre Completo</th>
            <th scope="col">Correo Electrónico</th>
            <th scope="col">Opciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($datos as $dato) : ?>
            <tr>
                <th scope="row"><?php echo $dato['id_socio']; ?></th>
                <td><?php echo $dato['nombre_completo']; ?></td>
                <td><?php echo $dato['correo']; ?></td>

                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="socio.php?action=update&id_socio=<?php echo $dato['id_socio']; ?>"
                        class="btn btn-info">Actualizar</a>
                        <a href="socio.php?action=delete&id_socio=<?php echo $dato['id_socio']; ?>"
                         class="btn btn-danger">Borrar</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<P>Se encontraron <?php echo $app->getCount();?> socios</P>