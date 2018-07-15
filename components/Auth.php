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
    private static $user_data;
    private static $login;
    private static $password;


    private function check()
    {

        $isAuth = 0;
        /**
         * авторизация через логин и пароль
         */

        self::$login = $_POST['login'];
        self::$password = $_POST['password'];

        // получаем данные пользователя по логину
        /**$link = getConnection();
         * $sql = "SELECT id_user, user_name, user_password FROM users WHERE user_login = '" . mysqli_real_escape_string($link, $username) . "'";
         * $user_data = getRowResult($sql, $link);**/


        $pdo = Db::getPDO();
        $statement = $pdo->query('select id, login, pass from users where login = ' . self::$login);
        self::$user_data = $statement->fetchAll();

        return $isAuth;
    }

    private static function rememberMe()
    {
        // если стояла галка, то запоминаем пользователя на сутки
        if (isset($_POST['rememberme']) && $_POST['rememberme'] == 'on') {
            setcookie("id_user", self::$user_data['id'], time() + 86400);
            setcookie("cookie_hash", self::$user_data['pass'], time() + 86400);
        }

        // сохраним данные в сессию
        $_SESSION['user'] = self::$user_data;
    }


    private static function hashPassword($password)
    {
        /**$salt = md5(uniqid(SALT2, true));
         * $salt = substr(strtr(base64_encode($salt), '+', '.'), 0, 22);
         * return crypt($password, '$2a$08$' . $salt);**/
        return md5($password);
    }

    /**
     * Сверяем введённый пароль и хэш
     * @param $password
     * @param $hash
     * @return bool
     */
    protected function Authentication()
    {
        // проверяем соответствие логина и пароля
        if (!empty(self::$user_data)) {
            if (self::$user_data['login'] == self::$login && self::$user_data['pass'] == md5(self::$password)) {
                $this->isAuth = 1;
            } else {
                echo 'неверный логин или пароль';
            }
        }
    }

    private function alreadyLoggedIn()
    {
        return isset($_SESSION['user']);
    }


    public static function init()
    {

        /**
         * валидация пользовательского куки
         * @return bool
         */

        $result = false;

        if (isset($_COOKIE['id_user']) && isset($_COOKIE['cookie_hash'])) {
            // получаем данные пользователя по id
            $pdo = Db::getPDO();
            $statement = $pdo->query('select id, login, pass from users where login = ' . self::$login);
            self::$user_data = $statement->fetchAll();

            if ((self::$user_data['pass'] !== $_COOKIE['user_hash']) || (self::$user_data['id'] !== $_COOKIE['id_user'])) {
                setcookie("id", "", time() - 3600 * 24 * 30 * 12, "/");
                setcookie("hash", "", time() - 3600 * 24 * 30 * 12, "/");
            } else {
                header("Location: /");
            }
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}