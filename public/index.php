<?php

session_start();

require_once "../Twig-1.35.3/lib/Twig/Autoloader.php";
Twig_Autoloader::register();

require_once "../autoload.php";

use components\App;

$app = new App();

//var_dump($app->db->getPDO());