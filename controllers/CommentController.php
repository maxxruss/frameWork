<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 23.08.2018
 * Time: 16:25
 */

namespace controllers;

use components\Controller;
use models\Comment;


class CommentController extends Controller
{
    public function actionIndex()
    {
        $modelComment = new Comment();
        echo $this->render('guestbook', [
            'auth' => $this->initResult,
            'name' => $_SESSION['user']['name'],
            'comments' => $modelComment->getFirst5Comments()
        ]);
    }

    public function actionAdd()
    {
        $modelComment = new Comment();
        $modelComment->createComment();
        header('location: /comment');

    }


}