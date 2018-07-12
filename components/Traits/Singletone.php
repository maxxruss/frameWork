<?php
/**
 * Created by PhpStorm.
 * User: alterwalker
 * Date: 24.05.2018
 * Time: 20:27
 */

namespace components\Traits;

trait Singletone
{
    private static $instance;
    private function __construct() {}
    private function __sleep() {}
    private function __wakeup() {}
    private function __clone() {}

    public function getInstance() {

        if(empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}