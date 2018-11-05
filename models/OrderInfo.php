<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 23.08.2018
 * Time: 16:30
 */

namespace models;

use components\Db;
use components\Model;


class OrderInfo extends Model
{
    protected $table = 'orderInfo';
    protected $innerJoin = 'inner join basket on orderInfo.id = basket.order_id';

    protected $fields = [
        'user_id',
        'id',
        'phone',
        'discountCard',
        'persons',
        'pay',
        'money',
        'address',
        'comment',
        'delivery',
        'desiredTime',
        'timeOrder',
    ];
    public $rules = [
        'user_id' => 'int',
        'phone' => 'string',
        'discountCard' => 'string',
        'persons' => 'string',
        'pay' => 'int',
        'money' => 'string',
        'address' => 'string',
        'comment' => 'string',
        'delivery' => 'int',
        'desiredTime' => 'string',
        'timeOrder' => 'string',
    ];

    public $values = [
        'user_id' => '0',
        'phone' => '0',
        'discountCard' => '0',
        'persons' => '0',
        'pay' => '0',
        'money' => '0',
        'address' => '0',
        'comment' => '0',
        'delivery' => '0',
        'desiredTime' => '0',
        'timeOrder' => '0',

    ];

    function getInfoOrder()
    {
        $pdo = Db::getPDO();
        //var_dump($pdo);exit;
        $statement = $pdo->query('SELECT * FROM ' . $this->table);
        $result = $statement->fetchAll();
        return $result;

    }

    function getOrderId()
    {
        $pdo = Db::getPDO();
        //var_dump($pdo);exit;
        $statement = $pdo->query('SELECT order_id FROM ' . $this->table);
        $result = $statement->fetchAll();
        return $result;

    }


    public function clientInfo_new($values)
    {
        $pdo = DB::getPDO();
        $result = $pdo->exec("INSERT INTO " . $this->table . " (user_id, phone, discountCard, persons, pay, money, address, comment, delivery, desiredTime, timeOrder) VALUES ('" . $values['user_id'] . "', '" . $values['phone'] . "', '" . $values['discountCard'] . "', '" . $values['persons'] . "', '" . $values['pay'] . "', '" . $values['money'] . "', '" . $values['address'] . "', '" . $values['comment'] . "', '" . $values['delivery'] . "', '" . $values['desiredTime'] . "', '" . $values['timeOrder'] . "')");
        return $result;
    }


    public function clientInfo_edit($values)
    {
        //var_dump($values['id']);exit;
        $pdo = DB::getPDO();
        $statement = $pdo->exec('UPDATE ' . $this->table . ' SET user_name = ' . $values['user_name'] . ', phone = ' . $values['phone'] . ', discountCard = ' . $values['discountCard'] . ', persons = ' . $values['persons'] . ', pay = ' . $values['pay'] . ', money = ' . $values['money'] . ', address = ' . $values['address'] . ', comment = ' . $values['comment'] . ', delivery = ' . $values['delivery'] . ', desiredTime = ' . $values['desiredTime'] . ', timeOrder = ' . $values['timeOrder'] . ' WHERE `id` = ' . $values['id']);
        return $statement;
    }

    function clientInfo_editDelivery($delivery)
    {

        $sql = "UPDATE clientInfo SET delivery='%s'";

        $query = sprintf($sql, mysqli_real_escape_string($connect, $delivery));


        $result = mysqli_query($connect, $query);

        if (!$result)
            die(mysqli_error($connect));

        return mysqli_affected_rows($connect);
    }


}