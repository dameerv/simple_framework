<?php


namespace app\core;


use app\lib\Db;
use app\service\PhpDocVarsService as DocVars;

abstract class Model
{
    public $db;
    public $error = '';
    protected $table;
    public function __construct()
    {
        $this->db = new Db();
    }

    public function create()
    {
        $columns = "";
        $values = "";
        $count = 1;
        foreach($this->fillable as $key){
            $columns .= (count($this->fillable) === $count)? $key: $key . ',';
            $method = 'get' . ucfirst($key);
            $values .= (count($this->fillable) === $count)? "'". trim($this->$method()) . "'": "'". trim($this->$method()) . "',";
            $count++;
        }
        $sql = "INSERT INTO $this->table($columns) VALUES($values)";
        $this->db->query($sql);

    }

    public static function getInstance(string $className, $result)
    {
        $instance = new $className();
        if(isset($result[0])){
            $result = $result[0];
        }
        foreach($result as $prop => $value){
            if($prop !== 'id') {
                $method = 'set' . ucfirst($prop);
                if(method_exists($instance, $method)) {
                    $instance->$method($value);
                }
            }else{
                $instance->setId($value);
            }
        }
        return $instance;
    }


    public function __serialize()
    {
        $reflection = new \ReflectionClass($this);
        dd($reflection->getShortName());
        $data = [];

    }

}