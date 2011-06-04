<?php

/**
 * @package Toco
 */
abstract class Toco_Form_Field
{
    
    public $name;
    
    public $label;
    
    public $initial;
    
    protected $_widget;
    
    protected $_helpText;
    
    protected $_errorMessages = array();
    
    protected $_validators = array();
    
    protected $_id = 'id_%s';

    public function __construct($name, $label = null, $initial = null, Toco_Form_Widget $widget = null,
                                $helpText = null, $errorMessages = array(), $validators = array()) {
        $this->name = $name;
        $this->label = ($label) ? $label : $this->_getLabel($name);
        $this->initial = $initial;
        $this->_widget = ($widget) ? $widget : new Toco_Form_Widget_TextInput();
        $this->_helpText = $helpText;
        $this->_errorMessages = $errorMessages;
        $this->_validators = $validators;        
    }
    
    public function setWidget(Toco_Form_Widget $widget) {
        $this->_widget = $widget;
        return $this;
    }
    
    public function addValidator(Toco_Form_Validator $validator) {
        $this->_validators[] = $validator;
        return $this;
    }
    
    public function isValid() {
        foreach ($this->_validators as $validator) {
            if (!$validator->validate($this)) {
            }
        }
    }

    public function getWidget() {
        return $this->_widget;
    }

    public function prepareValue($value) {
        return $value;
    }
    
    public function getId() {
        return sprintf($this->_id, $this->name);
    }

    protected function _getLabel($name) {
        // TODO: handle camel case labels
        return ucfirst(str_replace('_', ' ', $name));
    }
    
}