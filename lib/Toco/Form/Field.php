<?php

/**
 * @package Toco
 */
abstract class Toco_Form_Field
{
    
    public $name;
    
    public $label;
    
    public $initial;

    public $helpText;

    protected $_required;

    protected $_widget;

    protected $_errors;

    protected $_validators = array();

    protected $_id = 'id_%s';

    public function __construct($name, $required = true, $label = null, $initial = null, Toco_Form_Widget $widget = null, $helpText = null) {
        $this->name = $name;
        $this->label = ($label) ? $label : ucfirst(str_replace('_', ' ', $name));
        $this->initial = $initial;
        $this->helpText = $helpText;
        $this->_widget = ($widget) ? $widget : new Toco_Form_Widget_TextInput();
        $this->_errors = new Toco_Form_ErrorsList();
        $this->_required = $required;
    }
    
    public function setWidget(Toco_Form_Widget $widget) {
        $this->_widget = $widget;
        return $this;
    }
    
    public function addValidator(Toco_Form_Validator $validator) {
        $this->_validators[] = $validator;
        return $this;
    }

    public function clean($value) {
        $value = trim($value);
        if ($this->_required && empty($value) && !is_numeric($value)) {
            $this->_errors[] = 'This field is required';
            throw new Toco_Form_ValidationError();
        } elseif ($value) {
            try {
                $value = $this->getValue($value);
            } catch (Toco_Form_ValidationError $e) {
                $this->_errors[] = $e->getMessage();
                throw new Toco_Form_ValidationError();
            }
            $this->validate($value);
        } else {
            $value = null;
        }
        return $value;
    }

    public function validate($value) {
        foreach ($this->_validators as $validator) {
            try {
                $validator->validate($value);
            } catch (Toco_Form_ValidationError $e) {
                $this->_errors[] = $e->getMessage();
            }
        }
        if (!$this->isValid()) {
            throw new Toco_Form_ValidationError();
        }
    }

    public function getWidget() {
        return $this->_widget;
    }

    public function isValid() {
        return !count($this->_errors);
    }

    public function getErrors() {
        if (!$this->isValid()) {
            return $this->_errors;
        }
        return null;
    }

    public function prepareValue($value) {
        return $value;
    }

    public function getValue($value) {
        return $value;
    }

    public function getId() {
        return sprintf($this->_id, $this->name);
    }
    
}