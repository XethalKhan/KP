<?php

namespace KP\SOLID\UseCase;

interface IMailValidator{
    public function validate(string $email) : bool;
}