<?php

require_once "../Twig-1.35.3/lib/Twig/Autoloader.php";
Twig_Autoloader::register();

include_once '../config/iConfig.php';
require_once "../autoload.php";

use components\App;

$app = new App();
