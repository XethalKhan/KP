<?php

namespace KP\SOLID\Domain;

class BaseEntity{
    private $id;

    public function __construct(int $id){
        $this->id = $id;
    }

    public function getID(): int{
        return $this->id;
    }
}
