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

                    /** сохраним данные в сессию и куки**/
                    $_SESSION['user'] = $this->user_db;
                    setcookie("token", $this->user_db['token'], time() + 3600 * 24 * 30 * 12, '/');
                    $orderInfo = new OrderInfo();
                    $orderInfo->initUserOrder();
                    $this->resultAuth = true;

                } else {
                    $this->resultAuth = false;
                }
            }
        }
        return $this->resultAuth;
    }


    public function authWithSession()
    {
        if (!empty($_SESSION['user']['login']) && !empty($_SESSION['user']['pass'])) {
            // получаем данные пользователя по id
            $pdo = Db::getPDO();
            $statement = $pdo->query("select id, login, pass, name from " . $this->table . " where login = '" . $_SESSION['user']['login'] . "'");
            $this->user_db = $statement->fetch();
            if (!empty($this->user_db))
                if ($this->user_db['login'] == $_SESSION['user']['login'] && $this->user_db['pass'] == $_SESSION['user']['pass']) {
                    return true;
                } else {
                    return false;
                }
        } else {
            return false;
        }
    }

    public function initOrder()
    {
        $orderInfo = new OrderInfo();
        $orderInfo->initUserOrder();
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
                $this->initOrder();
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

    public function createToken()
    {
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

        $this->initOrder();

        return $this->resultAuth;
    }


    public function logOutUser()
    {
        session_unset();
        return $this->init();
    }


    public function regUser()
    {
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $login = $_POST['login'];
            $token = $_SESSION['user']['token'];
            $pass = trim(strip_tags($_POST['pass']));

            $pdo = Db::getPDO();
            $statement = $pdo->query("SELECT id, name, login, pass, token  FROM " . $this->table);
            $this->user_db = $statement->fetchAll();

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

            $statementReg = $pdo->exec("INSERT INTO `" . $this->table . "` (login, pass, name, email, token) VALUES ('" . $login . "', '" . md5($pass) . "', '" . $name . "', '" . $email . "', '" . $token . "')");
            $lastId = $pdo->lastInsertId();

            if ($statementReg) {
                $statement = $pdo->query("select id, name, login, pass, token from " . $this->table . " where id = '" . $lastId . "'");
                $_SESSION['user'] = $statement->fetch();
                $this->initOrder();
                return true;
            } else {
                return false;
            }
        }
    }
}