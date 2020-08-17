<?php


namespace app\controllers;


use app\core\Controller;

class ProfileController extends Controller
{
    public function indexAction()
    {
//        dd($_SESSION['account']);
        $this->view('Профиль');
    }
}