<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 23.08.2018
 * Time: 16:25
 */

namespace controllers;

use components\Controller;
use models\Goods;
use models\OrderInfo;

class OrderController extends Controller
{
    public function actionIndex()
    {
        echo $this->render('order', [
            'auth' => $this->initResult,
            'name' => $_SESSION['user']['name']
        ]);
    }

    public function actionMakeAnOrder()
    {
        $_SESSION['user']['accepted_order_id'] = $_SESSION['user']['order_id'];
        $modelOrderInfo = new OrderInfo();
        $modelOrderInfo->clientInfo_edit($_POST);
header('location: /order/end');

    }

    public function actionEnd()
    {
        echo $this->render('order_end', [
            'auth' => $this->initResult,
            'name' => $_SESSION['user']['name']
        ]);
    }
}