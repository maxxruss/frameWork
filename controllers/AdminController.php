<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 27.08.2018
 * Time: 16:27
 */

namespace controllers;

use components\Admin;
use components\Controller;
use components\Request;
use models\Goods;

class AdminController extends Controller
{
    public function actionIndex()
    {
        $model = new Goods();
        $dateAnswer = $model->getAllGoods();
        //var_dump($dateAnswer); exit;

        echo $this->render('admin.index', [
            'dateAnswer' => $dateAnswer,
            'auth' => $this->initResult,
            'name' => $_SESSION['user']['name']
        ]);
    }

    public function actionGetAllGoodsAdmin()
    {
        $goodsModel = new Goods();
        return $goodsModel->getAllGoods();
    }

    public function actionSave()
    {


        $admin = new Admin();
        $admin->adminSave();

        $goodsModel = new Goods();

        $dateAnswer = $goodsModel->getAllGoods();

        echo $this->render('admin.index', [
            'dateAnswer' => $dateAnswer,
            'auth' => $this->initResult,
            'name' => $_SESSION['user']['name']
        ]);

    }

    public function actionDelete($id)
    {
        var_dump('ok');
        $goodsModel = new Goods();
        $goodsModel->deleteGood($id);
        $dateAnswer = $goodsModel->getAllGoods();

        echo $this->render('admin.index', [
            'dateAnswer' => $dateAnswer,
            'auth' => $this->initResult,
            'name' => $_SESSION['user']['name']
        ]);
    }
}