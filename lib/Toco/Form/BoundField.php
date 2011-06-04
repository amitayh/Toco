<?php

class Toco_Form_BoundField
{
    
    protected $_form;
    
    protected $_field;
    
    protected $_labelSuffix = ':';

    public function __construct(Toco_Form $form, Toco_Form_Field $field) {
        $this->_form = $form;
        $this->_field = $field;
    }
    
    public function __toString() {
        $name = $this->_field->name;
        $value = $this->getValue();
        $attributes = array();
        $id = $this->_field->getId();
        if ($id) {
            $attributes['id'] = $id;
        }
        return $this->_field->getWidget()->render($name, $value, $attributes);
    }
    
    public function labelTag($contents = null) {
        $contents = ($contents) ? $contents : $this->_field->label;
        $contents .= $this->_labelSuffix;
        $attributes = array('for' => $this->_field->getId());
        return sprintf('<label %s>%s</label>', Toco_Form_Widget::renderAttributes($attributes), $contents);
    }
    
    public function errors() {
        
    }

    public function getValue() {
        $value = $this->_form->getData($this->_field->name);
        if ($value === null) {
            $value = $this->_field->initial;
        }
        return $this->_field->prepareValue($value);
    }
    
}