<?php

namespace KP\SOLID\UseCase;

class BaseUseCaseInteractor implements IInputGateway{

    protected $outputGateway;

    public function __construct(IOutputGateway $outputGateway){
        $this->outputGateway = $outputGateway;
    }

    public function send(BaseUseCaseInput $input) : void{
        $useCase = $this->useCaseFactoryMethod($input);
        $output = $useCase->execute($input);
        $this->outputGateway->send($output);
    }

    protected function useCaseFactoryMethod(BaseUseCaseInput $input) : BaseUseCase {
        return new EmptyUseCase();
    }

}