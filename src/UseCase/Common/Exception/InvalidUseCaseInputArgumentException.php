<?php

namespace KP\SOLID\UseCase;

use \Exception;
use \Throwable;

class InvalidUseCaseInputArgumentException extends Exception {

    protected $useCaseInput;
    protected $parameter;

    public function __construct(BaseUseCaseInput $useCaseInput, string $parameter, $message = '', $code = 0, Throwable $previous = null){
        parent::__construct($message, $code, $previous);
        $this->$useCaseInput = $useCaseInput;
        $this->parameter = $parameter;
    }

    public function getUseCaseInput() : BaseUseCase {
        return $this->useCaseInput;
    }

    public function getParameter() : string {
        return $this->parameter;
    }

    public function getValue() : string{
        return (string)$this->useCaseInput->{$this->parameter};
    }

}

