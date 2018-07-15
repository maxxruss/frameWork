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
        $blogsAll = $blogModel->getBlogs();

        echo $this->render('index', [
            'blogsAll' => $blogsAll
        ]);
    }

    public function actionShow()
    {
        $blogModel = new Blog();
        $blogsOne = $blogModel->getOneBlogs(1);
        echo $this->render('show', [
            'blogsOne' => $blogsOne
        ]);
    }

    public function actionAdd()
    {
        if (isset($_POST['title'])) {
            echo('<pre>');
            //var_dump($_POST);
            echo('</pre>');
            if($_POST['title']!==''&&$_POST['content']!=='') {
                $blogModel = new Blog();
                $blogModel->createBlogs($_POST);
                $blogAdd = 'Блог успешно добавлен!';
                echo $this->render('index', [
                    'blogAdd' => $blogAdd
                ]);
            } else {
                $blogAdd = 'Вы ничего не вели';
                echo $this->render('index', [
                    'blogAdd' => $blogAdd
                ]);
            }
        } else {
            echo $this->render('add', [
                //'blogsOne' => $blogsOne
            ]);
        }
    }

    public function actionEdit()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $blogModel = new Blog();
            $blogsOne = $blogModel->getOneBlogs($id);
            echo $this->render('edit', [
                'blogsOne' => $blogsOne
            ]);
        } else {
            $blogModel = new Blog();
            $blogModel->updateBlogs($_POST);
            $blogEdit = 'Блог успешно изменен!';
            echo $this->render('index', [
                'blogEdit' => $blogEdit
            ]);
        }
    }

    public function actionDelete()
    {
            $id = $_GET['id'];
            $blogModel = new Blog();
            $blogModel->deleteBlogs($id);
            echo $this->render('index', [
                'blogsDelete' => 'Блог успешно удален'
            ]);
    }
}