<?php

class Toco_Form_Field_Integer extends Toco_Form_Field
{
    
    public function __construct($name, $required = true, $minValue = null, $maxValue = null, $label = null,
                                $initial = null, Toco_Form_Widget $widget = null, $helpText = null) {
        parent::__construct($name, $required, $label, $initial, $widget, $helpText);
        if ($minValue !== null) {
            $this->addValidator(new Toco_Form_Validator_MinValue($minValue));
        }
        if ($maxValue !== null) {
            $this->addValidator(new Toco_Form_Validator_MaxValue($maxValue));
        }
    }

    public function getValue($value) {
        if (!is_numeric($value) || (float) $value != (int) $value) {
            throw new Toco_Form_ValidationError('Enter a whole number');
        }
        return (int) $value;
    }
    
}