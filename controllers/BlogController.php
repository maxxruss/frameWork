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
        echo "blogs - показать blogs";
        $blogModel = new Blog();
        $blogsAll = $blogModel->getBlogs();
        print_r($blogsAll);

        echo $this->render('index', [
            'blogsAll' => $blogsAll
        ]);
    }

    public function actionShow()
    {
        echo "blogs - показать 1 blogs";
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
        $id = $_GET['id'];

        if ($id>0) {
            $blogModel = new Blog();
            $blogsOne = $blogModel->getOneBlogs($id);
            echo $this->render('edit', [
                'blogsOne' => $blogsOne
            ]);
        } else {
            $blogModel = new Blog();
            $blogModel->updateBlogs($id, $_POST);
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