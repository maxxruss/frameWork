<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 23.08.2018
 * Time: 16:18
 */


namespace components;

use components\Auth;
use models\User;

require_once "../vendor/autoload.php";


class Controller
{
    public $templateFolder;
    public $templateExtension;
    public $userInit;
    public $initResult;

    public function __construct($templateFolder, $templateExtension)
    {
        $this->templateExtension = $templateExtension;
        $this->templateFolder = $templateFolder;
        $userInit = new Auth;
        $this->initResult = $userInit->init();
    }

    protected function render($template, $params = [])
    {
        $loader = new \Twig_Loader_Filesystem($this->templateFolder);
        $twig = new \Twig_Environment($loader);
        $templateInstance = $twig->load($template . $this->templateExtension);
        $content = $templateInstance->render($params);
        //echo ($this->templateFolder.$template.$this->templateExtension);
        return $content;
    }
}