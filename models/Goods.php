<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 23.08.2018
 * Time: 16:27
 */

namespace models;

use components\Model;


class Goods extends Model
{
    protected $table = 'goods';
    protected $fields = [
        'id',
        'title',
        'content'
    ];
    public $rules = [
        'id' => 'int',
        'title' => 'string',
        'content' => 'string'
    ];

    public function getAllGoods()
    {
        return $this->getAll();
    }

    public function getOneGood($id)
    {
        return $this->getOne($id);
    }

    public function deleteGood($id)
    {
        return $this->delete($id);
    }

    public function editGood()
    {
        return $this->edit();
    }

    public function load()
    {
        return $this->scanDirLoadFiles();
    }
}