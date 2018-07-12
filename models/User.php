<?php
/**
 * Created by PhpStorm.
 * User: alterwalker
 * Date: 24.05.2018
 * Time: 20:39
 */

namespace models;

use components\Model;

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

    public function getUsers() {
        return $this->getAll();
    }
}