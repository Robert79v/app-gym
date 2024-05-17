<?php
session_start();
define('DB_DRIVER', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'gimnasio');
define('DB_USER', 'gimnasio');
define('DB_PASSWORD','123');
define('DB_PORT','3307');
Class Config{
    function getImageSize(){
        return 512000;
    }
    function getImageType(){
        return array("image/png","image/tiff","image/jpeg","image/jpg");
    }
}
?>