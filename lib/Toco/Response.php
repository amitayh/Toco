<?php

/**
 * Basic HTTP response object
 *
 * @package Toco
 */
class Toco_Response
{

    /**
     * @var string
     */
    public $content;

    /**
     * @var int
     */
    public $statusCode;

    /**
     * @var string
     */
    public $contentType;

    /**
     * @var string
     */
    public $charset;

    /**
     * @var array
     */
    public $headers = array();

    /**
     * @var array
     */
    public static $httpStatus = array(
        // 1xx Informational
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',

        // 2xx Success
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        226 => 'IM Used',

        // 3xx Redirection
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',

        // 4xx Client Error
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        426 => 'Upgrade Required',

        // 5xx Server Error
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        507 => 'Insufficient Storage',
        510 => 'Not Extended'
    );

    /**
     * Constructor
     *
     * @param string $content
     * @param int $statusCode
     * @param string $contentType
     * @return void
     */
    public function __construct($content = null, $statusCode = 200, $contentType = 'text/html', $charset = 'utf-8') {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->contentType = $contentType;
        $this->charset = $charset;
        $this->headers['content-type'] = 'Content-Type: ' . $contentType . '; charset=' . $charset;
    }

    /**
     * Send response - send headers and flush content
     * 
     * @return void
     */
    public function send() {
        $this->sendHeaders();
        echo $this->content;
    }

    /**
     * Send headers
     * 
     * @return bool
     */
    public function sendHeaders() {
        if (!headers_sent()) {
            $statusMessage = 'HTTP/1.1 ' . $this->statusCode;
            if (isset(self::$httpStatus[$this->statusCode])) {
                $statusMessage .= ' ' . self::$httpStatus[$this->statusCode];
            }
            array_unshift($this->headers, $statusMessage);
            foreach ($this->headers as $header) {
                header($header);
            }
            return true;
        }
        return false;
    }

    /**
     * Helper method for quickly rendering a template by a filename and context
     *
     * @param string $templateFile
     * @param array $context
     * @param string $responseClass
     * @return Toco_Response
     */
    public static function renderToResponse($templateFile, $context = array(), $responseClass = 'Toco_Response') {
        $context['DEBUG'] = DEBUG;
        $context['BASE_URL'] = BASE_URL;
        $context['MEDIA_URL'] = MEDIA_URL;
        $adapter = Toco_Template::getAdapter();
        $content = $adapter->render($templateFile, $context);
        return new $responseClass($content);
    }

    /**
     * Get default error 404 response
     *
     * @param array $context
     * @return Toco_Response_404
     */
    public static function getResponse404($context = array()) {
        return self::renderToResponse('404.html', $context, 'Toco_Response_404');
    }

    /**
     * Get default error 500 response
     *
     * @param array $context
     * @return Toco_Response_500
     */
    public static function getResponse500($context = array()) {
        return self::renderToResponse('500.html', $context, 'Toco_Response_500');
    }

    /**
     * Shortcut method for settings cookies
     *
     * @param string $key
     * @param string $value
     * @param int $expires
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @return void
     */
    public function setCookie($key, $value = '', $expires = null, $path = '/', $domain = null, $secure = false) {
        setcookie($key, $value, $expires, $path, $domain, $secure);
    }

}