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
    public $db = null;

    public function __construct()
    {
        $this->request = new Request();
        $this->request->init();
        Auth::init();
        $this->db = new Db();
        $this->db::getPDO();
    }

    public function init() {
    }
}