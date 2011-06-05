<?php

class Toco_Form_Field_Char extends Toco_Form_Field
{
    
    public function getValue($value) {
        return ($this->isEmpty($value)) ? null : $value;
    }
    
}