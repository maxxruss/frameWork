<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 23.08.2018
 * Time: 16:24
 */

namespace controllers;

use components\Controller;
use models\Goods;
use models\User;

class IndexController extends Controller
{
    public function actionIndex()
    {
        $model = new Goods();
        $allGoods = $model->getAllGoods();

        echo $this->render('index', [
            'allGoods' => $allGoods,
            'auth' => $this->initResult,
            'name' => $_SESSION['user']['name']
        ]);
    }


    public function actionAdmin()
    {
        $model = new Goods();
        $dateAnswer = $model->getAllGoods();

        echo $this->render('admin.index', [
            'dateAnswer' => $dateAnswer,
            'auth' => $this->initResult,
            'name' => $_SESSION['user']['name']
        ]);
    }

    public function actionManager()
    {
        echo $this->render('manager.index', [
            'auth' => $this->initResult,
            'name' => $_SESSION['user']['name']
        ]);
    }
}