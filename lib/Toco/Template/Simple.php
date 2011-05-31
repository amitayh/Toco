<?php

/**
 * Simple template rendering class. Replaces variables marked with curly braces
 * (for example: {foo}) with values from context (array('foo' => 'bar'))
 *
 * @package Toco
 */
class Toco_Template_Simple
{

    /**
     * @var string
     */
    protected $_templateString;

    /**
     * @param string $templateString
     */
    public function __construct($templateString) {
        $this->_templateString = $templateString;
    }

    /**
     * @param array $context
     * @return string
     */
    public function render($context = array()) {
        if (preg_match_all('/{([^}]+?)}/', $this->_templateString, $matches)) {
            $search = $replace = array();
            foreach ($matches[1] as $index => $key) {
                $search[] = $matches[0][$index];
                $replace[] = (isset($context[$key])) ? $context[$key] : '';
            }
            return str_replace($search, $replace, $this->_templateString);
        }
        return $this->_templateString;
    }

}