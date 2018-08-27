<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 23.08.2018
 * Time: 15:50
 */

namespace components;

use components\Db;

class Auth
{
    private $user_db;
    private $login;
    private $password;
    private $resultInit;
    public function check()
    {
        $isAuth = false;
        /**
         * авторизация через логин и пароль
         */
        if (isset($_POST['login']) && isset($_POST['pass'])) {
            $this->login = $_POST['login'];
            $this->password = $_POST['pass'];
            // получаем данные пользователя по логину
            $pdo = Db::getPDO();
            $statement = $pdo->query("SELECT id, login, pass, name FROM `users` WHERE `login` = '" . $this->login . "'");
            $this->user_db = $statement->fetchAll()[0];
            // проверяем соответствие логина и пароля
            if (!empty($this->user_db)) {
                if ($this->user_db['login'] == $this->login && $this->user_db['pass'] == md5($this->password)) {
                    $isAuth = true;
                    /** сохраним данные в сессию**/
                    $_SESSION['user'] = $this->user_db;
                } else {
                    $isAuth = false;
                }
            }
            // если стояла галка, то запоминаем пользователя на сутки
            /**if (isset($_POST['rememberme']) && $_POST['rememberme'] == 'on') {
            setcookie("id_user", $this->user_db['id'], time() + 86400);
            setcookie("cookie_hash1", $this->user_db['pass'], time() + 86400);
            setcookie("auto_authorized", "1", time() + 3600 * 24 * 30 * 12);
            //print_r ($_COOKIE);
            }**/
        }
        return $isAuth;
    }
    public function logOut()
    {
        session_unset();
    }
    /**
     * Сверяем введённый пароль и хэш
     * @param $password
     * @param $hash
     * @return bool
     */
    public function reg()
    {
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $login = $_POST['login'];
            $pdo = Db::getPDO();
            $statement = $pdo->query("SELECT id, login, pass, name FROM `users` ");
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
            $pass = trim(strip_tags($_POST['pass']));
            //$date =
            $statementReg = $pdo->exec("INSERT INTO `users` (login, pass, name, email, date, session_id) VALUES ('".$login."', '". md5($pass)."', '". $name."', '". $email."', '2018-07-17', '')");
            if ($statementReg>0) {
                return true;
            } else {
                return false;
            }
        }
    }
    public function init()
    {
        /**
         * валидация пользовательского куки
         * @return bool
         */
        /**if (isset($_COOKIE[ 'auto_authorized'])&&isset($_COOKIE[ 'PHPSESSID'])) {
        $pdo = Db::getPDO();
        $statement = $pdo->query("select id, login, pass from users where session_id = '" . $_COOKIE[ 'PHPSESSID'] . "'");
        $this->user_db = $statement->fetchAll()[0];
        !isset($this->user_db) ? null : $_SESSION['user'] = $this->user_db;
        //print_r($_SESSION['user']);
        setcookie("id", "", time() - 3600 * 24 * 30 * 12, "/");
        setcookie("hash", "", time() - 3600 * 24 * 30 * 12, "/");
        $this->resultInit = true;
        //echo 'true';
        } else {
        $this->resultInit = false;
        //echo 'false';
        session_unset();
        }**/
        if (isset($_SESSION['user'])) {
            // получаем данные пользователя по id
            $pdo = Db::getPDO();
            $statement = $pdo->query("select id, login, pass, name from users where login = '" . $_SESSION['user']['login'] . "'");
            $this->user_db = $statement->fetchAll()[0];
            if (($this->user_db['pass'] !== $_SESSION['user']['pass']) || ($this->user_db['id'] !== $_SESSION['id'])) {
                //setcookie("id", "", time() - 3600 * 24 * 30 * 12, "/");
                //setcookie("hash", "", time() - 3600 * 24 * 30 * 12, "/");
                $this->resultInit = true;
                //echo 'true';
            } else {
                $this->resultInit = false;
                //echo 'false';
                session_unset();
            }
        }
        //print_r($_SESSION);
        return $this->resultInit;
    }
}