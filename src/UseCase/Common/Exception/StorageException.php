<?php

namespace KP\SOLID\UseCase;

use \Exception;
use \Throwable;

class StorageException extends Exception {

    protected $repository;

    public function __construct(IRepository $repository, $message = '', $code = 0, Throwable $previous = null){
        parent::__construct($message, $code, $previous);
        $this->repository = $repository;
        if(empty($message)){
            $this->message = 'Error in repository ' . get_class($repository);
        }
    }

    public function getRepository() : IRepository {
        return $this->repository;
    }

}

