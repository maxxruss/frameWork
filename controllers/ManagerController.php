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
use models\OrderToManager;

class ManagerController extends Controller
{
    public function actionIndex()
    {
        echo $this->render('manager.index', [
            'auth' => $this->initResult,
            'name' => $_SESSION['user']['name']
        ]);
    }

    public function actionOrder()
    {
        echo $this->render('manager.order', [
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