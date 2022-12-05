<?php

namespace KP\SOLID\Adapter\Page;

use KP\SOLID\Adapter\BaseAction;
use KP\SOLID\Adapter\Core\UserController;
use KP\SOLID\UseCase\BaseUseCaseInput;
use KP\SOLID\UseCase\IInputGateway;
use KP\SOLID\UseCase\ILogger;
use KP\SOLID\UseCase\Page\SignUpPageUseCaseInput;

class UserPageController extends UserController{

    public function __construct(IInputGateway $inputGateway, ILogger $logger){
        parent::__construct($inputGateway, $logger);
    }

    protected function useCaseInputFactoryMethod(BaseAction $input) : BaseUseCaseInput {
        if($input instanceof SignUpPageAction) {
            return new SignUpPageUseCaseInput();
        }

        return parent::useCaseInputFactoryMethod($input);
    }
    
}