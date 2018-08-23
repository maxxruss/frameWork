<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 23.08.2018
 * Time: 16:26
 */

namespace models;

use components\Db;
use components\Model;


class Basket extends Model
{
    protected $table = 'basket';
    protected $fields = [
        'id',
        'nameShort',
        'nameFull',
        'price',
        'param',
        'weight',
        'bigPhoto',
        'miniPhoto',
        'count',
        'discount',
    ];
    public $rules = [
        'id'     => 'int',
        'title'  => 'string',
        'content' => 'string'
    ];
    public function getAllBasket() {
        return $this->getAll();
    }
    public function getOneBasket($id) {
        return $this->getOne($id);
    }
    public function selectBasket($parameters) {
        return $this->select(($parameters));
    }
    public function createBasket($values) {
        return $this->create($values);
    }
    public function updateBasket($values) {
        return $this->update($values);
    }
    public function deleteBasket($id) {
        return $this->delete($id);
    }
    public function goodsBasket_deleteAll()
    {
        $pdo = Db::getPDO();
        $pdo->query("TRUNCATE `basket`");
        return true;
    }

    function countGoodsOrder()
    {
        $pdo = Db::getPDO();
        $countOrder = $pdo->query("SELECT sum(`count`) AS count FROM `basket`");
        return $countOrder['count'];
    }

    function sumGoodsOrder()
    {
        $pdo = Db::getPDO();
        $sumOrder = $pdo->query("SELECT sum(`count`*`price`) AS sum FROM `basket`");
        return $sumOrder['sum'];
    }

    function sumGoodsOrderDiscount()
    {
        $pdo = Db::getPDO();
        $sumOrder = $pdo->query("SELECT sum(`count`*`price`*(100-`discount`)/100) AS sumDiscount FROM `basket`");
        return floor($sumOrder['sumDiscount']);
    }

    function countOneGoodsOrder($id)
    {
        $pdo = Db::getPDO();
        $countOneOrder = $pdo->query("SELECT `count`  FROM `basket` WHERE id='%d'", (int)$id);
        return $countOneOrder['count'];
    }

    function sumOneGoodsOrder($id)
    {
        $pdo = Db::getPDO();
        $sumOneOrder = $pdo->query("SELECT sum(`count`*`price`) AS sum FROM `basket` WHERE id='%d'", (int)$id, (int)$id);
        return $sumOneOrder['sum'];
    }

    function renderBasketModal()
    {
        $pdo = Db::getPDO();
        $goods = $pdo->query("SELECT * FROM basket order by id");
        return $goods;
    }

    function orderTotalSum()
    {
        $pdo = Db::getPDO();
        $orderTotalSum = $pdo->query("SELECT sum(`count`*`price`) AS sum FROM `basket`");
        return $orderTotalSum['sum'];
    }
}