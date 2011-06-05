<?php

class Toco_Form_Validator_Regex extends Toco_Form_Validator
{

    protected $_pattern;

    protected $_message;

    public function __construct($pattern = null, $message = null) {
        if ($pattern) {
            $this->_pattern = $pattern;
        }
        if ($message) {
            $this->_message = $message;
        }
    }

    public function validate($value) {
        if (!preg_match($this->_pattern, $value)) {
            throw new Toco_Form_ValidationError($this->_message);
        }
    }

}