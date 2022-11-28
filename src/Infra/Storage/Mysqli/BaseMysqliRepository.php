<?php

namespace KP\SOLID\Infra\Storage\Mysqli;

use mysqli;
use RuntimeException;
use KP\SOLID\UseCase\BaseQuery;
use KP\SOLID\UseCase\IRepository;

abstract class BaseMysqliRepository implements IRepository {

    protected $table;
    private $host;
    private $user;
    private $password;
    private $database;
    private $port;

    public function __construct(string $table, string $host, string $user, string $password, string $database, int $port = 3306){
        $this->table = $table;
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $this->port = $port;
    }

    protected function generateSQLFromQuery(BaseQuery $query) : string{
        $whereClause = "deleted = 0";

        $whereClauseFromQuery = $this->generateWhereClauseFromQuery($query);

        if(!empty($whereClauseFromQuery)){
            $whereClause .= " {$whereClauseFromQuery}";
        }

        $pagination = $query->getNumberOfRecords() * ($query->getPage() - 1);

        return "SELECT * FROM {$this->table} WHERE {$whereClause} LIMIT {$pagination}, {$query->getNumberOfRecords()}";
    }

    protected function createConnection() : mysqli{
        $connection = new mysqli($this->host, $this->user, $this->password, $this->database, $this->port);

        if ($connection->connect_errno) {
            throw new RuntimeException('mysqli connection error: ' . $connection->connect_error);
        }

        return $connection;
    }

    protected abstract function generateWhereClauseFromQuery(BaseQuery $query) : string;

}