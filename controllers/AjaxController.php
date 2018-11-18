<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 28.08.2018
 * Time: 18:51
 */

namespace controllers;

use components\Controller;
use models\Basket;
use models\OrderInfo;
use models\Goods;

class AjaxController extends Controller
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
            } elseif ($basketGood['count'] == 1) {
                $modelBasket->deleteBasket($basketGood['id']);
            }
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

        if ($modelOrderInfo->completeOrder($_POST['completeOrder'])) {
            $modelBasket = new Basket();
            $modelBasket->removeGoodFromOrder($_POST['completeOrder']);
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
        exit;
    }

    public function actionOrderEnd()
    {
        if ($_SESSION['user']['accepted_order_id']) {

            $modelBasket = new Basket();
            $basketDetails = $modelBasket->getOrderDetails($_SESSION['user']['accepted_order_id']);

            echo json_encode($basketDetails);
            exit;
        }
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
        echo json_encode($infoOrder);
        exit;
    }

    public function actionOrderDetails()
    {

        $modelBasket = new Basket();
        $orderDetails = $modelBasket->getOrderDetails($_POST['orderDetails']);
        echo json_encode($orderDetails);
        exit;
    }

    public function actionRenderOrder()
    {
        $modelBasket = new Basket();
        $basketDetails = $modelBasket->getOrderDetails($_SESSION['user']['order_id']);
        echo json_encode($basketDetails);
        exit;
    }
}