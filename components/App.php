<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 23.08.2018
 * Time: 15:34
 */

namespace components;
use components\Db;
use models\User;

class App
{
    public $request = null;
    public $user = null;
    public $db = null;

    public function __construct()
    {
        $this->db = new Db();
        $this->db->getPDO();
        //$this->user = new User();
        //$this->user->checkAuthWithCookie();
        //$this->user->init();
        $this->request = new Request();
        $this->request->init();
//        $modelUser = new User();
//        $modelUser->initToken();

    }

    public function init() {

    }
}