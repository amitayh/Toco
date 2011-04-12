<?php

class Toco_Response_Json extends Toco_Response
{

    public $contentType = 'application/json';

    public function __construct($content = null, $statusCode = 200, $charset = 'utf-8') {
        parent::__construct(json_encode($content), $statusCode, $this->contentType, $charset);
    }

}