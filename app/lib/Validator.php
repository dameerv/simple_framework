<?php


namespace app\lib;


abstract class Validator
{

    public $error;

    public function checkValues($input, $post = [], $rules = [])
    {
        foreach($input as $value){
            if((!isset($post[$value]) || empty($post[$value])) && !preg_match($rules[$value]['pattern'], $post[$value])){
                $this->error = $rules[$value]['message'];
                return false;
            }
        }
        return true;
    }

    public function checkData()
    {
        
    }
    abstract public function validate($input, $post);
}