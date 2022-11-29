<?php

namespace KP\SOLID\Infra\Storage\Mysqli;

use \Exception;
use KP\SOLID\UseCase\IRepository;
use \Throwable;

class MysqliQueryStorageException extends MysqliStorageException {

    protected $host;
    protected $port;
    protected $database;
    protected $sql;

    public function __construct(string $host, string $port, string $database, string $sql, IRepository $repository, $message = '', $code = 0, Throwable $previous = null){
        parent::__construct($host, $port, $database, $repository, $message, $code, $previous);
        $this->sql = $sql;
        if(empty($message)){
            $this->message = "Query failer in " . get_class($this->repository) . " host: " . $this->host . ", port: " . $this->port . ", database = " . $this->database . ", sql = " . $this->sql;
        }
    }

    public function getSQL():string {
        return $this->sql;
    }

}

