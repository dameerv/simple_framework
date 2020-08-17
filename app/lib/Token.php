<?php


namespace app\lib;


class Token
{
    public static function createToken(int $length = 30) :string
    {
        return substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, $length);
    }
}