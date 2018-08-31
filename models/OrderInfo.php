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
    protected $fields = [
        'id',
        'index',
        'name',
        'link',
    ];
    public $rules = [
        'id' => 'int',
        'index' => 'string',
        'link' => 'string',
        'name' => 'string',
    ];

    public $values = [
        'user_name' => '',
        'phone' => '',
        'discountCard' => '',
        'persons' => '',
        'pay' => '0',
        'money' => '',
        'address' => '',
        'comment' => '',
        'delivery' => '0',
        'desiredTime' => '',
        'timeOrder' => '0',

    ];

    function getClientInfo_all()
    {
        $pdo = Db::getPDO();
        //var_dump($pdo);exit;
        $statement = $pdo->query('SELECT * FROM ' . $this->table);
        $result = $statement->fetchAll();
        return $result;

    }

    public function clientInfo_new($values)
    {
        $pdo = DB::getPDO();
        $result = $pdo->exec("INSERT INTO " . $this->table . " (name, phone, discountCard, persons, pay, money, address, comment, delivery, desiredTime, timeOrder) VALUES (" . $values['name'] . "', '" . $values['phone'] . "', '" . $values['discountCard'] . "', '" . $values['persons'] . "', '" . $values['pay'] . "', '" . $values['money'] . "', '" . $values['address'] . "', '" . $values['comment'] . "', '" . $values['delivery'] . "', '" . $values['desiredTime'] . "', '" . $values['timeOrder'] . ")");
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