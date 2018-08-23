<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 23.08.2018
 * Time: 16:26
 */

namespace models;

use components\Model;


class OrderToManager extends Model
{
    protected $table = 'orderToManager';
    protected $fields = [
        'id',
        'title',
        'content'
    ];
    public $rules = [
        'id'     => 'int',
        'title'  => 'string',
        'content' => 'string'
    ];
    public function getAllOrders() {
        return $this->getAll();
    }
    public function getOneOrder($id) {
        return $this->getOne($id);
    }
    public function selectOrder($parameters) {
        return $this->select(($parameters));
    }
    public function createOrder($values) {
        return $this->create($values);
    }
    public function updateOrder($values) {
        return $this->update($values);
    }
    public function deleteOrder($id) {
        return $this->delete($id);
    }
}