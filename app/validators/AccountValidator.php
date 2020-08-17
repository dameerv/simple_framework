<?php

namespace app\validators;

use app\lib\Validator;

class AccountValidator extends Validator
{
    public function validate($input, $post)
    {
        $rules = [
            'email' =>[
                'pattern' => '#^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$#',
                'message' => 'email указан неверно'
            ],
            'login' =>[
                'pattern' => '#^[a-zA-Z0-9]{3,15}$#',
                'message' => 'Логин указан неверно(разрешены только латинские буквы и цифры, от 3-15 символов)'
            ],
            'password' =>[
                'pattern' => '#^[a-zA-Z0-9_?%]{6,15}$#',
                'message' =>  'Пароль указан неверно(разрешены только латинские буквы, знаки _?% и цифры, от 6-15 символов)'
            ],
        ];

        return $this->checkValues($input, $post, $rules);
    }
}