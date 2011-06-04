<?php

/**
 * Form class
 * 
 * @package Toco
 */
abstract class Toco_Form
{
    
    protected $_fields = array();

    protected $_data = array();
    
    public function __construct($data) {
        $this->_data = $data;
        $this->init();
    }
    
    abstract public function init();

    public function addField(Toco_Form_Field $field) {
        $this->_fields[] = $field;
        return $this;
    }
    
    public function isValid() {
        foreach ($this->_fields as $field) {
            if (!$field->isValid()) {
                return false;
            }
        }
        return true;
    }
    
    public function getData($key) {
        return (isset($this->_data[$key])) ? $this->_data[$key] : null;
    }

    public function asP() {
        $output = array();
        foreach ($this->_fields as $field) {
            $boundField = new Toco_Form_BoundField($this, $field);
            $row = '<p>'
                 . $boundField->labelTag() . ' '
                 . $boundField->__toString()
                 . '</p>';
            
            $errors = $boundField->errors();
            if ($errors) {
                $row .= "\n<ul>\n";
                foreach ($errors as $error) {
                    $row .= $error . "\n";
                }
                $row .= '</ul>';
            }
            
            $output[] = $row;
        }
        return implode("\n", $output);
    }
    
    public function asUl() {
        
    }

    public function asTable() {
        
    }

    public function __toString() {
        return $this->asP();
    }
    
    protected function _getHtml($fieldRow, $errorRow, $helpText) {
        
    }
    
}