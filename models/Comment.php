<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 23.08.2018
 * Time: 16:30
 */

namespace models;

use components\Db;
use components\Model;


class Comment extends Model
{
    protected $table = 'comment';

    function getCommentByToken()
    {
        $pdo = Db::getPDO();
        $statement = $pdo->query('SELECT * FROM ' . $this->table . ' WHERE token=' . $_SESSION['user']['token']);
        $result = $statement->fetchAll();
        return $result;

    }

    function getExampleComment()
    {
        $pdo = Db::getPDO();
        $statement = $pdo->query('SELECT * FROM ' . $this->table . ' LIMIT 5');
        $result = $statement->fetchAll();
        return $result;

    }

    function createComment()
    {
        $pdo = Db::getPDO();
        $statement = $pdo->query('INSERT INTO ' . $this->table . '(token, name, email, comment) 
        VALUES ("'. $_SESSION['user']['token'] . '", "' . $_POST['name'] . '", "' . $_POST['email'] . '", "' . $_POST['comment'] .'")');
        return $statement;
    }
}