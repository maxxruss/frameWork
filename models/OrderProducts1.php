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


class OrderProducts1 extends Model
{
    protected $table = 'order_Products';
    protected $innerJoin = 'inner join orderInfo on id_order.id_order = orderInfo.id 
    inner join id_good on order_Products.id_goods = goods.id';
    protected $fields = [
        'id',
        'id_order',
        'id_good'
    ];
    public $rules = [
        'id'     => 'int',
        'id_order'  => 'int',
        'id_good' => 'int'
    ];



    public function getInfoOrderToManager() {
        return $this->getInfoOrder();
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

    public function truncateOrder() {
        return $this->truncate();
    }

    public function newOrderToManager($idClient, $idGood, $count) {
        return $this->newOrder($idClient, $idGood, $count);
    }



    public function getAllBasket() {
        $pdo = Db::getPDO();
        $statement = $pdo->query('select * from ' . $this->table . ' inner join  order by ');
        //var_dump($statement);exit;
        return $statement->fetchAll();
    }

    public function getOneBasket($id)
    {
        $pdo = Db::getPDO();
        $statement = $pdo->query('select * from ' . $this->table . ' where id_goods = ' . $id);
        $result = $statement->fetchAll();
        //var_dump($result);exit;
        return $result;

        return $this->getOne($id);
    }
    public function selectBasket($parameters) {
        return $this->select(($parameters));
    }

    public function update($values)
    {
        /**if(!$this->validate($values, $this->rules)) {
         * return false;
         * }**/
        $pdo = Db::getPDO();
        $statement = $pdo->query('UPDATE `' . $this->table . '` SET nameShort = "' . $values['nameShort'] .
            '", nameFull = ' . $values['nameFull'] . ', price = ' . $values['price'] . ', param = "' . $values['param'] . '", weight = ' . $values['weight'] . ', bigPhoto = "' . $values['bigPhoto'] . '", miniPhoto = "' . $values['miniPhoto'] . '", count = "' . $values['count'] . '", discount = ' . $values['discount'] . ' WHERE `id` = ' . $values['id']);
        //var_dump($statement);
        //$result = $statement->fetchAll();
        //return empty($result[0]) ? null : $result[0];
        return $statement;
    }

    public function create($values)
    {
        $pdo = DB::getPDO();
        $pdo->query("INSERT INTO " . $this->table . "(id, nameShort, nameFull, price, param, weight, bigPhoto, miniPhoto, count, discount) VALUES ('" . $values['id'] . "','" . $values['nameShort'] . "', '" . $values['nameFull'] . "', '" . $values['price'] . "', '" . $values['param'] . "', '" . $values['weight'] . "', '" . $values['bigPhoto'] . "', '" . $values['miniPhoto'] . "', '" . $values['count'] . "', '" . $values['discount'] . "')");
        return true;
    }

    public function deleteBasket($id) {
        return $this->delete($id);
    }


    public function countBasketMinus($id) {
        return $this->countMinus($id);
    }

    public function countBasketSum()
    {
        $pdo = Db::getPDO();
        //var_dump($pdo);exit;
        $statement = $pdo->query('SELECT sum(`count`) AS count FROM '. $this->table );
        $result = $statement->fetchAll();
        return $result[0]['count'];
    }


    public function goodsBasket_deleteAll()
    {
        $pdo = Db::getPDO();
        $pdo->query("TRUNCATE `basket`");
        return true;
    }

    public function countGoodsOrder()
    {
        $pdo = Db::getPDO();
        $statement = $pdo->query("SELECT sum(`count`) AS count FROM ". $this->table);
        $result = $statement->fetchAll();
        return $result[0]['count'];
    }

    public function sumGoodsOrder()
    {
        $pdo = Db::getPDO();
        //var_dump($pdo);exit;
        $statement = $pdo->query('SELECT sum(`count`*`price`) AS sum FROM ' . $this->table);
        $result = $statement->fetchAll();
        return $result[0]['sum'];

    }

    public function sumGoodsOrderDiscount()
    {
        $pdo = Db::getPDO();
        $statement = $pdo->query("SELECT sum(`count`*`price`*(100-`discount`)/100) AS sumDiscount FROM ". $this->table);
        $result = $statement->fetchAll();
        return floor($result[0]['sumDiscount']);
    }

    function countOneGoodsOrder($id)
    {
        $pdo = Db::getPDO();
        $statement = $pdo->query("SELECT `count`  FROM `". $this->table."` WHERE id=".(int)$id);
        $result = $statement->fetch();
        return $result['count'];
    }

    public function sumOneGoodsOrder($id)
    {
        $pdo = Db::getPDO();
        $statement = $pdo->query("SELECT sum(`count`*`price`) AS sum FROM `". $this->table."` WHERE id=".(int)$id);
        $result = $statement->fetch();
        return $result['sum'];
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
        $statement = $pdo->query("SELECT sum(`count`*`price`) AS sum FROM ". $this->table);
        $result = $statement->fetchAll();
        return $result[0]['sum'];
    }
}