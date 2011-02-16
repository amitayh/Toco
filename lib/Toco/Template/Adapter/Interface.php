<?php

/**
 * Template adapters must implement this interface in order to work properly with Toco
 * 
 * @package Toco
 */
interface Toco_Template_Adapter_Interface
{

    /**
     * Render a template file with a context
     *
     * @var string $templateFile
     * @var array $context
     * @return string
     */
    public function render($templateFile, $context);

}