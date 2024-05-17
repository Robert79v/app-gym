<?php
include __DIR__.'/admin/sistema.class.php';
$datos = $_POST;
$app = new Sistema();
if($app->validateEmail($datos['correo'])){
    if($app->login($datos['correo'], $datos['contrasena'])){
        header("Location: profile.php");
    }else{
        header("location:login.php");
    }
} else {
    header("Location: login.php");
}
?>