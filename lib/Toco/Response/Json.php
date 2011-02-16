<?php

class Toco_Response_Json extends Toco_Response
{

    public function __construct($content = null, $statusCode = 200, $contentType = 'application/json', $charset = 'utf-8') {
        parent::__construct(json_encode($content), $statusCode, $contentType, $charset);
    }

}