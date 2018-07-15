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
        if(Auth::check()==true) {
            echo " Привет зарегистрированный пользователь! ";
        } else {
            echo " Привет незнакомец! ";
        }

        $newsModel = new News();
        $oneNews = $newsModel->getOneNews(1);

        $blogModel = new Blog();
        $oneBlog = $blogModel->getOneBlogs(6);

        echo $this->render('index', [
            'oneBlog' => $oneBlog,
            'oneNews' => $oneNews,
        ]);
    }
}