<?php

namespace KP\SOLID\Infra\App;

use \Exception;
use \Throwable;

class ActionLoaderException extends Exception {

    protected $actionLoader;

    public function __construct(BaseActionLoader $actionLoader, $message = '', $code = 0, Throwable $previous = null){
        parent::__construct($message, $code, $previous);
        $this->actionLoader = $actionLoader;
    }

    public function getActionLoader() : BaseActionLoader {
        return $this->actionLoader;
    }

}

