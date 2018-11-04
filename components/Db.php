<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 23.08.2018
 * Time: 15:35
 */

namespace components;

use \components\Traits\Singletone;

class Db
{
    use Singletone;

    private $pdo;
    public $host = 'localhost';
    public $username = 'root';
    public $database = 'catalog';
    public $password = '1';
    public $port = '3306';
    public $charset = 'utf8';
    //public $opt;
    //public $dsn;

    public function __construct() {
        $dsn = 'mysql:host=' . $this->host . '; dbname=' . $this->database .';charset=' . $this->charset;
        $opt = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ];
        $this->pdo = new \PDO($dsn, $this->username, $this->password, $opt);
        //var_dump(self::$pdo);exit;
    }



    /**
     * @return \PDO
     */

    public static function getPDO() {
        return self::getInstance()->pdo;
    }
}