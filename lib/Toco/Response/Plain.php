<?php

class Toco_Response_Plain extends Toco_Response
{

    public $contentType = 'text/plain';

    public function __construct($content = null, $statusCode = 200, $charset = 'utf-8') {
        parent::__construct($content, $statusCode, $this->contentType, $charset);
    }

}