<?php
//CONTROLADOR
include(__DIR__.'/pago.class.php');
$app = new Pago();
include(__DIR__.'/views/header.php');
$action = (isset($_GET['action'])) ? $_GET['action'] : null;
$id_socio = (isset($_GET['id_socio'])) ? $_GET['id_socio'] : null;
$id_servicio = (isset($_GET['id_servicio'])) ? $_GET['id_servicio'] : null; // Agregar la obtención del id_servicio
$datos = array();
$alerta = array();
switch ($action) {
    case 'delete':
        $id_servicio = (isset($_GET['id_servicio'])) ? $_GET['id_servicio'] : null; // Obtener el id_servicio
        // Llamar al método delete del modelo pasando los IDs de socio y servicio
        $fila = $app->Delete($id_socio, $id_servicio);
        if ($fila) {
            $alerta['tipo']="success";
            $alerta['mensaje']="Pago eliminado correctamente";
        } else {
            $alerta['tipo']="danger";
            $alerta['mensaje']="No se pudo eliminar el pago";
        }
        $datos = $app->getAll(); // Obtener todos los pagos nuevamente después de la eliminación
        include(__DIR__.'/views/alert.php');
        include(__DIR__.'/views/pago/index.php');
        break;
    
    case 'update':
        $datos = $app->getOne($id_socio, $id_servicio);
        if (isset($datos["id_socio"])) {
            include(__DIR__.'/views/pago/form.php');
        } else {
            $alerta['tipo']="danger";
            $alerta['mensaje']="No existe el pago especificado.";
            $datos = $app->getAll();
            include(__DIR__.'/views/alert.php');
            include(__DIR__.'/views/pago/index.php');
        }
        break;
    case 'change':
        $datos = $_POST;
        if ($app->Update($id_socio, $id_servicio, $datos)) {
            $alerta['tipo']="success";
            $alerta['mensaje']="El pago se actualizó correctamente";
        } else {
            $alerta['tipo']="danger";
            $alerta['mensaje']="No se pudo actualizar el pago";
        }
        $datos = $app->getAll();
        include(__DIR__.'/views/alert.php');
        include(__DIR__.'/views/pago/index.php');
        break;
    default:
        $datos = $app->getAll();
        include(__DIR__.'/views/pago/index.php');
}
include(__DIR__.'/views/footer.php');
?>
