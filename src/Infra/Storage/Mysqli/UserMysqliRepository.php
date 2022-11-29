<?php

namespace KP\SOLID\Infra\Storage\Mysqli;

use \Exception;
use KP\SOLID\Domain\UserEntity;
use KP\SOLID\UseCase\Core\CreateUserCommand;
use KP\SOLID\UseCase\BaseQuery;
use KP\SOLID\UseCase\BaseQueryResult;
use KP\SOLID\UseCase\BaseCommand;
use KP\SOLID\UseCase\Core\UserQuery;
use KP\SOLID\UseCase\StorageException;

class UserMysqliRepository extends BaseMysqliRepository {

    public function __construct(string $host, string $user, string $password, string $database, int $port = 3306, string $table = 'user'){
        parent::__construct($table, $host, $user, $password, $database, $port);
    }

    public function query(BaseQuery $query): BaseQueryResult
    {
        if(!($query instanceof UserQuery)){
            throw new StorageException($this, "Unsupported query {${get_class($query)}} in {${__CLASS__}}");
        }

        $connection = $this->createConnection();
        $sql = $this->generateSQLFromQuery($query);
        $sqlResultSet = $connection->query($sql);

        if($sqlResultSet === false){
            throw new MysqliQueryStorageException($this->host, $this->port, $this->database, $sql, $this, $connection->error, $connection->errno);
        }

        $entities = [];

        while($row = $sqlResultSet->fetch_assoc()) {
            $entities[] = new UserEntity($row['id'], $row['email'], $row['password']);
        }

        if(!$connection->close()){
            throw new MysqliStorageException($this->host, $this->port, $this->database, $this, "Closing connection failed. {$connection->error}", $connection->errno);
        }

        return new BaseQueryResult($entities);
    }

    public function create(BaseCommand $command): void
    {
        if(!($command instanceof CreateUserCommand)){
            throw new Exception('Unsupported command in ' . get_class($this));
        }

        $connection = $this->createConnection();

        if(!$connection->begin_transaction()){
            throw new MysqliStorageException($this->host, $this->port, $this->database, $this, "Transaction not started. {$connection->error}", $connection->errno);
        }

        $sql = "INSERT INTO {$this->table} (email, password, posted) VALUES (?, ?, ?)";
        $preparedStatement = $connection->prepare($sql);

        if($preparedStatement === false){
            throw new MysqliStorageException($this->host, $this->port, $this->database, $this, "Prepared statement not created for query {$sql}. {$connection->error}", $connection->errno);
        }

        if(!$preparedStatement->bind_param("sss", $command->getEmail(), $command->getPassword(), $command->getPosted())){
            throw new MysqliStorageException($this->host, $this->port, $this->database, $this, "Parameters not bound to prepared statement for query {$sql} and parameters email = {$command->getEmail()} password = {$command->getPassword()} posted = {$command->getPosted()}. {$preparedStatement->error}", $preparedStatement->errno);
        }

        if($preparedStatement->execute() === false){
            $exception = new MysqliQueryStorageException($this->host, $this->port, $this->database, $sql, $this, $preparedStatement->error, $preparedStatement->errno);
            if(!$connection->rollback()){
                throw new MysqliStorageException($this->host, $this->port, $this->database, $this, "Rollback failed. {$connection->error}", $connection->errno, $exception);
            }
            throw $exception;
        }

        $newUserID = $connection->insert_id;
        $sql = "INSERT INTO {$this->table}_log (action, user_id, log_time) VALUES ('register', ?, NOW())";
        $preparedStatement = $connection->prepare($sql);

        if($preparedStatement === false){
            throw new MysqliStorageException($this->host, $this->port, $this->database, $this, "Prepared statement not created for query {$sql}. {$connection->error}", $connection->errno);
        }

        if(!$preparedStatement->bind_param("i", $newUserID)){
            throw new MysqliStorageException($this->host, $this->port, $this->database, $this, "Email parameter not bound to prepared statement for query {$sql}. {$connection->error}", $connection->errno);
        }

        if($preparedStatement->execute() === false){
            $exception = new MysqliQueryStorageException($this->host, $this->port, $this->database, $sql, $this, $connection->error, $connection->errno);
            if(!$connection->rollback()){
                throw new MysqliStorageException($this->host, $this->port, $this->database, $this, "Rollback failed. " . $connection->error, $connection->errno, $exception);
            }
            throw $exception;
        }

        if(!$connection->commit()){
            throw new MysqliStorageException($this->host, $this->port, $this->database, $this, "Commit failed. " . $connection->error, $connection->errno);
        }

        if(!$connection->close()){
            throw new MysqliStorageException($this->host, $this->port, $this->database, $this, "Closing connection failed. {$connection->error}", $connection->errno);
        }

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