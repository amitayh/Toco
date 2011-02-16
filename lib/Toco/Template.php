<?php

/**
 * @package Toco
 */
abstract class Toco_Template
{

    /**
     * Toco template adapter
     * 
     * @var Toco_Template_Adapter_Interface
     */
    protected static $_adapter;

    /**
     * Get template adapter instance
     * 
     * @return Toco_Template_Adapter_Interface
     */
    public static function getAdapter() {
        if (!self::$_adapter) {
            $adapterClass = TEMPLATE_ADAPTER;
            $adapter = new $adapterClass();
            if (!$adapter instanceof Toco_Template_Adapter_Interface) {
                throw new Toco_Template_Exception(
                    'Template adapter must implement the Toco_Template_Adapter_Interface interface'
                );
            }
            self::$_adapter = $adapter;
        }
        return self::$_adapter;

    }

}