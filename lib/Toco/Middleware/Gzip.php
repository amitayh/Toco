<?php

/**
 * Middleware class for Gzipping response content
 *
 * @package Toco
 */
class Toco_Middleware_Gzip
{

    const GZIP_MARK = "\x1f\x8b\x08\x00\x00\x00\x00\x00";
    
    const COMPRESSION_LEVEL = 9;
    
    public function processResponse(Toco_Request $request, Toco_Response $response) {
        // Don't bother Gzipping unless the response status is OK, and content is more than 1KB
        if ($response->statusCode == 200 && strlen($response->content) >= 1024) {
            // Check if client's browser supports Gzip
            $encoding = false;
            foreach (array('x-gzip', 'gzip') as $encodingType) {
                if (strpos($request->headers['HTTP_ACCEPT_ENCODING'], $encodingType) !== false) {
                    $encoding = $encodingType;
                    break;
                }
            }
            if ($encoding !== false) {
                $content = self::GZIP_MARK . gzcompress($response->content, self::COMPRESSION_LEVEL);
                $response->headers[] = 'Content-Encoding: ' . $encoding;
                $response->headers[] = 'Content-Length: ' . strlen($content);
                $response->content = $content;
            }
        }
    }

}