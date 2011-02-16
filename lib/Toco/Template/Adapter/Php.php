<?php

/**
 * Adapter for rendering pure PHP template
 * 
 * @package Toco
 */
class Toco_Template_Adapter_Php implements Toco_Template_Adapter_Interface
{

    public function render($templateFile, $context) {
        $filename = TEMPLATES_PATH . '/' . $templateFile;
        if (!is_file($filename)) {
            throw new Toco_Template_Exception('Template file does not exist: ' . $filename);
        }
        ob_start();
        include $filename;
        return ob_get_clean();
    }

}