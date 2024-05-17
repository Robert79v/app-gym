<?php
//CONTROLADOR
include(__DIR__.'/tienda.class.php');
$app = new Tienda();
include(__DIR__.'/views/header.php');
$app->checkRol('Administrador', true);
$app->checkPrivilegio('Tienda', true);
$action = (isset($_GET['action'])) ? $_GET['action'] : null;
$id_tienda = (isset($_GET['id_tienda'])) ? $_GET['id_tienda'] : null;
$datos = array();
$alerta= array();
switch ($action) {
    case 'delete':
        $fila = $app->Delete($id_tienda);
        if ($fila) {
            $alerta['tipo']="success";
            $alerta['mensaje']="tienda eliminada correctamente";
        }else {
            $alerta['tipo']="danger";
            $alerta['mensaje']="No se pudo eliminar la tienda";
        }
        $datos = $app->getAll();
        include(__DIR__.'/views/alert.php');
        include(__DIR__.'/views/tienda/index.php');
        break;
    case 'create':
        include(__DIR__.'/views/tienda/form.php');
        break;
    case 'save':
        $datos = $_POST;
        //echo "<pre>";
        //print_r($_GET);
        //print_r($_POST);
        //print_r($_FILES);
        //die;
        $datos['fotografia']=$_FILES['fotografia']['name'];
        if ($app->Insert($datos)) {
            $alerta['tipo']="success";
            $alerta['mensaje']="La tienda se registro correctamente";
        }else {
            $alerta['tipo']="danger";
            $alerta['mensaje']="No se pudo registrar la tienda";
        }
        $datos = $app->getAll();
        include(__DIR__.'/views/alert.php');
        include(__DIR__.'/views/tienda/index.php');
        break;
    case 'update':
        $datos = $app->getOne($id_tienda);
        if (isset($datos["id_tienda"])) {
            include(__DIR__.'/views/tienda/form.php');
        }else {
            $alerta['tipo']="danger";
            $alerta['mensaje']="No existe el tienda especificado.";
            $datos = $app->getAll();
            include(__DIR__.'/views/alert.php');
            include(__DIR__.'/views/tienda/index.php');
        }
        break;
    case 'change':
        $datos = $_POST;
        if ($app->Update($id_tienda,$datos)) {
            $alerta['tipo']="success";
            $alerta['mensaje']="El tienda se actualizó correctamente";
        }else {
            $alerta['tipo']="danger";
            $alerta['mensaje']="No se pudo actualizar el tienda";
        }
        $datos = $app->getAll();
        include(__DIR__.'/views/alert.php');
        include(__DIR__.'/views/tienda/index.php');
        break;
    default:
        $datos = $app->getAll();
        include(__DIR__.'/views/tienda/index.php');
}
include(__DIR__.'/views/footer.php');
