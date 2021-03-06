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

    public function initUserOrder()
    {
        $user_id = $_SESSION['user']['token'];
        $pdo = Db::getPDO();
        $statement = $pdo->query('select * from ' . $this->table . ' where user_id = "' . $user_id . '" AND order_status = 0');
        $orderInfo = $statement->fetch();

        if ($orderInfo) {
            $_SESSION['user']['order_id'] = $orderInfo['id'];
            return true;
        } else {
            $this->createOrder($_SESSION['user']['token']);
            return false;
        }
    }


    function getInfoOrder()
    {
        $pdo = Db::getPDO();
        $statement = $pdo->query('SELECT * FROM ' . $this->table);
        $result = $statement->fetchAll();
        return $result;

    }

    function completeOrder($order_id)
    {
        $pdo = Db::getPDO();
        $statement = $pdo->exec('UPDATE ' . $this->table . ' SET order_status = 2 WHERE id = ' . $order_id);
        return $statement;

    }

    public function createOrder($user_id)
    {
        $pdo = DB::getPDO();
        $result = $pdo->exec('INSERT INTO ' . $this->table . ' (user_id) VALUES ("' . $user_id . '")');

        if ($result) {
            $_SESSION['user']['order_id'] = $pdo->lastInsertId();
        };
        return $result;
    }


    public function clientInfo_edit($values)
    {
        $pdo = DB::getPDO();
        $statement = $pdo->exec('UPDATE ' . $this->table . ' SET name = "' . $values['name'] . '", phone = "' . $values['phone'] . '", discountCard = "' . $values['discountCard'] . '", persons = "' . $values['persons'] . '", pay = ' . $values['pay'] . ', money = "' . $values['money'] . '", address = "' . $values['address'] . '", comment = "' . $values['comment'] . '", delivery = ' . $values['delivery'] . ', desiredTime = "' . $values['desiredTime'] . '", timeOrder = ' . time() . ', order_status =  1  WHERE `id` = ' . $_SESSION['user']['order_id']);
        return $statement;
    }

    function orderEditDelivery($mark)
    {
        $pdo = DB::getPDO();
        $statement = $pdo->exec('UPDATE ' . $this->table . '  SET delivery=' . $mark . ' WHERE id=' . $_SESSION['user']['order_id']);
        return $statement;
    }
}