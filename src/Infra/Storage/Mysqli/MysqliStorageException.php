<?php

namespace KP\SOLID\Infra\Storage\Mysqli;

use \Exception;
use KP\SOLID\UseCase\IRepository;
use KP\SOLID\UseCase\StorageException;
use \Throwable;

class MysqliStorageException extends StorageException {

    protected $host;
    protected $port;
    protected $database;

    public function __construct(string $host, string $port, string $database, IRepository $repository, $message = '', $code = 0, Throwable $previous = null){
        parent::__construct($repository, $message, $code, $previous);
        $this->host = $host;
        $this->port = $port;
        $this->database = $database;
    }

    public function getHost():string {
        return $this->host;
    }

    public function getPost():string {
        return $this->port;
    }

    public function getDatabase():string {
        return $this->database;
    }

}

