<?php

namespace KP\SOLID\UseCase;

use \Exception;
use \Throwable;

class LoggerException extends Exception {

    protected $logger;

    public function __construct(ILogger $logger, $message = '', $code = 0, Throwable $previous = null){
        parent::__construct($message, $code, $previous);
        $this->$logger = $logger;
    }

    public function getLogger() : ILogger {
        return $this->logger;
    }

}

