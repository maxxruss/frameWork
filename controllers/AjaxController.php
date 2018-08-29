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
use models\Goods;
use models\OrderToManager;

class AjaxController
{
    public function actionAddToBasket()
    {
        if (isset($_POST['addBasketid']) || isset($_POST['addToOrderid'])) {
            if (isset($_POST['addBasketid'])) {
                $id = $_POST['addBasketid'];
            };
            if (isset($_POST['addToOrderid'])) {
                $id = $_POST['addToOrderid'];
            };

            $modelGood = new Goods();
            $good = $modelGood->getOneGood($id);


            $modelBasket = new Basket();
            $basket = $modelBasket->getOneBasket($id);

            if ($basket) {
                $modelBasket->countBasketPlus($id);
            } else {
                $good[0]['count'] = '1';
                $modelBasket->create($good[0]);
            }

            $countGoodsOrder = $modelBasket->countBasketSum();
            $sumGoodsOrder = $modelBasket->sumGoodsOrder();
            $countOneGoodsOrder = $modelBasket->countOneGoodsOrder($id);
            $sumOneGoodsOrder = $modelBasket->sumOneGoodsOrder($id);
            $orderTotalSum = $modelBasket->orderTotalSum();
            $sumGoodsOrderDiscount = $modelBasket->sumGoodsOrderDiscount();

            $req = [$countGoodsOrder, $sumGoodsOrder, $countOneGoodsOrder, $sumOneGoodsOrder, $orderTotalSum, $sumGoodsOrderDiscount]; // присваиваем переменной нужные данные
            echo json_encode($req);
            exit;
        }

    }

    public function actionDeleteToBasket()
    {
        if (isset($_POST['deleteToBasketid']) || isset($_POST['deleteToOrderid'])) {

            if (isset($_POST['deleteToBasketid'])) {
                $id = $_POST['deleteToBasketid'];
            };
            if (isset($_POST['deleteToOrderid'])) {
                $id = $_POST['deleteToOrderid'];
            };

            $modelBasket = new Basket();
            $basket = $modelBasket->getOneBasket($id);


            if ($basket[0]['count'] > 1) {
                $modelBasket->countBasketMinus($id);
            } elseif ($basket[0]['count'] == 1) {
                $modelBasket->deleteBasket($id);
            }

            $countGoodsOrder = $modelBasket->countBasketSum();
            $sumGoodsOrder = $modelBasket->sumGoodsOrder();
            $countOneGoodsOrder = $modelBasket->countOneGoodsOrder($id);
            $sumOneGoodsOrder = $modelBasket->sumOneGoodsOrder($id);
            $orderTotalSum = $modelBasket->orderTotalSum();
            $sumGoodsOrderDiscount = $modelBasket->sumGoodsOrderDiscount();


            $req = [$countGoodsOrder, $sumGoodsOrder, $countOneGoodsOrder, $sumOneGoodsOrder, $orderTotalSum, $sumGoodsOrderDiscount]; // присваиваем переменной нужные данные

            echo json_encode($req);
            exit;
        }
    }

    public function actionRenderBasketModal()
    {
        $modelBasket = new Basket();
        $basket = $modelBasket->getAllBasket();

        echo json_encode($basket);
        exit;
    }

    public function actionEditGood()
    {
        $modelGood = new Goods();
        $modelGood->editGood();
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
        $model = new OrderToManager();
        $orderFullInfo = $model->getInfoOrderToManager();

        echo json_encode($orderFullInfo); // возвращаем данные ответом, преобразовав в JSON-строку
        exit; // останавливаем дальнейшее выполнение скрипта
    }

    public function actionDbCreateOrder()
    {
        $orderInfo = getClientInfo_all();

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
    }
}