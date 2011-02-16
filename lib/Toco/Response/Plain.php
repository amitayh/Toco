<?php

class Toco_Response_Plain extends Toco_Response
{

    public function __construct($content = null, $statusCode = 200) {
        return parent::__construct($content, $statusCode, 'text/plain');
    }

}