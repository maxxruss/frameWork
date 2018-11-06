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

class OrderController extends Controller
{
    public function actionIndex()
    {
        echo $this->render('order', [
            'auth' => $this->initResult,
            'name' => $_SESSION['user']['name']
        ]);
    }

    public function actionFinish()
    {
        echo $this->render('order', [
            'auth' => $this->initResult,
            'name' => $_SESSION['user']['name']
        ]);
    }

}