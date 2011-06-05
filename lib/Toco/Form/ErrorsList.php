<?php

class Toco_Form_ErrorsList extends ArrayObject
{

    public $attributes = array('class' => 'errors');

    public function __toString() {
        $output = '<ul ' . Toco_Form_Widget::renderAttributes($this->attributes) . ">\n";
        foreach ($this as $item) {
            $output .= '<li>' . htmlentities($item, ENT_QUOTES, 'utf-8') . "</li>\n";
        }
        $output .= '</ul>';
        return $output;
    }

}