<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 23.08.2018
 * Time: 15:34
 */

namespace components;
use components\Db;

class App
{
    public $request = null;
    public $auth = null;
    public $db = null;

    public function __construct()
    {
        $this->request = new Request();
        $this->request->init();
        //Auth::init();
        exit;
        $this->db = new Db();
        $this->db->getPDO();
    }

    public function init() {

    }
}