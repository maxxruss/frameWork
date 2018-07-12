<?php
/**
 * Created by PhpStorm.
 * User: alterwalker
 * Date: 21.05.2018
 * Time: 19:53
 */

namespace controllers;

use components\Controller;
use components\Request;
use models\Blog;

class BlogController extends Controller
{
    public function actionIndex()
    {
        $blogModel = new Blog();

        $blogs = $blogModel->getBlogs();

        $this->render('blog/index',$blogs);


    }

    public function actionAdd()
    {
        echo "Блог - добавить блог";
    }

    public function actionShow()
    {
        $blogModel = new Blog();

        $blog = $blogModel->getOneBlog(1);

        $this->render('index',$blog);
    }
}