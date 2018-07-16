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
        $userModel = new User();
        if (($userModel->checkUser())==true) {
            echo ($userModel->checkUser());
            echo $this->render('cab.index', [
                'authResult' => 'авторизация пройдена'
            ]);
        } else {
            echo ($userModel->checkUser());
            echo $this->render('cab.index', [
                'authResult' => 'неверный логин или пароль'
            ]);
        }

    }

    public function actionLogout()
    {
        $userModel = new User();
        $userModel->logOut1();
        echo $this->render('cab.logout', [
            'logout' => 'logout'
        ]);
    }

    public function actionAdd()
    {
        if (isset($_POST['title'])) {
            echo('<pre>');
            //var_dump($_POST);
            echo('</pre>');
            if($_POST['title']!==''&&$_POST['content']!=='') {
                $newsModel = new News();
                $newsModel->createNews($_POST);
                $newsAdd = 'Новость успешно добавлена!';
                echo $this->render('index', [
                    'newsAdd' => $newsAdd
                ]);
            } else {
                $newsAdd = 'Вы ничего не вели';
                echo $this->render('index', [
                    'newsAdd' => $newsAdd
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
            $newsModel = new News();
            $newsOne = $newsModel->getOneNews($id);
            echo $this->render('edit', [
                'newsOne' => $newsOne
            ]);
        } else {
            $newsModel = new News();
            $newsModel->updateNews($_POST);
            $newsEdit = 'Новость успешно изменена!';
            echo $this->render('index', [
                'newsEdit' => $newsEdit
            ]);
        }
    }

    public function actionDelete()
    {
        $id = $_GET['id'];
        $newsModel = new News();
        $newsModel->deleteNews($id);
        echo $this->render('index', [
            'newsDelete' => 'Новость успешно удалена'
        ]);
    }
}