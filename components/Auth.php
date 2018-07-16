<?php
/**
 * Created by PhpStorm.
 * User: alterwalker
 * Date: 21.05.2018
 * Time: 20:56
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
        if (isset($_POST['login']) && isset($_POST['password'])) {
            $this->login = $_POST['login'];
            $this->password = $_POST['password'];

            // получаем данные пользователя по логину

            $pdo = Db::getPDO();
            $statement = $pdo->query("SELECT id, login, pass FROM `users` WHERE `login` = '" . $this->login . "'");

            $this->user_db = $statement->fetchAll()[0];
            //print_r ($this->user_db);

            // проверяем соответствие логина и пароля
            if (!empty($this->user_db)) {
                if ($this->user_db['login'] == $this->login && $this->user_db['pass'] == md5($this->password)) {
                    //echo '  верно    ';
                    $isAuth = true;
                } else {
                    //echo '   неверно   ';
                    //setcookie("auto_authorized", "");
                    //print_r ($_COOKIE);
                }
            }

            // если стояла галка, то запоминаем пользователя на сутки
            /**if (isset($_POST['rememberme']) && $_POST['rememberme'] == 'on') {
                setcookie("id_user", $this->user_db['id'], time() + 86400);
                setcookie("cookie_hash1", $this->user_db['pass'], time() + 86400);
                setcookie("auto_authorized", "1", time() + 3600 * 24 * 30 * 12);
                //print_r ($_COOKIE);

            }**/

            // сохраним данные в сессию
            $_SESSION['user'] = $this->user_db;
            print_r($_SESSION) ;
            //unset( $_COOKIE[ 'cookie_hash1']);
            //print_r($_COOKIE);

        }
        //print_r ($_COOKIE);
        //echo ($_COOKIE['cookie_hash']);
        //print_r($_SESSION['user']);
        //print_r($_SESSION['user']);
        //print_r($_COOKIE);

        return $isAuth;
    }

    public function logOut()
    {
        //setcookie("auto_authorized", "", -1);
        session_unset();
        print_r($_SESSION);

    }

    /**
     * Сверяем введённый пароль и хэш
     * @param $password
     * @param $hash
     * @return bool
     */


    private function alreadyLoggedIn()
    {
        return isset($_SESSION['user']);
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
            $statement = $pdo->query("select id, login, pass from users where login = '" . $_SESSION['user']['login'] . "'");
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
        print_r($_SESSION);
        return $this->resultInit;
    }
}