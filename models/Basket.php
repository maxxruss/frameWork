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
        'id'     => 'int',
        'title'  => 'string',
        'content' => 'string'
    ];
//    public function getAllBasket() {
//        return $this->getAll();
//    }
//    public function getOneBasket($id) {
//        return $this->getOne($id);
//    }
//    public function selectBasket($parameters) {
//        return $this->select(($parameters));
//    }

    public function checkGoodToBasket($goodValue) {
        $pdo = Db::getPDO();
        $statement = $pdo->query('select * from ' . $this->table . ' WHERE order_id=' . $goodValue['order_id'] . ' AND good_id=' . $goodValue['good_id']);
        return $statement->fetch();
    }

//    public function getOrderProducts()
//    {
//        $pdo = Db::getPDO();
//        $statement = $pdo->query('select * from ' .$this->table. ' ' . $this->innerJoin . ' ORDER BY order_id');
//        //var_dump($statement);exit;
//        return $statement->fetchAll();
//    }

    function getOrderDetails($order_id)
    {
        $pdo = Db::getPDO();
        //var_dump($pdo);exit;
        $statement = $pdo->query('SELECT * FROM ' . $this->table . ' ' . $this->innerJoin . ' WHERE order_id=' . $order_id);
        $result = $statement->fetchAll();
        return $result;

    }

public function removeGoodFromOrder($order_id)
{
    $pdo = Db::getPDO();
    return $pdo->exec('DELETE FROM ' . $this->table . ' WHERE order_id="' . $order_id . '"');
}


//    public function update($values)
//    {
//        /**if(!$this->validate($values, $this->rules)) {
//         * return false;
//         * }**/
//        $pdo = Db::getPDO();
//        $statement = $pdo->query('UPDATE `' . $this->table . '` SET nameShort = "' . $values['nameShort'] .
//            '", nameFull = ' . $values['nameFull'] . ', price = ' . $values['price'] . ', param = "' . $values['param'] . '", weight = ' . $values['weight'] . ', bigPhoto = "' . $values['bigPhoto'] . '", miniPhoto = "' . $values['miniPhoto'] . '", count = "' . $values['count'] . '", discount = ' . $values['discount'] . ' WHERE `id` = ' . $values['id']);
//        //var_dump($statement);
//        //$result = $statement->fetchAll();
//        //return empty($result[0]) ? null : $result[0];
//        return $statement;
//    }

    public function create($goodValue)
    {
        $pdo = DB::getPDO();
        $pdo->query("INSERT INTO " . $this->table . "(order_id, good_id, count) VALUES ('" . $goodValue['order_id'] . "','" . $goodValue['good_id'] . "','" . $goodValue['count'] . "')");
        return true;
    }

    public function deleteBasket($id) {
        return $this->delete($id);
    }

    public function countBasketPlus($id) {
        return $this->countPlus($id);
    }

    public function countBasketMinus($id) {
        return $this->countMinus($id);
    }

    public function countGoodsOrder($order_id)
    {
        $pdo = Db::getPDO();
        //var_dump($pdo);exit;
        $statement = $pdo->query('SELECT sum(`count`) AS count FROM '. $this->table . ' ' . $this->innerJoin . ' WHERE order_id=' . $order_id);
        $result = $statement->fetchAll();
        return $result[0]['count'];
    }


//    public function goodsBasket_deleteAll()
//    {
//        $pdo = Db::getPDO();
//        $pdo->query("TRUNCATE `basket`");
//        return true;
//    }

    /**public function countGoodsOrder()
    {
        $pdo = Db::getPDO();
        $statement = $pdo->query("SELECT sum(`count`) AS count FROM ". $this->table);
        $result = $statement->fetchAll();
        return $result[0]['count'];
    }*/

//    public function sumGoodsOrder($order_id)
//    {
//        $pdo = Db::getPDO();
//        //var_dump($pdo);exit;
//        $statement = $pdo->query('SELECT sum(`count`*`price`) AS sum FROM ' . $this->table. ' ' . $this->innerJoin . ' WHERE order_id=' . $order_id);
//        $result = $statement->fetchAll();
//        return $result[0]['sum'];
//
//    }

//    public function sumGoodsOrderDiscount($order_id)
//    {
//        $pdo = Db::getPDO();
//        $statement = $pdo->query("SELECT sum(`count`*`price`*(`discount`)/100) AS sumDiscount FROM ". $this->table. ' ' . $this->innerJoin . ' WHERE order_id=' . $order_id);
//        $result = $statement->fetchAll();
//        return floor($result[0]['sumDiscount']);
//    }

//    function countOneGoodsOrder($goodValue)
//    {
//        $pdo = Db::getPDO();
//        $statement = $pdo->query('SELECT `count`  FROM ' . $this->table . ' ' . $this->innerJoin . ' WHERE order_id=' . $goodValue['order_id'] . ' AND good_id=' . $goodValue['good_id']);
//        $result = $statement->fetch();
//        return $result['count'];
//    }

//    public function sumOneGoodsOrder($goodValue)
//    {
//        $pdo = Db::getPDO();
//        $statement = $pdo->query('SELECT sum(`count`*`price`) AS sum FROM '. $this->table.' ' . $this->innerJoin . ' WHERE order_id=' . $goodValue['order_id'] . ' AND good_id=' . $goodValue['good_id']);
//        $result = $statement->fetch();
//        return $result['sum'];
//    }

//    function renderBasketModal()
//    {
//        $pdo = Db::getPDO();
//        $goods = $pdo->query("SELECT * FROM basket order by id");
//        return $goods;
//    }

//    function orderTotalSum()
//    {
//        $pdo = Db::getPDO();
//        $statement = $pdo->query("SELECT sum(`count`*`price`) AS sum FROM ". $this->table);
//        $result = $statement->fetchAll();
//        return $result[0]['sum'];
//    }
}