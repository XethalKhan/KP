<?php

namespace KP\SOLID\Infra\Storage\Mysqli;

use InvalidArgumentException;
use KP\SOLID\UseCase\IRepositoryFactory;

class MysqliRepositoryFactory implements IRepositoryFactory{

    private $host;
    private $user;
    private $password;
    private $database;
    private $port;

    public function __construct(string $host, string $user, string $password, string $database, int $port = 3306){
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $this->port = $port;
    }

    public function create(string $input) : BaseMysqliRepository {
        if($input === "USER"){
            return new UserMysqliRepository($this->host, $this->user, $this->password, $this->database, $this->port);
        }

        throw new InvalidArgumentException("MysqliRepositoryFactory does not support input {$input}");
    }
}