<?php


namespace app\lib;


use app\models\Account;

class Session
{
    public static function set($index, $value)
    {
        dd(get_class_vars(Account::class));
        session_start();
        $_SESSION[$index] = $value;
        session_write_close();
    }

    public static function unset($index)
    {
        unset($_SESSION[$index]);
    }
}