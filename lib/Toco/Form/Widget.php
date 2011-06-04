<?php

/**
 * @package Toco
 */
abstract class Toco_Form_Widget
{
    
    public $attributes;

    public function __construct($attributes = array()) {
        $this->attributes = $attributes;
    }

    abstract public function render($name, $value, $attributes = array());
    
    public static function renderAttributes($attributes = array()) {
        $output = array();
        foreach ($attributes as $name => $value) {
            $output[] = $name . '="' . htmlentities($value, ENT_QUOTES, 'utf-8') . '"';
        }
        return implode(' ', $output);
    }
    
}