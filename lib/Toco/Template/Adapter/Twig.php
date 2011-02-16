<?php

/**
 * Adapter which uses Twig (Toco's default template engine)
 * 
 * @package Toco
 */
class Toco_Template_Adapter_Twig implements Toco_Template_Adapter_Interface
{

    /**
     * @var Twig_Environment
     */
    protected $_twig;

    /**
     * Constructor
     */
    public function __construct() {
        // Setup Twig
        $loader = new Twig_Loader_Filesystem(TEMPLATES_PATH);
        $options = array('debug' => DEBUG);
        if (!DEBUG) {
            $options['cache'] = CACHE_PATH . '/templates';
        }
        $this->_twig = new Twig_Environment($loader, $options);
    }

    public function render($templateFile, $context) {
        $template = $this->_twig->loadTemplate($templateFile);
        return $template->render($context);
    }

}