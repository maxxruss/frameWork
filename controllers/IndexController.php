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
use models\News;

class IndexController extends Controller
{
    public function actionIndex()
    {
        if(Auth::check()) {
            echo " Привет зарегистрированный пользователь! ";
        }

        $newsModel = new News();
        $oneNews = $newsModel->getOneNews(1);

        $blogModel = new Blog();
        $blog = $blogModel->getBlog(2);

        $this->render('Главный шаблон ', [
            'blog' => $blog,
            'oneNews' => $oneNews,
        ]);
    }
}