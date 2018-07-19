<?php
/**
 * Created by PhpStorm.
 * User: alterwalker
 * Date: 21.05.2018
 * Time: 19:53
 */

namespace controllers;


use components\Auth;
use components\Controller;
use models\Blog;
use models\Menu;
use models\News;
use models\User;

class IndexController extends Controller
{
    public function actionIndex()
    {
        $newsModel = new News();
        $oneNews = $newsModel->getOneNews(1);

        $blogModel = new Blog();
        $oneBlog = $blogModel->getOneBlogs(6);

        echo $this->render('index', [
            'oneBlog' => $oneBlog,
            'oneNews' => $oneNews,
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