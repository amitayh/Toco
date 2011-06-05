<?php

abstract class Toco_Form_Widget_Input extends Toco_Form_Widget
{
    
    protected $_type;
    
    public function render($attributes = array()) {
        $attributes = array_merge(array('type' => $this->_type), $this->attributes, $attributes);
        return '<input ' . Toco_Form_Widget::renderAttributes($attributes) . ' />';
    }
    
}