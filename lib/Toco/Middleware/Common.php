<?php

/**
 * @package Toco
 */
class Toco_Middleware_Common
{

    /**
     * Return default error responses when catching exceptions
     * 
     * @param Toco_Request $request
     * @param Exception $exception
     * @return Toco_Response_404|Toco_Response_500
     */
    public function processException(Toco_Request $request, Exception $exception) {
        $context = array('exception' => $exception);
        if ($exception instanceof Toco_Exception_404) {
            return Toco_Response::getResponse404($context);
        }
        return Toco_Response::getResponse500($context);
    }

}