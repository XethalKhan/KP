<?php

namespace KP\SOLID\Adapter\Core;

use KP\SOLID\Adapter\BaseAction;
use KP\SOLID\Adapter\BaseController;
use KP\SOLID\UseCase\BaseUseCaseInput;
use KP\SOLID\UseCase\IInputGateway;
use KP\SOLID\UseCase\ILogger;
use KP\SOLID\UseCase\Core\SignUpUseCaseInput;

class UserController extends BaseController{

    public function __construct(IInputGateway $inputGateway, ILogger $logger){
        parent::__construct($inputGateway, $logger);
    }

    protected function useCaseInputFactoryMethod(BaseAction $input) : BaseUseCaseInput {
        if($input instanceof SignUpAction) {
            return new SignUpUseCaseInput($input->getEmail(), $input->getPassword(), $input->getPasswordRepeat());
        }

        return parent::useCaseInputFactoryMethod($input);
    }
    
}