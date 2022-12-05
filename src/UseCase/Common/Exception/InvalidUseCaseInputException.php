<?php

namespace KP\SOLID\UseCase;

use \Exception;
use \Throwable;

class InvalidUseCaseInputException extends Exception {

    protected $useCase;
    protected $useCaseInput;

    public function __construct(BaseUseCase $useCase, BaseUseCaseInput $useCaseInput, $message = '', $code = 0, Throwable $previous = null){
        parent::__construct($message, $code, $previous);
        $this->$useCase = $useCase;
        $this->$useCaseInput = $useCaseInput;
        if($message !== ''){
            $this->message = "Use case " . get_class($useCase) . "does not support input " . get_class($useCaseInput) . "!";
        }
    }

    public function getUseCase() : BaseUseCase {
        return $this->useCase;
    }

    public function getUseCaseInput() : BaseUseCaseInput {
        return $this->useCaseInput;
    }

}

