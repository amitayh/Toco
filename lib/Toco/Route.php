<?php

/**
 * Route configuration
 * 
 * @package Toco
 */
class Toco_Route
{

    /**
     * @var string
     */
    public $pattern;

    /**
     * @var array
     */
    public $defaults = array();

    /**
     * @var array
     */
    public $requirements = array(
        'id'    => '\d+',
        'page'  => '\d+',
        'slug'  => '[\w-]+',
        'year'  => '(19|20)\d{2}',
        'month' => '0[1-9]|1[012]',
        'day'   => '0[1-9]|[12][0-9]|3[01]'
    );

    /**
     * @var string
     */
    protected $_compiled;

    /**
     * Constructor
     *
     * @param string $pattern
     * @param array|null $defaults
     * @param array|null $requirements
     */
    public function __construct($pattern, $defaults = null, $requirements = null) {
        $this->pattern = $pattern;
        if ($defaults) {
            $this->defaults = $defaults;
        }
        if ($requirements) {
            $this->requirements = $requirements;
        }
    }

    /**
     * Match route to a URL. Returns an array with matched parameters if match is successful
     *
     * @param string $url
     * @return array|false
     */
    public function match($url) {
        if (preg_match($this->compile(), $url, $matches)) {
            return $this->_clean(array_merge($this->defaults, $matches));
        }
        return false;
    }

    /**
     * Compile the regex pattern for the match
     *
     * @return string
     */
    public function compile() {
        if (!$this->_compiled) {
            $compiled = preg_replace_callback('/\/:(\w+)/', array($this, '_replaceParam'), $this->pattern);
            $this->_compiled = '/^' . str_replace('/', '\/', $compiled) . '$/';
        }
        return $this->_compiled;
    }

    /**
     * Get the regex pattern for a URL parameter
     *
     * @param array $matches
     * @return string
     */
    protected function _replaceParam($matches) {
        $param = $matches[1];
        $match = isset($this->requirements[$param]) ? $this->requirements[$param] : '[^/]+';
        $pattern = sprintf('/(?P<%s>%s)', $param, $match);
        if (isset($this->defaults[$param])) {
            $pattern = '(' . $pattern . ')?';
        }
        return $pattern;
    }

    /**
     * Clean the parameters array - remove elements with numeric keys and empty values
     *
     * @param array $params
     * @return array
     */
    protected function _clean($params) {
        foreach ($params as $k => $v) {
            if (is_integer($k) || $v === '') {
                unset($params[$k]);
            }
        }
        return $params;
    }

}