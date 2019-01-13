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
    protected $innerJoin = 'inner join orderInfo on basket.order_id = orderInfo.id inner join goods on basket.good_id = goods.id';
    protected $fields = [
        'id',
        'order_id',
        'good_id',
        'count',
    ];
    public $rules = [
        'id' => 'int',
        'title' => 'string',
        'content' => 'string'
    ];


    public function checkGoodToBasket($goodValue)
    {
        $pdo = Db::getPDO();
        $statement = $pdo->query('select * from ' . $this->table . ' WHERE order_id=' . $goodValue['order_id'] . ' AND good_id=' . $goodValue['good_id']);
        return $statement->fetch();
    }


    function getOrderDetails($order_id)
    {
        $pdo = Db::getPDO();
        $statement = $pdo->query('SELECT * FROM ' . $this->table . ' ' . $this->innerJoin . ' WHERE order_id=' . $order_id);
        $result = $statement->fetchAll();
        return $result;

    }

    public function removeGoodFromOrder($order_id)
    {
        $pdo = Db::getPDO();
        return $pdo->exec('DELETE FROM ' . $this->table . ' WHERE order_id="' . $order_id . '"');
    }


    public function create($goodValue)
    {
        $pdo = DB::getPDO();
        $pdo->query("INSERT INTO " . $this->table . "(order_id, good_id, count) VALUES ('" . $goodValue['order_id'] . "','" . $goodValue['good_id'] . "','" . $goodValue['count'] . "')");
        return true;
    }

    public function deleteBasket($id)
    {
        return $this->delete($id);
    }

    public function countBasketPlus($id)
    {
        return $this->countPlus($id);
    }

    public function countBasketMinus($id)
    {
        return $this->countMinus($id);
    }

    public function countGoodsOrder($order_id)
    {
        $pdo = Db::getPDO();
        $statement = $pdo->query('SELECT sum(`count`) AS count FROM ' . $this->table . ' ' . $this->innerJoin . ' WHERE order_id=' . $order_id);
        $result = $statement->fetchAll();
        return $result[0]['count'];
    }
}