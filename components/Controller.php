<?php
/**
 * Created by PhpStorm.
 * User: alterwalker
 * Date: 21.05.2018
 * Time: 19:51
 */

namespace components;


class Controller
{
    protected function render($template , $params = [])
    {
        echo "<br> Будет создан шаблон " . $template . 'с параметрами:';
        echo "<pre>";
        var_dump($params);
        echo "</pre>";

    }
}