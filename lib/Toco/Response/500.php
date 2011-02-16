<?php

class Toco_Response_500 extends Toco_Response
{

    public $statusCode = 500;

    public function __construct($content = '500 - Internal Server Error', $contentType = 'text/html') {
        return parent::__construct($content, $this->statusCode, $contentType);
    }

}
