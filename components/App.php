<?php
/**
 * Created by PhpStorm.
 * User: alterwalker
 * Date: 21.05.2018
 * Time: 19:48
 */

namespace components;



class App
{
    public $request = null;
    public $auth = null;

    public function __construct()
    {
        $this->request = new Request();
        $this->request->init();
        $this->auth = new Auth();
        $this->auth->init();

    }

    public function init() {

    }
}