<?php

class Toco_Route
{

    public $pattern;

    public $defaults = array();

    public $requirements = array(
        'id'    => '\d+',
        'page'  => '\d+',
        'slug'  => '[\w-]+',
        'year'  => '(19|20)\d{2}',
        'month' => '0[1-9]|1[012]',
        'day'   => '0[1-9]|[12][0-9]|3[01]'
    );

    protected $_compiled;

    public function __construct($pattern, $defaults = null, $requirements = null) {
        $this->pattern = $pattern;
        if ($defaults) {
            $this->defaults = $defaults;
        }
        if ($requirements) {
            $this->requirements = $requirements;
        }
    }

    public function match($url) {
        $url = trim($url, '/');
        if ($url !== '') {
            $url = '/' . $url;
        }
        if (preg_match($this->compile(), $url, $matches)) {
            return $this->_clean(array_merge($this->defaults, $matches));
        }
        return false;
    }

    public function compile() {
        if (!$this->_compiled) {
            $compiled = preg_replace_callback('/\/?:(\w+)/', array($this, '_replaceParam'), trim($this->pattern, '/'));
            $this->_compiled = '/^' . $compiled . '$/';
        }
        return $this->_compiled;
    }

    protected function _replaceParam($matches) {
        $param = $matches[1];
        return sprintf(
            '(\/(?P<%s>%s))%s', $param,
            isset($this->requirements[$param]) ? $this->requirements[$param] : '[^\/]+',
            isset($this->defaults[$param]) ? '?' : ''
        );
    }

    protected function _clean($params) {
        foreach ($params as $k => $v) {
            if (is_integer($k) || $v === '') {
                unset($params[$k]);
            }
        }
        return $params;
    }

}