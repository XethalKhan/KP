<?php

namespace KP\SOLID\UseCase;

interface IRepositoryFactory {
    public function create(string $input);
}