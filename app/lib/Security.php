<?php


namespace app\lib;


use app\models\Account;

class Security
{
    public static function passwordHashGenerate($password)
    {
        return  password_hash($password, PASSWORD_DEFAULT);
    }

    public static function login(Account $account)
    {
        if(!isset($_SESSION['account'])) {
            Session::set('account', $account);
        }

    }

    public static function logout()
    {
        Session::unset('account');
    }
}