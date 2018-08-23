<?php
session_start();
//require_once "../vendor/autoload.php";
//Twig_Autoloader::register();
require_once "../autoload.php";
use components\App;
$app = new App();


//var_dump($app->db->getPDO());