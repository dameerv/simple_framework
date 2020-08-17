<?php

namespace app\models;

use app\core\Model;
use app\lib\Db;
use app\lib\Token;

class Account extends Model
{
    private $id;
    private $email;
    private $login;
    private $password;
    private $token;
    private $status = 0;
    public $fillable = [
        'email',
        'login',
        'token',
        'status',
        'password',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->table = 'user';
    }


    public function isEmailExists($email)
    {
        $params = [
            'email' => $email,
        ];

        if($this->db->column( "SELECT id FROM user WHERE email = :email", $params)){
            $this->error = '"Такой Email уже используется';
            return false;
        }

        return true;
    }

    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function isLoginExists($login)
    {
        $params = [
            'login' => $login,
        ];

        if($this->db->column( "SELECT id FROM user WHERE login = :login", $params)){
            $this->error = '"Такой Логин уже используется';
            return false;
        }

        return true;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    public function setLogin(string $login)
    {
        $this->login = $login;
        return $this;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
        return $this;
    }

    public function setToken()
    {
        $this->token = Token::createToken();
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getEmail()
    {
        return $this->email;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setStatus(int $status)
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus()
    {
        return$this->status;
    }

    public static function findByToken($token)
    {
        $params = [
            'token' => $token
        ];
        $db = new Db();
        $result =  $db->row("SELECT * FROM user WHERE token = :token", $params);
        if(!isset($result[0])){
            return false;
        }

        return parent::getInstance(get_called_class(), $result);
    }

    public function activate()
    {
        $result = $this->db->query("UPDATE user SET status = 1  WHERE id = :id", ['id'=> $this->id])->fetchAll();
        return true;
    }

    public static function findByLogin($login){
        $params = [
            'login' => $login
        ];
        $db = new Db();

        $result =  $db->row("SELECT * FROM user WHERE login = :login", $params);

        return parent::getInstance(get_called_class(), $result);
    }
}