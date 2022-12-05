<?php

namespace KP\SOLID\Adapter;

use Exception;

class ExceptionViewModel extends BaseViewModel{

    protected $exception;

    public function __construct(Exception $exception){
        $this->exception = $exception;
    }

    public function getException() : Exception {
        return $this->exception;
    }
}