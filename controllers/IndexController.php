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
        //d(getallheaders());exit;
        $pdo = Db::getPDO();
        //d($pdo->lastInsertId());exit;

            //setcookie("id_user", '', time() - 3600*24*30*12);
        d($_COOKIE);
        d($_SESSION);exit;
        $model = new Goods();
        $allGoods = $model->getAllGoods();
        //d($_SESSION);exit;

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
        if (($userModel->authWithCredentials())==true) {
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