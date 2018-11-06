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

class EndController extends Controller
{
    public function actionIndex()
    {
        $modelOrderInfo = new OrderInfo();
        $modelOrderInfo->clientInfo_edit($_POST);
        echo $this->render('order_end', [
            'auth' => $this->initResult,
            'name' => $_SESSION['user']['name']
        ]);
    }
}