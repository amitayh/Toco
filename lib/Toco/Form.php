<?php

/**
 * Form class
 * 
 * @package Toco
 */
abstract class Toco_Form implements IteratorAggregate
{

    public $name;

    protected $_data;

    protected $_cleanedData;

    protected $_isValid = false;

    protected $_fields = array();

    public function __construct($data = null) {
        $this->init();
        if ($data) {
            $this->_data = $data;
            $this->clean();
        }
    }
    
    abstract public function init();

    public function addField(Toco_Form_Field $field) {
        $this->_fields[$field->name] = $field;
        return $this;
    }

    public function clean() {
        $this->_isValid = false;
        if ($this->_data) {
            $this->_isValid = true;
            $this->_cleanedData = array();
            foreach ($this->_fields as $field) {
                try {
                    $name = $field->name;
                    $data = $field->clean($this->_data[$name]);
                    $this->_cleanedData[$name] = $data;
                } catch (Toco_Form_ValidationError $e) {
                    $this->_isValid = false;
                }
            }
        }
        return $this;
    }
    
    public function isValid() {
        return $this->_isValid;
    }
    
    public function getData($name) {
        return (isset($this->_data[$name])) ? $this->_data[$name] : null;
    }

    public function getCleanedData($name) {
        return (isset($this->_cleanedData[$name])) ? $this->_cleanedData[$name] : null;
    }

    public function __toString() {
        $output = array();
        foreach ($this->_fields as $field) {
            $boundField = new Toco_Form_BoundField($this, $field);
            $row = '<p>'
                 . $boundField->label() . ' '
                 . $boundField->widget()
                 . '</p>';

            if (($errors = $boundField->errors()) !== null) {
                 $row .= "\n" . $errors->__toString();
            }

            $output[] = $row;
        }
        return implode("\n", $output);
    }

    public function getIterator() {
        $boundFields = array();
        foreach ($this->_fields as $name => $field) {
            $boundFields[$name] = new Toco_Form_BoundField($this, $field);
        }
        return new ArrayIterator($boundFields);
    }
    
}