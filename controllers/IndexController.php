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
use models\Basket;
use models\ClientInfo;
use models\Goods;
use models\User;

class IndexController extends Controller
{
    public function actionIndex()
    {
        $model = new Goods();
        $allGoods = $model->getAllGoods();
        //var_dump($allGoods); exit;


        echo $this->render('index', [
            'allGoods' => $allGoods,
            'auth' => $this->initResult,
            'name' => $_SESSION['user']['name']
        ]);
    }
    public function actionCabinet()
    {
        echo 'привет из кабинета';
        $userModel = new User();
        if (($userModel->checkUser())==true) {
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