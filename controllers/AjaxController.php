<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 28.08.2018
 * Time: 18:51
 */

namespace controllers;


use components\Db;
use models\Basket;
use models\Goods;

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
        if (isset($_POST['deleteToBasketid'])||isset($_POST['deleteToOrderid'])) {

            if (isset($_POST['deleteToBasketid'])) {
                $id = $_POST['deleteToBasketid'];
            };
            if (isset($_POST['deleteToOrderid'])) {
                $id = $_POST['deleteToOrderid'];
            };

            $modelGood = new Goods();
            $good = $modelGood->getOneGood($id);


            $modelBasket = new Basket();
            $basket = $modelBasket->getOneBasket($id);


            if ($basket[0]['count'] > 1) {
                $modelBasket->countBasketMinus($id);

            } else {
                $modelBasket->deleteBasket($id);

            }
            $countGoodsOrder = $modelBasket->countBasketSum();

            $sumGoodsOrder = $modelBasket->sumGoodsOrder();

            $countOneGoodsOrder = $modelBasket->countOneGoodsOrder($id);

            $sumOneGoodsOrder = $modelBasket->sumOneGoodsOrder($id);

            $orderTotalSum = $modelBasket->orderTotalSum();

            $sumGoodsOrderDiscount = $modelBasket->sumGoodsOrderDiscount();


            $req = [$countGoodsOrder, $sumGoodsOrder, $countOneGoodsOrder, $sumOneGoodsOrder, $orderTotalSum, $sumGoodsOrderDiscount]; // присваиваем переменной нужные данные

            echo json_encode($req); exit;


        }
    }
}