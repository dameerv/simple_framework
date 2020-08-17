<?php

return [
    //MainController
    '' => [
        'controller' => 'main',
        'action' => 'index'
    ],
    //AccountController
    'account/login' => [
        'controller' => 'account',
        'action' => 'login'
    ],
    'account/register' => [
        'controller' => 'account',
        'action' => 'register'
    ],


    'account/recovery' => [
        'controller' => 'account',
        'action' => 'recovery'
    ],


    'account/logout' => [
        'controller' => 'account',
        'action' => 'logout'
    ],

    'account/confirm/{token:\w+}' => [
        'controller' => 'account',
        'action' => 'confirm'
    ],

    //Profile Controller

    'profile' => [
        'controller' => 'profile',
        'action' => 'index'
    ],
];