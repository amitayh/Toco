<?php

/**
 * @package Toco
 */
abstract class Toco_Form_Widget
{
    
    public $attributes = array();

    public function __construct(array $attributes = null) {
        if ($attributes) {
            $this->attributes = array_merge($this->attributes, $attributes);
        }
    }

    abstract public function render($name, $value, $attributes = array());

    public static function escape($value) {
        return htmlentities($value, ENT_QUOTES, 'utf-8');
    }
    
    public static function renderAttributes($attributes = array()) {
        $output = array();
        foreach ($attributes as $name => $value) {
            $output[] = $name . '="' . self::escape($value) . '"';
        }
        return implode(' ', $output);
    }
    
}