<?php

namespace KP\SOLID\UseCase;

abstract class EmptyUseCaseInteractor extends BaseUseCaseInteractor{

    public function __construct(IOutputGateway $outputGateway){
        parent::__construct($outputGateway);
    }

    protected function useCaseFactoryMethod(BaseUseCaseInput $input) : BaseUseCase{
        return new EmptyUseCase();
    }

}