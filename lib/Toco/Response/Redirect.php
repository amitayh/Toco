<?php

class Toco_Response_Redirect extends Toco_Response
{

    public function __construct($location, $statusCode = 301) {
        $this->statusCode = $statusCode;
        $this->headers[] = 'Location: ' . $location;
    }

}