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
    protected $inputArr = [
        'get' => [],
        'post' => [],
    ];

    public function init()
    {
        $url =  $_SERVER['REQUEST_URI'];

        $url = $cleanUrl = stristr($url, '?', true);

        $this->inputArr['get']  = $_GET;
        $this->inputArr['post'] = $_POST;

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
                call_user_func_array([$instanceController,$action],[$this]);
            } else {
                throw new \Exception('Метод не существует');
            }
        }

    }

    public function get($key = null) {
        if(empty($key)) {
            return $this->inputArr['get'];
        }

        if(isset($this->inpuArr['get'][$key])) {
            return $this->inputArr['get'][$key];
        }

        return null;

    }

    public function post($key = null) {
        if(empty($key)) {
            return $this->inputArr['post'];
        }

        if(isset($this->inpuArr['post'][$key])) {
            return $this->inputArr['post'][$key];
        }

        return null;

    }
}