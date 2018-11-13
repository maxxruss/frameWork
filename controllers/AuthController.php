<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 23.08.2018
 * Time: 16:22
 */

namespace controllers;

use components\Controller;
use components\Request;
use models\User;

class AuthController extends Controller
{
    public function actionIndex()
    {
        $userModel = new User();
        $this->initResult = $userModel->authWithToken();
        if (!$this->initResult) {
            echo $this->render('auth.index', [
                'auth' => $this->initResult,
//                'name' => $_SESSION['user']['name']
            ]);
        } else {
            $this->actionCabinet();
        }

    }

    public function actionLogout()
    {
        $userModel = new User();
        $this->initResult = $userModel->logOutUser();
        //d($_COOKIE);
        //d($_SESSION);exit;
        echo $this->render('auth.index', [
            'auth' => $this->initResult,
        ]);
    }

    public function actionAuthWithCredentials()
    {
        $userModel = new User();
        $this->initResult = $userModel->authWithCredentials();

        if ($this->initResult) {
        $this->actionCabinet();
        } else {
            echo $this->render('auth.reg', [
                'massage'=> 'Пользователь не найден, пройдите регистрацию'
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
//        $userModel->authWithCredentials();
        if ($regUser === true) {
            echo $this->render('auth.cabinet', [
                'auth' => $regUser,
//                'reg' => $regUser,
                'name' => $_SESSION['user']['name']
            ]);
        } else {
            echo $this->render('auth.reg', [
                'massage' => $regUser
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