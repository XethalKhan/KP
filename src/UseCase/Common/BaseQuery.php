<?php

namespace KP\SOLID\UseCase;

class BaseQuery{
    protected $numberOfRecords;
    protected $page;

    public function __construct(int $numberOfRecords = 10, int $page = 1){
        $this->numberOfRecords = $numberOfRecords;
        $this->page = $page;
    }

    public function getNumberOfRecords() : int {
        return $this->numberOfRecords;
    }

    public function getPage() : int {
        return $this->page;
    }
}