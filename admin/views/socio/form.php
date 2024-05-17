<div class="container">
    <form action="socio.php?action=<?php echo ($action == 'update') ? 'change&id_socio=' . $datos['id_socio'] : 'save'; ?>" method="post" enctype="multipart/form-data">
        <h2><?php echo ($action == 'update') ? 'Editar' : 'Nuevo'; ?> Socio</h2>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Captura el nombre" required="required" value="<?php echo (isset($datos["nombre"])) ? $datos["nombre"] : ''; ?>">
        </div>
        <div class="mb-3">
            <label for="primer_apellido" class="form-label">Primer Apellido</label>
            <input type="text" class="form-control" id="primer_apellido" name="primer_apellido" placeholder="Captura el primer apellido" required="required" value="<?php echo (isset($datos["primer_apellido"])) ? $datos["primer_apellido"] : ''; ?>">
        </div>
        <div class="mb-3">
            <label for="segundo_apellido" class="form-label">Segundo Apellido</label>
            <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido" placeholder="Captura el segundo apellido" required="required" value="<?php echo (isset($datos["segundo_apellido"])) ? $datos["segundo_apellido"] : ''; ?>">
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo Electrónico</label>
            <input type="text" class="form-control" id="correo" name="correo" placeholder="Captura el correo electrónico" required="required" value="<?php echo (isset($datos["correo"])) ? $datos["correo"] : ''; ?>">
        </div>
        <div class="form-group mb-3">
            <label for="servicios">Servicios:</label><br>
            <?php
            require_once(__DIR__ . "/../../servicio.class.php");
            $servicioModelo = new Servicio();
            $servicios = $servicioModelo->getAll();

            foreach ($servicios as $servicio) {
                echo '<input type="checkbox" id="servicio_' . $servicio['id_servicio'] . '" name="servicios[]" value="' . $servicio['id_servicio'] . '">';
                echo '<label for="servicio_' . $servicio['id_servicio'] . '">' . $servicio['servicio'] . '</label><br>';
                // Generar campo oculto con nombre único para cada servicio
                echo '<input type="hidden" name="id_membresia_' . $servicio['id_servicio'] . '" value="">';
            }
            ?>
        </div>

        <!-- Aquí se mostrarán las tarjetas de membresía correspondientes a los servicios seleccionados -->
        <div id="tarjetas-membresia" class="row"> 
            <!-- Este espacio estará vacío inicialmente y se llenará dinámicamente con JavaScript -->
        </div>

        <div class="form-group mb-3">
            <label for="tipos_pago">Tipo de Pago:</label><br>
            <?php
            require_once(__DIR__ . "/../../tipo_pago.class.php");
            $tipoPagoModelo = new TipoPago();
            $tiposPago = $tipoPagoModelo->getAll();

            foreach ($tiposPago as $tipoPago) {
                echo '<input type="radio" id="tipo_pago_' . $tipoPago['id_tipo_pago'] . '" name="id_tipo_pago" value="' . $tipoPago['id_tipo_pago'] . '">';
                echo '<label for="tipo_pago_' . $tipoPago['id_tipo_pago'] . '">' . $tipoPago['descripcion'] . '</label><br>';
            }
            ?>
        </div>
        <input type="submit" class="btn btn-primary" name="save" value="Guardar"></input>
    </form>
</div>
<script>
    var planesPesas = <?php echo json_encode($planesPesas); ?>;
    var planesBoxeo = <?php echo json_encode($planesBoxeo); ?>;
    var planesYoga = <?php echo json_encode($planesYoga); ?>;

    // Función para mostrar las tarjetas de membresía correspondientes a los servicios seleccionados
    // Función para mostrar las tarjetas de membresía correspondientes a los servicios seleccionados
function mostrarTarjetasMembresia() {
    // Obtener los servicios seleccionados
    var serviciosSeleccionados = document.querySelectorAll('input[name="servicios[]"]:checked');
    var tarjetasMembresia = document.getElementById("tarjetas-membresia");
    // Limpiar el contenido previo
    if (serviciosSeleccionados && serviciosSeleccionados.length > 0){
        tarjetasMembresia.innerHTML = '';
        // Mostrar las tarjetas de membresía correspondientes
        serviciosSeleccionados.forEach(function(servicio) {
            // Dependiendo del servicio seleccionado, mostrar la tarjeta de membresía correspondiente
            switch (servicio.value) {
                case '1':
                    // Pesas
                    tarjetasMembresia.innerHTML += `
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Planes para pesas</h5>
                                    <div class="form-group mb-3">
                                        <select name="id_membresia_pesas" id="id_membresia_pesas" class="form-select">
                                            ${planesPesas.map(planPesas => `
                                                <option value="${planPesas.id_membresia}">${planPesas.membresia}</option>
                                            `).join('')}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    break;
                case '2':
                    // Boxeo
                    tarjetasMembresia.innerHTML += `
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Planes para boxeo</h5>
                                    <div class="form-group mb-3">
                                        <select name="id_membresia_boxeo" id="id_membresia_boxeo" class="form-select">
                                            ${planesBoxeo.map(planBoxeo => `
                                                <option value="${planBoxeo.id_membresia}">${planBoxeo.membresia}</option>
                                            `).join('')}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    break;
                case '3':
                    // Yoga
                    tarjetasMembresia.innerHTML += `
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Planes para yoga</h5>
                                    <div class="form-group mb-3">
                                        <select name="id_membresia_yoga" id="id_membresia_yoga" class="form-select">
                                            ${planesYoga.map(planYoga => `
                                                <option value="${planYoga.id_membresia}">${planYoga.membresia}</option>
                                            `).join('')}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    break;
            }
        });
        // Actualizar los campos ocultos de ID de membresía
        serviciosSeleccionados.forEach(function(servicio) {
            var idMembresiaSelect = document.querySelector('select[name="id_membresia"]');

                var idMembresia = idMembresiaSelect.value;
                document.querySelector('input[name="id_membresia"]').value = idMembresia;
            
        });

    }
}


    // Llamar a la función cuando se cambie la selección de servicios
    document.querySelectorAll('input[name="servicios[]"]').forEach(function(servicio) {
        servicio.addEventListener('change', mostrarTarjetasMembresia);
    });

    // Mostrar las tarjetas de membresía al cargar la página (en caso de que haya servicios seleccionados previamente)
    mostrarTarjetasMembresia();
</script>
