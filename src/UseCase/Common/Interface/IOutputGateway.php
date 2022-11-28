<?php

namespace KP\SOLID\UseCase;

interface IOutputGateway{
    public function send(BaseUseCaseOutput $input) : void;
}