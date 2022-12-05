<?php

namespace KP\SOLID\UseCase\Page;

use \Exception;
use KP\SOLID\UseCase\BaseUseCase;
use KP\SOLID\UseCase\BaseUseCaseInput;
use KP\SOLID\UseCase\BaseUseCaseOutput;

class SignUpPageUseCase extends BaseUseCase {

    public function __construct(){
    }

    public function execute(BaseUseCaseInput $input){
        if(!($input instanceof SignUpPageUseCaseInput)){
            throw new Exception("Invalid type of input ${get_class($input)} for use case {get_class($this)}");
        }

        return new SignUpPageUseCaseOutput();
    }

}