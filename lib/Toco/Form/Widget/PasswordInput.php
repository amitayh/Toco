<?php

class Toco_Form_Widget_PasswordInput extends Toco_Form_Widget_Input
{
    
    protected $_type = 'password';
    
    protected $_renderValue;

    public function __construct($renderValue = false) {
        $this->_renderValue = $renderValue;
    }
    
    public function render($name, $value) {
        if (!$this->_renderValue) {
            $value = null;
        }
        return parent::render($name, $value);
    }
    
}