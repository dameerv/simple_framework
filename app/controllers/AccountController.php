<?php


namespace app\controllers;


use app\core\Controller;
use app\core\View;
use app\lib\Db;
use app\lib\Security;
use app\lib\Session;
use app\lib\Token;
use app\models\Account;
use app\validators\AccountValidator;

class AccountController extends Controller
{
    public function loginAction()
    {
        $account = Account::findByLogin('d2450170');
//        dd(serialize($account));
        if (!empty($_POST)) {

            $validator = new AccountValidator();
            if (!$validator->validate(['login', 'password'], $_POST)) {
                $this->message('error', $validator->error);
            }
            $account = Account::findByLogin($_POST['login']);
            $pass = $_POST["password"];

            if(!password_verify($pass, $account->getPassword())){
                $this->message('error', 'Логин или пароль указан неверно');
            }elseif(!$account->getStatus()){
                $this->message('error', 'Email не подтвержден.');
            }

            Security::login($account);

            $this->view->redirect('/profile');
        }

        $this->view('Enter');
    }

    public function registerAction()
    {
        if (!empty($_POST)) {
            $account = new Account();
            $validator = new AccountValidator();

            if (!$validator->validate(['login', 'email', 'password'], $_POST)) {
                $this->message('error', $validator->error);
            } elseif (!$account->isEmailExists(trim($_POST['email']))) {
                $this->message('error', $account->error);
            } elseif (!$account->isLoginExists(trim($_POST['login']))) {
                $this->message('error', $account->error);
            }


            $account->setEmail($_POST['email'])
                ->setLogin($_POST['login'])
                ->setPassword(Security::passwordHashGenerate(trim($_POST['email'])))
                ->setToken();
            $account->create();
            mail(
                $account->getEmail(),
                'Registration',
                'Confirm: ' . getDomain() . $account->getToken()
            );
            $this->message('success', 'validation ok');
        }
        $this->view('Registration');
    }

    public function recoveryAction()
    {
        $this->view('Восстановить пароль');
    }

    public function confirmAction()
    {
        $account = Account::findByToken($this->route['token']);
        if (!$account) {
            View::errorCode(403);
        }
        if (!$account->getStatus()) {
            if ($account->activate()) {
                $this->view('Регистрация завершина');
            } else {
                View::errorCode(500);
            }
        } else {
            $this->view('Аккаунт уже актевирован.');
        }
    }

}