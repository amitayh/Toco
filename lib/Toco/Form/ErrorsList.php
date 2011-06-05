<?php

class Toco_Form_ErrorsList extends ArrayObject
{

    public $attributes = array('class' => 'errors');

    public function __toString() {
        $output = '<ul ' . Toco_Form_Widget::renderAttributes($this->attributes) . ">\n";
        foreach ($this as $item) {
            $output .= '<li>' . Toco_Form_Widget::escape($item) . "</li>\n";
        }
        $output .= '</ul>';
        return $output;
    }

}