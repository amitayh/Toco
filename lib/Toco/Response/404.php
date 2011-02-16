<?php

class Toco_Response_404 extends Toco_Response
{

    public $statusCode = 404;

    public function __construct($content = '404 - Page Not Found', $contentType = 'text/html') {
        return parent::__construct($content, $this->statusCode, $contentType);
    }

}