<?php
//CONTROLADOR
include(__DIR__.'/socio.class.php');
include(__DIR__.'/servicio.class.php'); // Incluir el modelo de Servicio
include(__DIR__.'/pago.class.php'); // Incluir el modelo de Pago
include(__DIR__.'/tipo_pago.class.php');
include(__DIR__.'/membresia.class.php');
$tipoPagoModelo = new TipoPago();
$app = new Socio();
$servicioModelo = new Servicio();
$pagoModelo = new Pago();
$membresiaModelo = new Membresia();
$app->checkRol('Socio', false);
$planesPesas = $membresiaModelo->getMembresiaPesas();
$planesBoxeo = $membresiaModelo->getMembresiaBoxeo();
$planesYoga = $membresiaModelo->getMembresiaYoga();
include(__DIR__.'/views/header.php');
$action = (isset($_GET['action'])) ? $_GET['action'] : null;
$id_socio = (isset($_GET['id_socio'])) ? $_GET['id_socio'] : null;
$datos = array();
$alerta= array();
switch ($action) {
    case 'delete':
        $pagos = $pagoModelo->getPagosPorSocio($id_socio);
        if (!empty($pagos)) {
            // Si existen pagos asociados, mostrar un mensaje de error y redirigir al listado de socios
            $alerta['tipo'] = "danger";
            $alerta['mensaje'] = "No se puede eliminar al socio porque tiene pagos asociados.";
            $datos = $app->getAll(); // Obtener nuevamente la lista de socios
            include(__DIR__.'/views/alert.php');
            include(__DIR__.'/views/socio/index.php');
            exit(); // Terminar la ejecución del script
        }

        // Si no hay pagos asociados, proceder con la eliminación del socio
        $fila = $app->delete($id_socio);
        if ($fila) {
            $alerta['tipo'] = "success";
            $alerta['mensaje'] = "Socio eliminado correctamente";
        } else {
            $alerta['tipo'] = "danger";
            $alerta['mensaje'] = "No se pudo eliminar el socio";
        }
        $datos = $app->getAll();
        include(__DIR__.'/views/alert.php');
        include(__DIR__.'/views/socio/index.php');
        break;
    case 'create':
        include(__DIR__.'/views/socio/form.php');
        break;
    case 'save':
        $datos = $_POST;
        if ($app->Insert($datos)) {
            $alerta['tipo']="success";
            $alerta['mensaje']="El socio se registró correctamente";
        }else {
            $alerta['tipo']="danger";
            $alerta['mensaje']="No se pudo registrar el socio";
        }
        $datos = $app->getAll();
        include(__DIR__.'/views/alert.php');
        include(__DIR__.'/views/socio/index.php');
        break;
    case 'update':
        $datos = $app->getOne($id_socio);
        if (isset($datos["id_socio"])) {
            include(__DIR__.'/views/socio/form.php');
        }else {
            $alerta['tipo']="danger";
            $alerta['mensaje']="No existe el socio especificado.";
            $datos = $app->getAll();
            include(__DIR__.'/views/alert.php');
            include(__DIR__.'/views/socio/index.php');
        }
        break;
    case 'change':
        $datos = $_POST;
        if ($app->Update($id_socio,$datos)) {
            $alerta['tipo']="success";
            $alerta['mensaje']="El socio se actualizó correctamente";
        }else {
            $alerta['tipo']="danger";
            $alerta['mensaje']="No se pudo actualizar el socio";
        }
        $datos = $app->getAll();
        include(__DIR__.'/views/alert.php');
        include(__DIR__.'/views/socio/index.php');
        break;
    default:
        $datos = $app->getAll();
        include(__DIR__.'/views/socio/index.php');
}
include(__DIR__.'/views/footer.php');

