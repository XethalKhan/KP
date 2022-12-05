<?php

namespace KP\SOLID\UseCase;

use \Exception;
use \Throwable;

class ConfigurationException extends Exception {

    protected $configuration;

    public function __construct(IConfiguration $configuration, $message = '', $code = 0, Throwable $previous = null){
        parent::__construct($message, $code, $previous);
        $this->configuration = $configuration;
    }

    public function getConfiguration() : IConfiguration {
        return $this->configuration;
    }

}

