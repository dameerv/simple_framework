<?php


namespace app\core;


class View
{

    public $path;
    public $route = [];
    public $layout = 'default';


    public function __construct($route)
    {
        $this->route = $route;
        $this->path = $route['controller'] .'/'.$route['action'];

    }

    /**
     * @return string
     */
    public function render(/*$template = null,*/ $title, $vars = [])
    {
        extract($vars, EXTR_SKIP);
        $path = 'app/views/' . $this->path . '.php';
        if(file_exists($path)) {
            ob_start();
            require $path;
            $content = ob_get_clean();
            require 'app/views/layouts/' . $this->layout . '.php';
        }else{
            echo 'View '.$this->path.' is not found';
        }
    }

    /**
     * @param $code
     */
    public static function errorCode($code)
    {
        http_response_code($code);
        $path =   'app/views/errors/' .$code.'.php';
        if(file_exists($path)){
            require $path;
        }
    exit;
    }

    public function redirect($url):void
    {
        header('Location: ' . $url);
        exit;
    }
}