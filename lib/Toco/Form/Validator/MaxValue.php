<?php

class Toco_Form_Validator_MaxValue extends Toco_Form_Validator
{

    protected $_value;

    public function __construct($value) {
        $this->_value = $value;
    }

    public function validate($value) {
        if ($value > $this->_value) {
            $message = sprintf('Ensure this value is less than or equal to %d', $this->_value);
            throw new Toco_Form_ValidationError($message);
        }
    }

}