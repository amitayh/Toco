<?php

abstract class Toco_Form_Widget_Input extends Toco_Form_Widget
{
    
    protected $_type;
    
    public function render($name, $value, $attributes = array()) {
        $default = array(
            'type'  => $this->_type,
            'name'  => $name,
            'value' => $value
        );
        $attributes = array_merge($default, $this->attributes, $attributes);
        return '<input ' . Toco_Form_Widget::renderAttributes($attributes) . ' />';
    }
    
}