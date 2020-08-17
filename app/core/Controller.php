<?php


namespace app\core;

use app\core\View;

abstract class Controller
{
    protected $route;
    protected $view;
    private $access = [];
    public function __construct($route)
    {
        session_start();
//        unset($_SESSION["admin"]);
        $this->route = $route;
        $_SESSION['admin'] = 1;
        session_write_close();
        if(!$this->checkAccess()){
            View::errorCode(403);
        }
        $this->view = new View($route);
        if(method_exists($this, 'before')){
            $this->before();
        }

        $this->model = $this->loadModel($route['controller']);
//        dd($this->model);
    }


    public function loadModel(string $name)
    {
        $path = 'app\models\\' . ucfirst($name);
        if(class_exists($path)){
            return new $path();
        }
    }

    public function view($title, $vars = [])
    {
        $this->view->render( $title, $vars = []);
    }

    /**
     *
     * Редирект на указанную страницу
     * @param string $url
     */
    public function redirect(string $url = '/'):void
    {
        header('Location: ' .$url);
        exit;
    }

    public function message($status, $message)
    {

        exit(json_encode(['status'=>$status, 'message' => $message]));
    }

    public function location($url)
    {
        exit(json_encode(['url'=>$url]));
    }

    public function checkAccess()
    {
        /**
         * В папке app/accessList должен находдиться файл для контроллера
         * если его нет, до загружается файл default который разрешает
         * доступ ко все экшенам запрашиваемого контроллера.
         */
        $fileName = 'app/accessList/' . $this->route['controller']. '.php';
//        dd(session_id());
        if(file_exists($fileName)){
            $this->access = require $fileName;
        } else{
            $this->access = require 'app/accessList/default.php';
        }

        if($this->isAccessed('all') || in_array($this->route['action'], $this->access['all'], true)){
            return true;
        }
        if(isset($_SESSION['account']['id']) && $this->isAccessed('authorized')){
            return true;
        }

        if(!isset($_SESSION['account']['id']) && $this->isAccessed('guest')){
            return true;
        }

        if(isset($_SESSION['admin']) && $this->isAccessed('admin')){
            return true;
        }

        return false;
    }

    public function isAccessed($kye)
    {
        if(isset($this->access[$kye])){
            return in_array( $this->route['action'],  $this->access[$kye],true) || in_array('*', $this->access[$kye], true);
        }else{
            return false;
        }

    }
}