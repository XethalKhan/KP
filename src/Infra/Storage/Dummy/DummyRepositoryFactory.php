<?php

namespace KP\SOLID\Infra\Storage\Dummy;

use InvalidArgumentException;
use KP\SOLID\Infra\Storage\Dummy\BaseDummyRepository;
use KP\SOLID\Infra\Storage\Dummy\UserDummyRepository;
use KP\SOLID\UseCase\ILogger;
use KP\SOLID\UseCase\IRepositoryFactory;

class DummyRepositoryFactory implements IRepositoryFactory{

    private $logger;

    public function __construct(ILogger $logger){
        $this->logger = $logger;
    }

    public function create(string $input) : BaseDummyRepository {
        if($input === "USER"){
            return new UserDummyRepository($this->logger);
        }

        throw new InvalidArgumentException(__CLASS__ . " does not support input {$input}");
    }
}