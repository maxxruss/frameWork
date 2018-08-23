<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 23.08.2018
 * Time: 16:30
 */

namespace models;

use components\Model;


class ClientInfo extends Model
{
    protected $table = 'clientInfo';
    protected $fields = [
        'id',
        'index',
        'name',
        'link' ,
    ];
    public $rules = [
        'id'     => 'int',
        'index'  => 'string',
        'link' => 'string',
        'name'   => 'string',
    ];
}