<?php

namespace KP\SOLID\UseCase;

interface IInputGateway{
    public function send(BaseUseCaseInput $input) : void;
}