<?php

namespace KP\SOLID\Infra\Storage\Dummy;

use \Exception;
use KP\SOLID\Domain\UserEntity;
use KP\SOLID\UseCase\Core\CreateUserCommand;
use KP\SOLID\Infra\Storage\Dummy\BaseDummyRepository;
use KP\SOLID\UseCase\BaseQuery;
use KP\SOLID\UseCase\BaseQueryResult;
use KP\SOLID\UseCase\BaseCommand;
use KP\SOLID\UseCase\Core\UserQuery;
use KP\SOLID\UseCase\ILogger;

class UserDummyRepository extends BaseDummyRepository {

    private static $data = array();

    public function __construct(ILogger $logger, string $table = 'user'){
        parent::__construct($logger, $table);

        if(count(UserDummyRepository::$data) === 0){
            UserDummyRepository::$data[] = new UserEntity(1, 'pera.peric@example.loc', 'pera123');
            UserDummyRepository::$data[] =  new UserEntity(2, 'laza.lazic@example.loc', 'laza123');
        }
    }

    public function query(BaseQuery $query): BaseQueryResult
    {
        if(!($query instanceof UserQuery)){
            throw new Exception('Unsupported query in ' . __CLASS__);
        }

        $whereClause = "deleted = 0";

        if(!empty($query->getEmail())){
            $whereClause .= " AND email LIKE '%{$query->getEmail()}%'";
        }

        if(!empty($query->getPostedGreaterThan())){
            $whereClause .= " AND posted > '{$query->getPostedGreaterThan()}'";
        }

        $pagination = $query->getNumberOfRecords() * ($query->getPage() - 1);

        $sql = "SELECT * FROM {$this->table} WHERE {$whereClause} LIMIT {$pagination}, {$query->getNumberOfRecords()}";

        $this->logger->debug('Dummy repository ' . __CLASS__ . 'query: ' . $sql);

        $entities = [];

        foreach(UserDummyRepository::$data as $entity){
            if(!empty($query->getEmail()) && $query->getEmail() !== $entity->getEmail()){
                continue;
            }

            $entities[] = $entity;
        }

        return new BaseQueryResult($entities);
    }

    public function create(BaseCommand $command): void
    {
        if(!($command instanceof CreateUserCommand)){
            throw new Exception('Unsupported command in ' . get_class($this));
        }

        $sql = "INSERT INTO {$this->table} (email, password, posted) VALUES ('{$command->getEmail()}', '{$command->getPassword()}', '{$command->getPosted()}')";

        $this->logger->debug('Dummy repository ' . __CLASS__ . 'query: ' . $sql);

        $sql = "INSERT INTO {$this->table}_log (action, user_id, log_time) VALUES ('register', 100, NOW())";

        $this->logger->debug('Dummy repository ' . __CLASS__ . 'query: ' . $sql);

        $max = 0;
        foreach (UserDummyRepository::$data as $entity) {
            $current = $entity->getID();
            $max = $current > $max ? $current : $max;
        };

        UserDummyRepository::$data[] = new UserEntity($max, $command->getEmail(), $command->getPassword());

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
}