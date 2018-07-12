<?php
/**
 * Created by PhpStorm.
 * User: alterwalker
 * Date: 21.05.2018
 * Time: 20:48
 */

namespace controllers;


use components\Controller;
use models\News;

class NewsController extends Controller
{
    public function actionIndex ()
    {
        $newsModel = new News();

        $news = $newsModel->getNews();

        $this->render('index', $news);
    }
}