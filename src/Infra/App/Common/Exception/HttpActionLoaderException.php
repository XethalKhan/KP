<?php

namespace KP\SOLID\Infra\App;

use \Throwable;

class HttpActionLoaderException extends ActionLoaderException {

    protected $method;
    protected $url;
    protected $body;

    public function __construct(BaseActionLoader $actionLoader, string $method, string $url, string $body, $message = '', $code = 0, Throwable $previous = null){
        parent::__construct($actionLoader, $message, $code, $previous);
        $this->$method = $method;
        $this->$url = $url;
        $this->$body = $body;
    }

    public function getMethod() : string {
        return $this->method;
    }

    public function getUrl() : string {
        return $this->url;
    }

    public function getBody() : string {
        return $this->body;
    }

}

