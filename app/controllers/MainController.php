<?php


namespace app\controllers;


use app\core\Controller;
use app\lib\Db;
use app\models\Account;

class MainController extends Controller
{

    public function indexAction()
    {
//        pass_verify('hh', 'kk');
            $this->view->render('Главная страница!');
    }
}