<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 24.08.2018
 * Time: 21:35
 */

namespace controllers;

use components\Db;
use models\Basket;
use models\Goods;




if (isset($_POST['addBasketid'])||isset($_POST['addToOrderid'])) {
    if (isset($_POST['addBasketid'])) {
        $id = $_POST['addBasketid'];
    };
    if (isset($_POST['addToOrderid'])) {
        $id = $_POST['addToOrderid'];
    };


    //$modelGood = new Goods();
    //$data = $modelGood->getOneGood($id);

   /** $pdo = Db::getPDO();
    //var_dump($pdo);exit;
    $statement = $pdo->query('select * from ' . $this->table . ' where id = ' . $id);
    $result = $statement->fetchAll();
    //var_dump($result);exit;
    //return $result;

    echo ($result);exit;**/


    $nameShort = $data[nameShort];
    $nameFull = $data[nameFull];
    $price = $data[price];
    $param = $data[param];
    $weight = $data[weight];
    $bigPhoto = $data[bigPhoto];
    $miniPhoto = $data[miniPhoto];
    $discount = $data[discount];

    if (isset($_POST['addBasketid'])||isset($_POST['addToOrderid'])) {
        if (isset($_POST['addBasketid'])) {
            $id = $_POST['addBasketid'];
        };
        if (isset($_POST['addToOrderid'])) {
            $id = $_POST['addToOrderid'];
        };
        if (isset($_SESSION['user']['login']) && isset($_SESSION['user']['pass'])) {
            $login = $_SESSION['user']['login'];
        };

        $modelBasket = new Basket();
        $goodBasket = $modelBasket->getOneBasket($id);

        if ($goodBasket) {
            $modelBasket->countBasket($id);
        } else {
            $modelBasket->create($nameShort, $nameFull, $price, $param, $weight, $bigPhoto, $miniPhoto, '1', $discount);
        }

        $countGoodsOrder = countGoodsOrder($connect);
        $sumGoodsOrder = sumGoodsOrder($connect);
        $countOneGoodsOrder = countOneGoodsOrder($connect, $id);
        $sumOneGoodsOrder = sumOneGoodsOrder($connect, $id);
        $orderTotalSum = orderTotalSum($connect);
        $sumGoodsOrderDiscount = sumGoodsOrderDiscount($connect);

        $req = [$countGoodsOrder, $sumGoodsOrder, $countOneGoodsOrder, $sumOneGoodsOrder, $orderTotalSum, $sumGoodsOrderDiscount]; // присваиваем переменной нужные данные
        echo json_encode($req); // возвращаем данные ответом, преобразовав в JSON-строку
        exit; // останавливаем дальнейшее выполнение скрипта
        mysqli_close($connect);
    }
}

if (isset($_POST['deleteToBasketid'])||isset($_POST['deleteToOrderid'])) {

    if (isset($_POST['deleteToBasketid'])) {
        $id = $_POST['deleteToBasketid'];
    };
    if (isset($_POST['deleteToOrderid'])) {
        $id = $_POST['deleteToOrderid'];
    };

    $goodBasket = getOne($connect, $id, 'basket');

    if ($goodBasket['count'] > 1) {
        $sql = "UPDATE `basket` SET `count`= `count`-1 WHERE id=$id";
        $res = mysqli_query($connect, $sql);
    } else {
        $sql = "DELETE FROM `basket` WHERE id=$id";
        $res = mysqli_query($connect, $sql);
    }
    $countGoodsOrder = countGoodsOrder($connect);
    $sumGoodsOrder = sumGoodsOrder($connect);
    $countOneGoodsOrder = countOneGoodsOrder($connect, $id);
    $sumOneGoodsOrder = sumOneGoodsOrder($connect, $id);
    $orderTotalSum = orderTotalSum($connect);
    $sumGoodsOrderDiscount = sumGoodsOrderDiscount($connect);

    $req = [$countGoodsOrder, $sumGoodsOrder, $countOneGoodsOrder, $sumOneGoodsOrder, $orderTotalSum, $sumGoodsOrderDiscount]; // присваиваем переменной нужные данные
    echo json_encode($req); // возвращаем данные ответом, преобразовав в JSON-строку
    exit; // останавливаем дальнейшее выполнение скрипта
    mysqli_close($connect);
}

if (isset($_POST['getBasketGoods'])) {
    $goodBasket = renderBasketModal($connect);
    echo json_encode($goodBasket); // возвращаем данные ответом, преобразовав в JSON-строку
    exit; // останавливаем дальнейшее выполнение скрипта
    mysqli_close($connect);
}

if (isset($_POST['renderOrder'])) {
    $goodBasket = renderBasketModal($connect);
    $clientInfo = getClientInfo_all($connect);
    $result = [$goodBasket, $clientInfo];
    echo json_encode($result); // возвращаем данные ответом, преобразовав в JSON-строку
    exit; // останавливаем дальнейшее выполнение скрипта
    mysqli_close($connect);
}

if (isset($_POST['pay'])) {

    $orderInfo = goodsBasket_all($connect);
    $clientInfo = $_POST;
    $result = [$clientInfo, $orderInfo];

    $timeOrder = time();
    $result = date('H:i', $timeOrder);//переводим в привычный вид
    $resultUnix = strtotime($result);//переводим в UNIX время если необходимо

    $name=$_POST['name'];
    $phone=$_POST['phone'];
    $discountCard=$_POST['discountCard'];
    $persons=$_POST['persons'];
    $pay=$_POST['pay'];
    $money=$_POST['money'];
    $address=$_POST['address'];
    $comment=$_POST['comment'];
    $delivery=$_POST['delivery'];
    $desiredTime=$_POST['desiredTime'];

    clientInfo_edit($connect, $timeOrder, $name, $phone, $discountCard, $persons, $pay, $money, $address, $comment, $delivery, $desiredTime);

    $orderInfo = getClientInfo_all($connect);
    $idClient = $orderInfo[0]['id'];
    $goodsBascket = goodsBasket_all($connect);

    $query = sprintf("TRUNCATE `orderToManager`");
    $result = mysqli_query($connect, $query);

    foreach ($goodsBascket as $good) {
        $idGood = $good['id'];
        $count = $good['count'];
        newOrderToManager ($connect, $idClient, $idGood, $count);
    }
    goodsBasket_deleteAll($connect);


    echo json_encode ($_POST); // возвращаем данные ответом, преобразовав в JSON-строку
    exit; // останавливаем дальнейшее выполнение скрипта
    mysqli_close($connect);

};

	 if (isset($_POST['dbCreateOrder'])) {


         $orderInfo = getClientInfo_all($connect);

         $timeOrder = time();

         if (count($orderInfo)==0) {
             clientInfo_new($connect, $timeOrder, $name, $phone, $discountCard, $persons, $pay, $desiredTime, $money, $address, $comment, $delivery, $desiredTime);
         } else {
             clientInfo_edit($connect, $timeOrder, $name, $phone, $discountCard, $persons, $pay, $desiredTime, $money, $address, $comment, $delivery, $desiredTime);
         };


         $orderInfo = getClientInfo_all($connect);
         $idClient = $orderInfo[0]['id'];
         $goodsBascket = goodsBasket_all($connect);

         $query = sprintf("TRUNCATE `orderToManager`");
         $result = mysqli_query($connect, $query);

         foreach ($goodsBascket as $good) {
             $idGood = $good['id'];
             $count = $good['count'];
             newOrderToManager ($connect, $idClient, $idGood, $count);
         }

         echo json_encode($goodsBascket); // возвращаем данные ответом, преобразовав в JSON-строку
         exit; // останавливаем дальнейшее выполнение скрипта
         mysqli_close($connect);
     };



if (isset($_POST['renderManager'])) {
    $orderFullInfo = getInfoOrderToManager($connect);

    echo json_encode($orderFullInfo); // возвращаем данные ответом, преобразовав в JSON-строку
    exit; // останавливаем дальнейшее выполнение скрипта
    mysqli_close($connect);
};

if (isset($_POST['deliveryCheck'])) {
    $x = $_POST['deliveryCheck'];
    clientInfo_editDelivery($connect,$x);

    echo json_encode($x); // возвращаем данные ответом, преобразовав в JSON-строку
    exit; // останавливаем дальнейшее выполнение скрипта
    mysqli_close($connect);
};

$orderFullInfo = getInfoOrderToManager($connect);
