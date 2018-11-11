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
        //var_dump($url);exit;

        if (strpos($url, '?') !== false) {
            $url = $cleanUrl = stristr($url, '?', true);
        }

        $this->inputArr['get']  = $_GET;
        $this->inputArr['post'] = $_POST;



        $path = explode('/',$url);
        //var_dump($path);exit;

//        if(count($path) == 4) {
//            $this->controller = $path[2];
//            $this->action = $path[3];
//        } elseif (count($path) == 3 && !empty($path[2])) {
//            $this->controller = $path[2];
//        }

        if (count($path) == 3 && !empty($path[2])) {
            $this->controller = $path[2];
        } else  {
            $this->controller = $path[count($path)-2];
            $this->action = $path[count($path)-1];
        }


        $classController = $this->controllerNamespace . '\\' . ucfirst($this->controller) . 'Controller';

        if (strpos($this->action, '=') !== false) {
            $actionArr = explode('=', $this->action);

            //print_r($actionArr[1]);
            $this->action = $actionArr[0];
            $get = $actionArr[1];
            //var_dump($this->action);
        }

        $action = 'action' . ucfirst($this->action);

        if(class_exists($classController)) {
            $instanceController = new $classController('../templates/', '.tmpl');


            if(method_exists($instanceController,$action)) {
                call_user_func_array([$instanceController,$action],[$get]);
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
            return $_POST;
        }

        if(isset($_POST[$key])) {
            return $_POST[$key];
        }

        return null;

    }
}