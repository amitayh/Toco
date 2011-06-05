<?php

class Toco_Form_Field_Email extends Toco_Form_Field
{

    public function __construct($name, $required = true, $label = null, $initial = null, Toco_Form_Widget $widget = null, $helpText = null) {
        parent::__construct($name, $required, $label, $initial, $widget, $helpText);
        $this->addValidator(new Toco_Form_Validator_Email());
    }
    
}