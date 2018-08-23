<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 23.08.2018
 * Time: 16:23
 */

namespace controllers;

use components\Controller;
use components\Request;
use models\basket;

class BlogController extends Controller
{
    public function actionIndex()
    {
        if ($this->initResult == true) {
            echo('Привет, ' . $_SESSION['user']['login']);
        } else {
            echo " Привет незнакомец! ";
        }
        $blogModel = new basket();
        $blogsAll = $blogModel->getBlogs();
        echo $this->render('blog.index', [
            'blogsAll' => $blogsAll,
            'auth' => $this->initResult,
            'name' => $_SESSION['user']['name']
        ]);
    }
    public function actionShow()
    {
        $blogModel = new basket();
        $blogsOne = $blogModel->getOneBlogs(1);
        echo $this->render('blog.show', [
            'blogsOne' => $blogsOne,
            'auth' => $this->initResult,
            'name' => $_SESSION['user']['name']
        ]);
    }
    public function actionAdd()
    {
        if (isset($_POST['title'])) {
            echo('<pre>');
            //var_dump($_POST);
            echo('</pre>');
            if ($_POST['title'] !== '' && $_POST['content'] !== '') {
                $blogModel = new basket();
                $blogModel->createBlogs($_POST);
                $blogAdd = 'Блог успешно добавлен!';
                echo $this->render('blog.index', [
                    'blogAdd' => $blogAdd,
                    'auth' => $this->initResult,
                    'name' => $_SESSION['user']['name']
                ]);
            } else {
                $blogAdd = 'Вы ничего не вели';
                echo $this->render('blog.index', [
                    'blogAdd' => $blogAdd,
                    'auth' => $this->initResult,
                    'name' => $_SESSION['user']['name']
                ]);
            }
        } else {
            echo $this->render('blog.add', [
                'auth' => $this->initResult,
                'name' => $_SESSION['user']['name']
            ]);
        }
    }
    public function actionEdit()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $blogModel = new basket();
            $blogsOne = $blogModel->getOneBlogs($id);
            echo $this->render('blog.edit', [
                'blogsOne' => $blogsOne,
                'auth' => $this->initResult,
                'name' => $_SESSION['user']['name']
            ]);
        } else {
            $blogModel = new basket();
            $blogModel->updateBlogs($_POST);
            $blogEdit = 'Блог успешно изменен!';
            echo $this->render('blog.index', [
                'blogEdit' => $blogEdit,
                'auth' => $this->initResult,
                'name' => $_SESSION['user']['name']
            ]);
        }
    }
    public function actionDelete()
    {
        $id = $_GET['id'];
        $blogModel = new basket();
        $blogModel->deleteBlogs($id);
        echo $this->render('blog.index', [
            'blogsDelete' => 'Блог успешно удален',
            'auth' => $this->initResult,
            'name' => $_SESSION['user']['name']
        ]);
    }
}