<?php

class Toco_Form_Widget_Textarea extends Toco_Form_Widget
{

    public $attributes = array(
        'rows'  => 5,
        'cols'  => 50
    );

    public function render($name, $value, $attributes = array()) {
        $default = array('name' => $name);
        $attributes = array_merge($default, $this->attributes, $attributes);
        $output = '<textarea ' . Toco_Form_Widget::renderAttributes($attributes) . '>'
                . Toco_Form_Widget::escape($value)
                . '</textarea>';
        return $output;
    }

}