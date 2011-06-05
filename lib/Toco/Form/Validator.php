<?php

abstract class Toco_Form_Validator
{
    
    abstract public function validate($value);

    public static function factory($name) {
        $validatorClass = 'Toco_Form_Validator_' . ucfirst($name);
        $validator = new $validatorClass();
        if (!$validator instanceof self) {
            throw new Exception("Validator '$name' must be a subclass of " . __CLASS__);
        }
        return $validator;
    }
    
}