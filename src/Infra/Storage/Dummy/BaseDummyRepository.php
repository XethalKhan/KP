<?php

namespace KP\SOLID\Infra\Storage\Dummy;

use KP\SOLID\UseCase\ILogger;
use KP\SOLID\UseCase\IRepository;

abstract class BaseDummyRepository implements IRepository {

    protected $logger;
    protected $table;

    public function __construct(ILogger $logger, string $table){
        $this->logger = $logger;
        $this->table = $table;
    }

}