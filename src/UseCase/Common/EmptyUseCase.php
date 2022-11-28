<?php

namespace KP\SOLID\UseCase;

abstract class EmptyUseCase extends BaseUseCase {

    public function __construct(){
        parent::__construct();
    }

    public function execute(BaseUseCaseInput $input) : BaseUseCaseOutput {
        return new EmptyUseCaseOutput();
    }

}