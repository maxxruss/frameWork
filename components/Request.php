<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 23.08.2018
 * Time: 15:47
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
        //echo 'hi'; exit;
        $url = $_SERVER['REQUEST_URI'];

        //print_r(explode('/', $url));exit;
        if (strpos($url, '?') !== false) {
            $url = $cleanUrl = stristr($url, '?', true);
        }

        $this->inputArr['get'] = $_GET;
        $this->inputArr['post'] = $_POST;

        $path = explode('/', $url);
        print_r($path);


        if (count($path) == 4) {
            $this->controller = $path[2];
            $this->action = $path[3];
        } elseif (count($path) == 3 && !empty($path[2])) {
            $this->controller = $path[2];
        }
        $classController = $this->controllerNamespace . '\\' . ucfirst($this->controller) . 'Controller';
        $action = 'action' . ucfirst($this->action);
        if (class_exists($classController)) {
            $instanceController = new $classController('../templates/', '.tmpl');
            //echo $classController;
            //echo $action;
            if (method_exists($instanceController, $action)) {
                call_user_func_array([$instanceController, $action], [$this]);
            } else {
                throw new \Exception('Метод не существует');
            }
        }
    }

    public function get($key = null)
    {
        if (empty($key)) {
            return $this->inputArr['get'];
        }
        if (isset($this->inpuArr['get'][$key])) {
            return $this->inputArr['get'][$key];
        }
        return null;
    }

    public function post($key = null)
    {
        if (empty($key)) {
            return $this->inputArr['post'];
        }
        if (isset($this->inpuArr['post'][$key])) {
            return $this->inputArr['post'][$key];
        }
        return null;
    }
}