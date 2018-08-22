<?php
/**
 * Created by PhpStorm.
 * User: alterwalker
 * Date: 21.05.2018
 * Time: 20:48
 */

namespace controllers;


use components\Controller;
use components\Request;
use models\User;

class AuthController extends Controller
{
    public function actionIndex()
    {
        echo $this->render('auth.index', [
            'auth' => $this->initResult,
            'name' => $_SESSION['user']['name']
        ]);
    }

    public function actionLogout()
    {
        $userModel = new User();
        echo $this->render('auth.index', [
            'auth' => $userModel->logOutUser(),
        ]);
    }

    public function actionAuthorization()
    {
        $userModel = new User();
        $checkUserResult = $userModel->checkUser();
        if ($checkUserResult == true) {
            echo $this->render('auth.cabinet', [
                'auth' => $checkUserResult,
                'name' => $_SESSION['user']['name']            ]);
        } else {
            echo $this->render('auth.index', [
                'authResult' => 'Неверный логин или пароль!'
            ]);
        }
    }

    public function actionRegInput()
    {
        echo $this->render('auth.reg', [
        ]);
    }


    public function actionRegCheck()
    {
        $userModel = new User();
        $regUser = $userModel->regUser();
        $userModel->checkUser();
        if ($regUser == true) {
            echo $this->render('auth.cabinet', [
                'auth' => $regUser,
                'reg' => $regUser,
                'name' => $_SESSION['user']['name']
            ]);
        } elseif ($regUser == false) {
            echo $this->render('auth.index', [
                'authResult' => 'Регистрация не прошла!'
            ]);
        } else {
            echo $this->render('auth.index', [
                'authResult' => $regUser
            ]);
        }

    }

    public function actionCabinet()
    {
        echo $this->render('auth.cabinet', [
            'auth' => $this->initResult,
            'name' => $_SESSION['user']['name']
        ]);
    }


}