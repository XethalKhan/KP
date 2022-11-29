<?php

namespace KP\SOLID\Infra\App;

use \Exception;
use \Throwable;

class ServiceContainerException extends Exception {

    protected $serviceContainer;

    public function __construct(BaseServiceContainer $serviceContainer, $message = '', $code = 0, Throwable $previous = null){
        parent::__construct($message, $code, $previous);
        $this->serviceContainer = $serviceContainer;
    }

    public function getServiceContainer() : BaseServiceContainer {
        return $this->serviceContainer;
    }

}

