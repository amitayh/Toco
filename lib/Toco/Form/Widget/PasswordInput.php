<?php

class Toco_Form_Widget_PasswordInput extends Toco_Form_Widget_Input
{
    
    protected $_type = 'password';
    
    protected $_renderValue;

    public function __construct($renderValue = false) {
        $this->_renderValue = $renderValue;
    }
    
    public function render($attributes = array()) {
        if (!$this->_renderValue) {
            $attributes['value'] = null;
        }
        return parent::render($attributes);
    }
    
}