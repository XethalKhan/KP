<?php

namespace KP\SOLID\UseCase;

abstract class BaseUseCase {

    public function __construct(){

    }

    public abstract function execute(BaseUseCaseInput $input);

}