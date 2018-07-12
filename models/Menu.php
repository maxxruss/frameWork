<?php
/**
 * Created by PhpStorm.
 * User: alterwalker
 * Date: 24.05.2018
 * Time: 21:11
 */

namespace models;


use components\Model;

class Menu extends Model
{
    protected $table = 'menu';

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