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
use models\News;

class NewsController extends Controller
{
    public function actionIndex()
    {
        if ($this->initResult==true) {
            echo ('Привет, '.$_SESSION['user']['login']);
        } else {
            echo " Привет незнакомец! ";
        }
        $newsModel = new News();
        $newsAll = $newsModel->getNews();
        echo $this->render('news.index', [
            'newsAll' => $newsAll,
            'auth' => $this->initResult,
            'name' => $_SESSION['user']['name']
        ]);
    }

    public function actionShow()
    {
        $newsModel = new News();
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
                $newsModel = new News();
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
            $newsModel = new News();
            $newsOne = $newsModel->getOneNews($id);
            echo $this->render('news.edit', [
                'newsOne' => $newsOne,
                'auth' => $this->initResult,
                'name' => $_SESSION['user']['name']
            ]);
        } else {
            $newsModel = new News();
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
        $newsModel = new News();
        $newsModel->deleteNews($id);
        echo $this->render('news.index', [
            'newsDelete' => 'Новость успешно удалена',
            'auth' => $this->initResult,
            'name' => $_SESSION['user']['name']
        ]);
    }
}