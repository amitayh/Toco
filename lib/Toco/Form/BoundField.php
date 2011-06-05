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
        return $this->widget();
    }
    
    public function label($contents = null, $attributes = array()) {
        $contents = ($contents) ? $contents : $this->_field->label;
        $contents .= $this->_labelSuffix;
        $attributes['for'] = $this->_field->getId();
        return sprintf('<label %s>%s</label>', Toco_Form_Widget::renderAttributes($attributes), $contents);
    }

    public function errors($attributes = array()) {
        if (!$this->_field->isValid()) {
            $errors = $this->_field->getErrors();
            $errors->attributes = array_merge($errors->attributes, $attributes);
            return $errors;
        }
        return null;
    }

    public function widget($attributes = array()) {
        $default = array(
            'name'  => $this->_field->name,
            'value' => $this->getValue(),
            'id'    => $this->_field->getId(),
        );
        $attributes = array_merge($default, $attributes);
        return $this->_field->getWidget()->render($attributes);
    }

    public function getValue() {
        $value = $this->_form->getData($this->_field->name);
        if ($value === null) {
            $value = $this->_field->initial;
        }
        return $this->_field->prepareValue($value);
    }
    
}