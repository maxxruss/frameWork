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
    public $templateFolder;
    public $templateExtension;

    public function __construct($templateFolder, $templateExtension)
    {
        $this->templateExtension = $templateExtension;
        $this->templateFolder = $templateFolder;
    }

    protected function render($template , $params = [])
    {
        $loader = new \Twig_Loader_Filesystem($this->templateFolder);

        $twig = new \Twig_Environment($loader);

        $templateInstance = $twig->loadTemplate($template . $this->templateExtension );

        $content = $templateInstance->render($params);

        //echo ($this->templateFolder.$template.$this->templateExtension);

        return $content;
    }
}