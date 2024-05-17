<?php
//CONTROLADOR
//print_r($_GET);
//print_r($_POST);
include(__DIR__.'/equipo.class.php');
$app = new Equipo();
include(__DIR__.'/views/header.php');
$action = (isset($_GET['action'])) ? $_GET['action'] : null;
$id_equipo = (isset($_GET['id_equipo'])) ? $_GET['id_equipo'] : null;
$datos = array();
$alerta = array();
switch ($action) {
    case 'delete':
        $fila = $app->Delete($id_equipo);
        if ($fila) {
            $alerta['tipo']="success";
            $alerta['mensaje']="equipo eliminado correctamente";
        }else {
            $alerta['tipo']="danger";
            $alerta['mensaje']="No se pudo eliminar el equipo";
        }
        $datos = $app->getAll();
        include(__DIR__.'/views/alert.php');
        include(__DIR__.'/views/equipo/index.php');
        break;
    case 'create':
        include(__DIR__.'/views/equipo/form.php');
        break;
    case 'save':
        $datos = $_POST;
        if ($app->Insert($datos)) {   
            $alerta['tipo']="success";
            $alerta['mensaje']="El equipo se registro correctamente";
        }else {         
            $alerta['tipo']="danger";
            $alerta['mensaje']="No se pudo registrar el equipo";
        }
        $datos = $app->getAll();
        include(__DIR__.'/views/alert.php');
        include(__DIR__.'/views/equipo/index.php');
        break;
    case 'update':
        $datos = $app->getOne($id_equipo);
        if (isset($datos["id_equipo"])) {
            include(__DIR__.'/views/equipo/form.php');
        }else {
            $alerta['tipo']="danger";
            $alerta['mensaje']="No existe el equipo especificado.";
            $datos = $app->getAll();
            include(__DIR__.'/views/alert.php');
            include(__DIR__.'/views/equipo/index.php');
        }
        break;
    case 'change':
        $datos = $_POST;
        if ($app->Update($id_equipo,$datos)) {
            $alerta['tipo']="success";
            $alerta['mensaje']="El equipo se actualizó correctamente";
        }else {
            $alerta['tipo']="danger";
            $alerta['mensaje']="No se pudo actualizar el equipo";
        }
        $datos = $app->getAll();
        include(__DIR__.'/views/alert.php');
        include(__DIR__.'/views/equipo/index.php');
        break;
    default:
        $datos = $app->getAll();
        include(__DIR__.'/views/equipo/index.php');
}
include(__DIR__.'/views/footer.php');
