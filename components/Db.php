<?php
/**
 * Created by PhpStorm.
 * User: alterwalker
 * Date: 24.05.2018
 * Time: 19:38
 */

namespace components;


class Db
{
    use \components\Traits\Singletone;

    private $pdo;
    public $host = 'localhost';
    public $username = 'root';
    public $database = 'base';
    public $password = '';
    public $charset = 'utf8';

    private function __construct() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->database .';charset=' . $this->charset;
        $opt = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ];
        $this->pdo = new \PDO($dsn, $this->username, $this->password, $opt);
    }


    /**
     * @return \PDO
     */

    public static function getPDO() {
        return self::getInstance()->pdo;
    }
}