<?php

namespace KP\SOLID\Adapter;

use KP\SOLID\UseCase\BaseUseCaseInput;
use KP\SOLID\UseCase\EmptyUseCaseInput;
use KP\SOLID\UseCase\ILogger;
use KP\SOLID\UseCase\IInputGateway;

class BaseController{

    protected $inputGateway;
    protected $logger;

    public function __construct(IInputGateway $inputGateway, ILogger $logger){
        $this->inputGateway = $inputGateway;
        $this->logger = $logger;
    }

    public function execute(BaseAction $action) : void {
        $this->logger->debug("Action {$action} sent to controller " . get_class($this));

        $useCaseInput = $this->useCaseInputFactoryMethod($action);

        $this->logger->debug("Use case input created in " . get_class($this) . " use case input factory from action {$action} is {$useCaseInput}");
        
        $this->inputGateway->send($useCaseInput);
    }

    protected function useCaseInputFactoryMethod(BaseAction $input) : BaseUseCaseInput {
        return new EmptyUseCaseInput();
    }

    public function __toString(){
        return get_class($this);
    }
}