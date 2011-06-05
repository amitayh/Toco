<?php

class Toco_Form_Field_Float extends Toco_Form_Field_Integer
{
    
    public function getValue($value) {
        if (!is_numeric($value)) {
            throw new Toco_Form_ValidationError('Enter a number');
        }
        return (int) $value;
    }
    
}