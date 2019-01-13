<?php
function my_autoload($className)
{
    $filename = '../' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($filename)) {
        require_once $filename;
    }
}

spl_autoload_register('my_autoload');