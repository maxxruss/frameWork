<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 23.08.2018
 * Time: 16:24
 */

namespace controllers;

use components\Auth;
use components\Controller;
use components\Db;
use models\Basket;
use models\OrderInfo;
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
    public function actionCabinet()
    {
        $userModel = new User();

        if ($userModel->authWithCredentials()==true) {
            echo $this->render('cab.index', [
                'authResult' => 'авторизация пройдена',
                'auth' => $this->initResult,
                'name' => $_SESSION['user']['name']
            ]);
        } else {
            echo $this->render('index', [
                'authResult' => 'неверный логин или пароль',
                'auth' => $this->initResult,
                'name' => $_SESSION['user']['name']
            ]);
        }
    }
}