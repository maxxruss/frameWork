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

    public function actionEnd()
    {
        $modelOrderInfo = new OrderInfo();
        $modelOrderInfo->clientInfo_edit($_POST);
        $_SESSION['user']['order_id'] = '';
        echo $this->render('order_end', [
            'auth' => $this->initResult,
            'name' => $_SESSION['user']['name']
        ]);
    }
}