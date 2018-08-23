<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 23.08.2018
 * Time: 16:25
 */

namespace controllers;

use components\Controller;
use components\Request;
use models\Goods;

class OrderToManager extends Controller
{
    public function actionIndex()
    {
        if ($this->initResult==true) {
            echo ('Привет, '.$_SESSION['user']['login']);
        } else {
            echo " Привет незнакомец! ";
        }
        $newsModel = new Goods();
        $newsAll = $newsModel->getNews();
        echo $this->render('news.index', [
            'newsAll' => $newsAll,
            'auth' => $this->initResult,
            'name' => $_SESSION['user']['name']
        ]);
    }
    public function actionShow()
    {
        $newsModel = new Goods();
        $newsOne = $newsModel->getOneNews(1);
        echo $this->render('news.show', [
            'newsOne' => $newsOne,
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
            if($_POST['title']!==''&&$_POST['content']!=='') {
                $newsModel = new Goods();
                $newsModel->createNews($_POST);
                $newsAdd = 'Новость успешно добавлена!';
                echo $this->render('news.index', [
                    'newsAdd' => $newsAdd,
                    'auth' => $this->initResult,
                    'name' => $_SESSION['user']['name']
                ]);
            } else {
                $newsAdd = 'Вы ничего не вели';
                echo $this->render('news.index', [
                    'newsAdd' => $newsAdd,
                    'auth' => $this->initResult,
                    'name' => $_SESSION['user']['name']
                ]);
            }
        } else {
            echo $this->render('news.add', [
                'auth' => $this->initResult,
                'name' => $_SESSION['user']['name']            ]);
        }
    }
    public function actionEdit()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $newsModel = new Goods();
            $newsOne = $newsModel->getOneNews($id);
            echo $this->render('news.edit', [
                'newsOne' => $newsOne,
                'auth' => $this->initResult,
                'name' => $_SESSION['user']['name']
            ]);
        } else {
            $newsModel = new Goods();
            $newsModel->updateNews($_POST);
            $newsEdit = 'Новость успешно изменена!';
            echo $this->render('news.index', [
                'newsEdit' => $newsEdit,
                'auth' => $this->initResult,
                'name' => $_SESSION['user']['name']
            ]);
        }
    }
    public function actionDelete()
    {
        $id = $_GET['id'];
        $newsModel = new Goods();
        $newsModel->deleteNews($id);
        echo $this->render('news.index', [
            'newsDelete' => 'Новость успешно удалена',
            'auth' => $this->initResult,
            'name' => $_SESSION['user']['name']
        ]);
    }
}