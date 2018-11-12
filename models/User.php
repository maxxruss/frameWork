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
    private $resultAuth;

    protected $table = 'users';
    protected $fields = [
        'name',
        'email',
        'login',
        'pass',
        'session_id',
        'hash',
    ];
    public $rules = [
        'name' => 'int',
        'email' => 'string',
        'login' => 'string',
        'pass' => 'string',
        'session_id' => 'string',
        'hash' => 'string',
    ];

    public function getAllUsers()
    {
        return $this->getAll();
    }

    public function authWithCredentials()
    {
        $this->resultAuth = false;
        /**
         * авторизация через логин и пароль
         */
        if (isset($_POST['login']) && isset($_POST['pass'])) {
            $this->login = $_POST['login'];
            $this->password = $_POST['pass'];
            // получаем данные пользователя по логину
            $pdo = Db::getPDO();
            $statement = $pdo->query("SELECT id, login, pass, name, token FROM `" . $this->table . "` WHERE `login` = '" . $this->login . "'");
            $this->user_db = $statement->fetch();
            // проверяем соответствие логина и пароля
            if ($this->user_db) {
                if ($this->user_db['login'] == $this->login && $this->user_db['pass'] == md5($this->password)) {
                    // если стояла галка, то запоминаем пользователя на год
//                    if (isset($_POST['rememberme']) && $_POST['rememberme'] == 'on') {
////                        setcookie("id", $this->user_db['id'], time() + 3600 * 24 * 30 * 12, '/');
////                        setcookie("hash", $this->user_db['hash'], time() + 3600 * 24 * 30 * 12, '/');
//                    }
                    /** сохраним данные в сессию и куки**/

                    $_SESSION['user'] = $this->user_db;
                    setcookie("token", $this->user_db['token'], time() + 3600 * 24 * 30 * 12, '/');
                    $this->resultAuth = true;

                } else {
                    $this->resultAuth = false;
                }
            }
        }
        return $this->resultAuth;
    }

    public function getUserByCookieId()
    {
        $pdo = Db::getPDO();
        $statement = $pdo->query("select id, name, login, pass, session_id from " . $this->table . " where session_id = '" . $_COOKIE['id_user'] . "'");
        return $statement->fetch();
    }


    public function authWithSession()
    {
        if (!empty($_SESSION['user']['login']) && !empty($_SESSION['user']['pass'])) {
            // получаем данные пользователя по id
            $pdo = Db::getPDO();
            $statement = $pdo->query("select id, login, pass, name from " . $this->table . " where login = '" . $_SESSION['user']['login'] . "'");
            $this->user_db = $statement->fetch();
            if (!empty($this->user_db)) {
                if ($this->user_db['login'] == $_SESSION['user']['login'] && $this->user_db['pass'] == $_SESSION['user']['pass']) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    function authWithToken()
    {
        $token = $_SESSION['user']['token'];
        if (isset($token)) {
            // получаем данные пользователя по id
            $pdo = Db::getPDO();
            $statement = $pdo->query("select id, name, login, pass, token from " . $this->table . " where token = '" . $token . "'");
            $this->user_db = $statement->fetch();
            if (($this->user_db)) {
                //header("Location: /");
                $_SESSION['user'] = $this->user_db;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function initToken()
    {
//        $tokenCookie = $_COOKIE['token'];
//        $tokenSession = $_SESSION['user']['token'];

        if (isset($_COOKIE['token']) && isset($_SESSION['user']['token'])) {
            if ($_COOKIE['token'] != $_SESSION['user']['token']) {
                $_SESSION['user']['token'] = $_COOKIE['token'];
            }
        }

        if (!isset($_COOKIE['token']) && !isset($_SESSION['user']['token'])) {
            $token = $this->createToken();
            $_SESSION['user']['token'] = $token;
            setcookie("token", $token, time() - 3600 * 24 * 30, '/');
        }

        if (!isset($_SESSION['user']['token'])) {
            $_SESSION['user']['token'] = $_COOKIE['token'];
        }

        if (!isset($_COOKIE['token'])) {
            setcookie("token", $_SESSION['user']['token'], time() + 3600 * 24 * 30, '/');
        }
    }

    public function createToken() {
        return md5(time());
    }

    public function init()
    {
        if ($this->authWithSession()) {
            $this->resultAuth = true;
        } else {
            $this->initToken();
            $this->resultAuth = false;
        };

        return $this->resultAuth;
    }


//    public function createNewUser()
//    {
//        $hash = $this->hashPassword();
//        $pdo = Db::getPDO();
//        $pdo->exec("INSERT INTO `" . $this->table . "` (`name`, `email`, `login`, `pass`, `hash`) VALUES ('', '', '', '', '" . $hash . "')");
//        $this->user_db['id'] = $pdo->lastInsertId();
//        setcookie("id", $this->user_db['id'], time() + 3600 * 24 * 30, '/');
//        setcookie("hash", $hash, time() + 3600 * 24 * 30, '/');
//        $_SESSION['user'] = ['id' => $this->user_db['id'], 'hash' => $hash];
//        $this->resultAuth = false;
//    }


    public function logOutUser()
    {
        session_unset();
        //d($_SESSION);exit;
        //d($_COOKIE);exit;
        return $this->init();
    }


    public function regUser()
    {
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $login = $_POST['login'];

            $pdo = Db::getPDO();
            $statement = $pdo->query("SELECT id, login, pass, name FROM " . $this->table);
            $this->user_db = $statement->fetchAll();

            if (strtolower($login) == $this->user_db['admin']) {
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

            $token = $_SESSION['user']['token'];
            $pass = trim(strip_tags($_POST['pass']));

            $statementReg = $pdo->exec("INSERT INTO `" . $this->table . "` (login, pass, name, email, token) VALUES ('" . $login . "', '" . md5($pass) . "', '" . $name . "', '" . $email . "', '" . $token . "')");
            $lastId = $pdo->lastInsertId();

            if ($statementReg) {
                $statement = $pdo->query("select id, name, login, pass, token from " . $this->table . " where id = '" . $lastId . "'");
                $_SESSION['user'] = $statement->fetch();
                //$this->init();
                return true;
            } else {
                return false;
            }
        }
    }
}