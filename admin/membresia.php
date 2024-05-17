<?php
include(__DIR__.'/membresia.class.php');
$app = new Membresia();
include(__DIR__.'/views/header.php');
$action = (isset($_GET['action'])) ? $_GET['action'] : null;
$id_membresia = (isset($_GET['id_membresia'])) ? $_GET['id_membresia'] : null;
$datos = array();
$alerta= array();
switch ($action) {
    case 'delete':
        $fila = $app->Delete($id_membresia);
        if ($fila) {
            $alerta['tipo']="success";
            $alerta['mensaje']="membresia eliminado correctamente";
        }else {
            $alerta['tipo']="danger";
            $alerta['mensaje']="No se pudo eliminar la membresia";
        }
        $datos = $app->getAll();
        include(__DIR__.'/views/alert.php');
        include(__DIR__.'/views/membresia/index.php');
        break;
    case 'create':
        include(__DIR__.'/views/membresia/form.php');
        break;
    case 'save':
        $datos = [
            'membresia' => $_POST['membresia']
            ];
        if ($app->Insert($datos)) {
            $alerta['tipo']="success";
            $alerta['mensaje']="La membresia se registro correctamente";
        }else {
            $alerta['tipo']="danger";
            $alerta['mensaje']="No se pudo registrar la membresia";
        }
        $datos = $app->getAll();
        include(__DIR__.'/views/alert.php');
        include(__DIR__.'/views/membresia/index.php');
        break;
    case 'update':
        $datos = $app->getOne($id_membresia);
        if (isset($datos["id_membresia"])) {
            include(__DIR__.'/views/membresia/form.php');
        }else {
            $alerta['tipo']="danger";
            $alerta['mensaje']="No existe la membresia especificada.";
            $datos = $app->getAll();
            include(__DIR__.'/views/alert.php');
            include(__DIR__.'/views/membresia/index.php');
        }
        break;
    case 'change':
        $datos = [
            'membresia' => $_POST['membresia']
        ];
        if ($app->Update($id_membresia,$datos)) {
            $alerta['tipo']="success";
            $alerta['mensaje']="La membresia se actualizó correctamente";
        }else {
            $alerta['tipo']="danger";
            $alerta['mensaje']="No se pudo actualizar la membresia";
        }
        $datos = $app->getAll();
        include(__DIR__.'/views/alert.php');
        include(__DIR__.'/views/membresia/index.php');
        break;
    default:
        $datos = $app->getAll();
        include(__DIR__.'/views/membresia/index.php');
}
include(__DIR__.'/views/footer.php');

