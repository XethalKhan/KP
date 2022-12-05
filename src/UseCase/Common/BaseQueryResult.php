<?php

namespace KP\SOLID\UseCase;

use KP\SOLID\Domain\BaseEntity;

class BaseQueryResult{
    private $records;
    private $page;

    public function __construct(array $records = array(), int $page = 1){
        $this->records = $records;
        $this->page = $page;
    }

    public function getPage() : int {
        return $this->page;
    }

    public function getRecords() : array {
        return $this->records;
    }

    public function getNumberOfRecords() : int {
        return count($this->records);
    }
}