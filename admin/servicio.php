<?php
//CONTROLADOR
//CONTROLADOR
include(__DIR__.'/servicio.class.php');
$app = new Servicio();
include(__DIR__.'/views/header.php');
$action = (isset($_GET['action'])) ? $_GET['action'] : null;
$id_servicio = (isset($_GET['id_servicio'])) ? $_GET['id_servicio'] : null;
$datos = array();
$alerta= array();
switch ($action) {
    case 'delete':
        $fila = $app->Delete($id_servicio);
        if ($fila) {
            $alerta['tipo']="success";
            $alerta['mensaje']="servicio eliminado correctamente";
        }else {
            $alerta['tipo']="danger";
            $alerta['mensaje']="No se pudo eliminar la servicio";
        }
        $datos = $app->getAll();
        include(__DIR__.'/views/alert.php');
        include(__DIR__.'/views/servicio/index.php');
        break;
    case 'create':
        include(__DIR__.'/views/servicio/form.php');
        break;
    case 'save':
        $datos = [
            'servicio' => $_POST['servicio'],
            'descripcion' => $_POST['descripcion'],
            'hora_inicio' => $_POST['hora_inicio'],
            'hora_fin' => $_POST['hora_fin'],
            'dias_semana' => implode(', ', $_POST['dias_semana']) // Convertir el array en una cadena separada por comas
        ];
        if ($app->Insert($datos)) {
            $alerta['tipo']="success";
            $alerta['mensaje']="La servicio se registro correctamente";
        }else {
            $alerta['tipo']="danger";
            $alerta['mensaje']="No se pudo registrar la servicio";
        }
        $datos = $app->getAll();
        include(__DIR__.'/views/alert.php');
        include(__DIR__.'/views/servicio/index.php');
        break;
    case 'update':
        $datos = $app->getOne($id_servicio);
        if (isset($datos["id_servicio"])) {
            include(__DIR__.'/views/servicio/form.php');
        }else {
            $alerta['tipo']="danger";
            $alerta['mensaje']="No existe la servicio especificada.";
            $datos = $app->getAll();
            include(__DIR__.'/views/alert.php');
            include(__DIR__.'/views/servicio/index.php');
        }
        break;
    case 'change':
        // Modificar la estructura de $datos para incluir la concatenación de los días de la semana seleccionados
        $datos = [
            'servicio' => $_POST['servicio'],
            'descripcion' => $_POST['descripcion'],
            'hora_inicio' => $_POST['hora_inicio'],
            'hora_fin' => $_POST['hora_fin'],
            'dias_semana' => implode(', ', $_POST['dias_semana']) // Convertir el array en una cadena separada por comas
        ];
        if ($app->Update($id_servicio,$datos)) {
            $alerta['tipo']="success";
            $alerta['mensaje']="La servicio se actualizó correctamente";
        }else {
            $alerta['tipo']="danger";
            $alerta['mensaje']="No se pudo actualizar la servicio";
        }
        $datos = $app->getAll();
        include(__DIR__.'/views/alert.php');
        include(__DIR__.'/views/servicio/index.php');
        break;
    default:
        $datos = $app->getAll();
        include(__DIR__.'/views/servicio/index.php');
}
include(__DIR__.'/views/footer.php');

