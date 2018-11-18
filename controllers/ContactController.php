<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 23.08.2018
 * Time: 16:25
 */

namespace controllers;

use components\Controller;


class ContactController extends Controller
{
    public function actionIndex()
    {
        echo $this->render('contact', [
            'auth' => $this->initResult,
            'name' => $_SESSION['user']['name']
        ]);
    }
}