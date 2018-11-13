<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 28.08.2018
 * Time: 18:51
 */

namespace controllers;

define("DIR_BIG", "img/");
define("DIR_SMALL", "imgMini/");
define("COLS", 3);

use components\Db;
use components\Model;
use models\Basket;
use models\OrderInfo;
use models\Goods;
use models\OrderProducts1;

class AjaxController
{
    public function actionRenderBasket()
    {
        $modelBasket = new Basket();

        if ($_SESSION['user']['order_id']) {
            $countGoodsOrder = $modelBasket->countGoodsOrder($_SESSION['user']['order_id']);
        } else {
            $countGoodsOrder = false;
        }
        echo json_encode($countGoodsOrder);
        exit;

    }

    public function actionRenderItemModal()
    {
        $modelGood = new Goods();
        $oneGood = $modelGood->getOneGood($_POST['renderItemModal']);
        echo json_encode($oneGood);
        exit;
    }

    public function actionAddToBasket()
    {
        if (isset($_POST['addBasketid'])) {

            $good_id = $_POST['addBasketid'];

            $modelBasket = new Basket();
            $goodValue['good_id'] = $good_id;
            $goodValue['order_id'] = $_SESSION['user']['order_id'];
            $goodValue['discount'] = '0';

            $basketGood = $modelBasket->checkGoodToBasket($goodValue);


            if ($basketGood) {
                $modelBasket->countPlus($basketGood['id']);
            } else {
                $goodValue['count'] = '1';
                $modelBasket->create($goodValue);
            }
//
//            $countGoodsOrder = $modelBasket->countGoodsOrder($goodValue['order_id']); //количество всех товаров в заказе
//            $sumGoodsOrder = $modelBasket->sumGoodsOrder($goodValue['order_id']); // Итого стоимость всех товаров в заказе (количество * цена - складывается по всем товарам)
//            $countOneGoodsOrder = $modelBasket->countOneGoodsOrder($goodValue); // Количество одного товара в заказе по id товара
//            $sumOneGoodsOrder = $modelBasket->sumOneGoodsOrder($goodValue); // Стоимость товара в заказе по id товара (количество * цена)
////            $orderTotalSum = $modelBasket->sumGoodsOrder($goodValue['order_id']);
//            $sumGoodsOrderDiscount = $modelBasket->sumGoodsOrderDiscount($goodValue['order_id']);  // Итого стоимость всех товаров в заказе с учетом скидки
//
//            $req = [$countGoodsOrder, $sumGoodsOrder, $countOneGoodsOrder, $sumOneGoodsOrder, $sumGoodsOrderDiscount]; // присваиваем переменной нужные данные
//            echo json_encode($req);
            exit;
        }

    }

    public function actionDeleteToBasket()
    {
        if (isset($_POST['deleteToBasketid']) || isset($_POST['deleteToOrderid'])) {

            if (isset($_POST['deleteToBasketid'])) {
                $good_id = $_POST['deleteToBasketid'];
            };
            if (isset($_POST['deleteToOrderid'])) {
                $id = $_POST['deleteToOrderid'];
            };

            $modelBasket = new Basket();
            $goodValue['good_id'] = $good_id;
            $goodValue['order_id'] = $_SESSION['user']['order_id'];
            $basketGood = $modelBasket->checkGoodToBasket($goodValue);


            if ($basketGood['count'] > 1) {
                $modelBasket->countBasketMinus($basketGood['id']);
            } elseif ($basketGood['count']==1) {
                $modelBasket->deleteBasket($basketGood['id']);
            }

//            $countGoodsOrder = $modelBasket->countGoodsOrder($goodValue['order_id']);
//            $sumGoodsOrder = $modelBasket->sumGoodsOrder($goodValue['order_id']);
//            $countOneGoodsOrder = $modelBasket->countOneGoodsOrder($basketGood['id']);
//            $sumOneGoodsOrder = $modelBasket->sumOneGoodsOrder($basketGood['id']);
//            $orderTotalSum = $modelBasket->sumGoodsOrder($goodValue['order_id']);
//            $sumGoodsOrderDiscount = $modelBasket->sumGoodsOrderDiscount($goodValue['order_id']);


//            $req = [$countGoodsOrder, $sumGoodsOrder, $countOneGoodsOrder, $sumOneGoodsOrder, $orderTotalSum, $sumGoodsOrderDiscount]; // присваиваем переменной нужные данные

//            echo json_encode();
            exit;
        }
    }

    public function actionRenderBasketModal()
    {
        $modelBasket = new Basket();
        $basket = $modelBasket->getOrderDetails($_SESSION['user']['order_id']);

        echo json_encode($basket);
        exit;
    }

    public function actionEditGood()
    {
        $modelGood = new Goods();
        $modelGood->editGood();
    }

    public function actionDeliveryCheck()
    {
        $modelOrderInfo = new OrderInfo();

        echo json_encode($modelOrderInfo->orderEditDelivery($_POST['deliveryCheck']));
        exit;
    }

    public function actionCompleteOrder()
    {
        $modelOrderInfo = new OrderInfo();

        echo json_encode($modelOrderInfo->completeOrder($_POST['completeOrder']));
        exit;
    }

    public function actionOrderEnd()
    {
        $modelBasket = new Basket();
        $basketDetails = $modelBasket->getOrderDetails($_SESSION['user']['order_id']);


        echo json_encode($basketDetails); // возвращаем данные ответом, преобразовав в JSON-строку
        exit; // останавливаем дальнейшее выполнение скрипта
    }

    public function actionRenderAdminAjax()
    {
        $modelGood = new Goods();
        $goods = $modelGood->getAllGoods();

        echo json_encode($goods);
        exit;
    }

    public function actionDeleteGood()
    {
        $id = $_POST['deleteGoodid'];
        $goodsModel = new Goods();
        $result = $goodsModel->deleteGood($id);
        echo json_encode($result);
        exit;
    }

    public function actionScanDirLoadFiles()
    {
        $model = new Goods();
        $result = $model->load();
        echo json_encode($result);
        exit;
    }

    public function actionAddNewGood()
    {
        $arr = [];
        $arr['nameShort'] = '';
        $arr['nameFull'] = '';
        $arr['price'] = '0';
        $arr['param'] = '';
        $arr['weight'] = '';
        $arr['discount'] = '0';
        $arr['stickerFit'] = '0';
        $arr['stickerHit'] = '0';
        $arr['bigPhoto'] = '';
        $arr['miniPhoto'] = '';
        $model = new Goods();
        $result = $model->create($arr);
        echo json_encode($result);
        exit;
    }

    public function actionRenderManager()
    {
        $modelOrderInfo = new OrderInfo();
        $infoOrder = $modelOrderInfo->getInfoOrder();

        echo json_encode($infoOrder); // возвращаем данные ответом, преобразовав в JSON-строку
        exit; // останавливаем дальнейшее выполнение скрипта
    }

    public function actionOrderDetails()
    {

        $modelBasket = new Basket();
        $orderDetails = $modelBasket->getOrderDetails($_POST['orderDetails']);

        echo json_encode($orderDetails); // возвращаем данные ответом, преобразовав в JSON-строку
        exit; // останавливаем дальнейшее выполнение скрипта
    }

    public function actionRenderOrder()
    {
        $modelBasket = new Basket();
        $basketDetails = $modelBasket->getOrderDetails($_SESSION['user']['order_id']);



        echo json_encode($basketDetails); // возвращаем данные ответом, преобразовав в JSON-строку
        exit; // останавливаем дальнейшее выполнение скрипта
    }

//    public function actionDbCreateOrder()
//    {
//        $model = new OrderInfo();
//        $orderInfo = $model->getClientInfo_all();
//
//        $model->values['timeOrder'] = time();
//
//
//        if (count($orderInfo) == 0) {
//            $model->clientInfo_new($model->values);
//        } else {
//            $model->clientInfo_edit($model->values);
//        };
//
//        $orderInfo = $model->getClientInfo_all();
//        $idClient = $orderInfo['id'];
//        $modelBasket = new Basket();
//        $goodsBasket = $modelBasket->getAllBasket();
//
//        $modelOrder = new OrderProducts1();
//        $modelOrder->truncateOrder();
//
//        foreach ($goodsBasket as $good) {
//            $idGood = $good['id'];
//            $count = $good['count'];
//            $modelOrder->newOrderToManager($idClient, $idGood, $count);
//        }
//
//        echo json_encode($goodsBasket); // возвращаем данные ответом, преобразовав в JSON-строку
//        exit; // останавливаем дальнейшее выполнение скрипта
//
//    }
}