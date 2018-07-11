<?php
/**
 * Created by PhpStorm.
 * User: alterwalker
 * Date: 21.05.2018
 * Time: 19:58
 */

namespace components;


class Request
{
    protected $controller = 'index';
    protected $action = 'index';
    protected $controllerNamespace = 'controllers';

    public function init()
    {
        $url =  $_SERVER['REQUEST_URI'];

        $path = explode('/',$url);

        if(count($path) == 3) {
            $this->controller = $path[1];
            $this->action = $path[2];
        } elseif (count($path) == 2 && !empty($path[1])) {
            $this->controller = $path[1];
        }


        $classController = $this->controllerNamespace . '\\' . ucfirst($this->controller) . 'Controller';

        $action = 'action' . ucfirst($this->action);


        if(class_exists($classController)) {
            $instanceController = new $classController();

            if(method_exists($instanceController,$action)) {
                call_user_func_array([$instanceController,$action],[]);
            } else {
                throw new \Exception('Метод не существует');
            }
        }

    }
}