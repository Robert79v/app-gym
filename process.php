<?php
require_once(__DIR__.'/admin/sistema.class.php');
include('header_sin_nada.php');
$app = new Sistema();
$datos = $_POST;
if($app->register($datos)){
    $tipo = 'success';
    $mensaje = 'Se ha registrado correctamente';
    $app->alert($tipo,$mensaje);
}else{
    $tipo = 'danger';
    $mensaje = 'No se ha podido registrar';
    $app->alert($tipo,$mensaje);
}
?>