<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 23.08.2018
 * Time: 16:28
 */

namespace models;

use components\Db;
use components\Model;
use components\Auth;

class User extends Model
{
    private $user_db;
    private $login;
    private $password;
    private $resultInit;

    protected $table = 'users';
    protected $fields = [
        'name',
        'email',
        'login',
        'pass',
        'session_id',
    ];
    public $rules = [
        'name' => 'int',
        'email' => 'string',
        'login' => 'string',
        'pass' => 'string',
        'session_id' => 'string',
    ];

    public function getAllUsers()
    {
        return $this->getAll();
    }

    public function authWithCredentials()
    {
        $this->resultInit = false;
        /**
         * авторизация через логин и пароль
         */
        if (isset($_POST['login']) && isset($_POST['pass'])) {
            $this->login = $_POST['login'];
            $this->password = $_POST['pass'];
            // получаем данные пользователя по логину
            $pdo = Db::getPDO();
            $statement = $pdo->query("SELECT id, login, pass, name FROM `" . $this->table . "` WHERE `login` = '" . $this->login . "'");
            $this->user_db = $statement->fetch();
            // проверяем соответствие логина и пароля
            if (!empty($this->user_db)) {
                if ($this->user_db['login'] == $this->login && $this->user_db['pass'] == md5($this->password)) {
                    $this->resultInit = true;
                    // если стояла галка, то запоминаем пользователя на сутки
                    if (isset($_POST['rememberme']) && $_POST['rememberme'] == 'on') {
                        setcookie("id", 1, time() + 86400 * 30);
                    } else {
                        setcookie("id", 2, time() + 86400);
                    }
                    /** сохраним данные в сессию**/
                    $_SESSION['user'] = $this->user_db;
                } else {
                    $this->resultInit = false;
                }
            }
        }
        return $this->resultInit;
    }

    public function getUserByCookieId()
    {
        $pdo = Db::getPDO();
        $statement = $pdo->query("select id, name, login, pass, session_id from " . $this->table . " where session_id = '" . $_COOKIE['id_user'] . "'");
        return $statement->fetch();
    }


    public function authWithSession()
    {
        if (isset($_SESSION['user']['login']) && isset($_SESSION['user']['pass'])) {
            // получаем данные пользователя по id
            $pdo = Db::getPDO();
            $statement = $pdo->query("select id, login, pass, name from " . $this->table . " where login = '" . $_SESSION['user']['login'] . "'");
            $this->user_db = $statement->fetch();
            if (!empty($this->user_db)) {
                if ($this->user_db['login'] == $_SESSION['user']['login'] && $this->user_db['pass'] == $_SESSION['user']['pass']) {
                    return true;
                } else {
                    //session_unset();
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    function authWithCookie()
    {
        if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])) {
            // получаем данные пользователя по id
            $pdo = Db::getPDO();
            $statement = $pdo->query("select id, name, login, pass, hash from " . $this->table . " where id = '" . $_COOKIE['id'] . "'");
            $this->user_db = $statement->fetch();
            //var_dump($this->user_db);
            if (($this->user_db['hash'] !== $_COOKIE['hash']) || ($this->user_db['id'] !== $_COOKIE['id'])) {
                setcookie("id", '', time() - 3600 * 24 * 30 * 12, '/');
                setcookie("hash", '', time() - 3600 * 24 * 30 * 12, '/');
                return false;
            } else {
                //header("Location: /");
                $_SESSION['user'] = $this->user_db;
                return true;
            }
        } else {
            return false;
        }
    }

    public function init()
    {
        if ($this->authWithSession() == true) {
            $this->resultInit = true;
        } elseif ($this->authWithCookie() == true) {
            $this->resultInit = false;
        } else {
            $hash = $this->hashPassword(rand(1, 10));
            $pdo = Db::getPDO();
            $pdo->exec("INSERT INTO `" . $this->table . "` (`name`, `email`, `login`, `pass`, `hash`) VALUES ('', '', '', '', '" . $hash . "')");
            $this->user_db['id'] = $pdo->lastInsertId();
            setcookie("id", $this->user_db['id'], time() + 3600 * 24 * 30 * 12, '/');
            setcookie("hash", $hash, time() + 3600 * 24 * 30 * 12, '/');
            $_SESSION['user'] = ['id' => $this->user_db['id'], 'hash' => $hash];
            $this->resultInit = false;
        }
        return $this->resultInit;
    }

    public function logOutUser()
    {
        session_unset();
        //d($_SESSION);exit;
        //d($_COOKIE);exit;
        //return $this->init();
    }


    public function hashPassword($password)
    {
        return md5($password);
    }

    /**
     * Сверяем введённый пароль и хэш
     * @param $password
     * @param $hash
     * @return bool
     */

    public function regUser()
    {
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $login = $_POST['login'];
            /**$statement = $pdo->query("SELECT id, login, pass, name FROM `" . $this->table . "` ");
             * $this->user_db = $statement->fetchAll();**/
            if (strtolower($login) == 'admin') {
                return "Логин админа нельзя зарегистрировать!";
            }
            foreach ($this->user_db as $item) {
                if ($login == $item['login']) {
                    return "Такой уже логин есть!";
                }
            }
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $email = trim(strip_tags($_POST['email']));
            };
            $hash = $this->hashPassword(rand(1, 10));
            $pass = trim(strip_tags($_POST['pass']));
            //$date =
            $pdo = Db::getPDO();
            $statementReg = $pdo->exec("INSERT INTO `" . $this->table . "` (login, pass, name, email, hash) VALUES ('" . $login . "', '" . md5($pass) . "', '" . $name . "', '" . $email . "', '" . $hash . "')");
            $lastId = $pdo->lastInsertId();

            if ($statementReg > 0) {
                $statement = $pdo->query("select id, name, login, pass, hash from " . $this->table . " where id = '" . $lastId . "'");
                $_SESSION['user'] = $statement->fetch();
                //$this->init();
                return true;
            } else {
                return false;
            }
        }
    }
}