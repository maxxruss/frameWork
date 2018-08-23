<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 23.08.2018
 * Time: 16:28
 */

namespace models;

use components\Model;
use components\Auth;

class User extends Model
{
    protected $table = 'users';
    protected $fields = [
        'id',
        'login',
        'passwd',
        'name' ,
        'email',
        'date' ,
    ];
    public $rules = [
        'id'     => 'int',
        'login'  => 'string',
        'passwd' => 'string',
        'name'   => 'string',
        'email'  => 'string',
        'date'   => 'string',
    ];
    public function getAllUsers() {
        return $this->getAll();
    }
    public function checkUser() {
        $check = new Auth();
        return $check->check();
    }
    public function initUser() {
        $check = new Auth();
        return $check->init();
    }
    public function logOutUser() {
        $modelAuth = new Auth();
        $modelAuth->logOut();
        return $modelAuth->init();
    }
    public function regUser() {
        $logout = new Auth();
        return $logout->reg();
    }
}