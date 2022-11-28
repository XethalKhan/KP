<?php

namespace KP\SOLID\Infra\Storage\Mysqli;

use \Exception;
use KP\SOLID\Domain\UserEntity;
use KP\SOLID\UseCase\Core\CreateUserCommand;
use KP\SOLID\UseCase\BaseQuery;
use KP\SOLID\UseCase\BaseQueryResult;
use KP\SOLID\UseCase\BaseCommand;
use KP\SOLID\UseCase\Core\UserQuery;

class UserMysqliRepository extends BaseMysqliRepository {

    public function __construct(string $host, string $user, string $password, string $database, int $port = 3306, string $table = 'user'){
        parent::__construct($table, $host, $user, $password, $database, $port);
    }

    public function query(BaseQuery $query): BaseQueryResult
    {
        if(!($query instanceof UserQuery)){
            throw new Exception('Unsupported query in ' . get_class($this));
        }

        $connection = $this->createConnection();
        $sql = $this->generateSQLFromQuery($query);
        $sqlResultSet = $connection->query($sql);

        $entities = [];

        while($row = $sqlResultSet->fetch_assoc()) {
            $entities[] = new UserEntity($row['id'], $row['email'], $row['password']);
        }

        $connection->close();

        return new BaseQueryResult($entities);
    }

    public function create(BaseCommand $command): void
    {
        if(!($command instanceof CreateUserCommand)){
            throw new Exception('Unsupported command in ' . get_class($this));
        }

        $connection = $this->createConnection();
        $connection->begin_transaction();

        $sql = "INSERT INTO {$this->table} (email, password, posted) VALUES ('{$command->getEmail()}', '{$command->getPassword()}', '{$command->getPosted()}')";
        $insertIntoTableSuccess = $connection->query($sql);

        if(!$insertIntoTableSuccess){
            $connection->rollback();
            return;
        }

        $newUserID = $connection->insert_id;

        $sql = "INSERT INTO {$this->table}_log (action, user_id, log_time) VALUES ('register', {$newUserID}, NOW())";
        $insertIntoLogTableSuccess = $connection->query($sql);

        if(!$insertIntoLogTableSuccess){
            $connection->rollback();
            return;
        }

        $connection->commit();

        return;
    }

    public function update(BaseCommand $command): void
    {
        return;
    }

    public function delete(BaseCommand $command): void
    {
        return;
    }

    protected function generateWhereClauseFromQuery(BaseQuery $query) : string {

        if(!($query instanceof UserQuery)){
            throw new Exception('Unsupported query in ' . get_class($this));
        }
        
        $whereClause = "";

        if(!empty($query->getEmail())){
            $whereClause .= " AND email LIKE '%{$query->getEmail()}%'";
        }

        if(!empty($query->getPostedGreaterThan())){
            $whereClause .= " AND posted > '{$query->getPostedGreaterThan()}'";
        }

        return $whereClause;
    }
}