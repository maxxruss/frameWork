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
    public function countBasketPlus($id) {
        return $this->countPlus($id);
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