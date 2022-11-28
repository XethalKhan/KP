<?php

namespace KP\SOLID\UseCase\Core;

use InvalidArgumentException;
use KP\SOLID\UseCase\BaseQuery;

class UserQuery extends BaseQuery {

    protected $email;
    protected $postedGreaterThan;

    public function __construct(string $email, string $postedGreaterThan = '', int $numberOfRecords = 10, int $page = 1){
        parent::__construct($numberOfRecords, $page);
        $this->email = $email;
        if($postedGreaterThan === ''){
            $this->postedGreaterThan = '';
        } else {
            $postedGreaterThanTimestamp = strtotime($postedGreaterThan);
            if($postedGreaterThanTimestamp === false){
                throw new InvalidArgumentException(__CLASS__ . " posted parameter format must be supported by strtotime");
            }
            $this->postedGreaterThan = date('Y-m-d h:i:s', $postedGreaterThanTimestamp);
        }
    }

    public function getEmail() : string {
        return $this->email;
    }

    public function getPostedGreaterThan() : string {
        return $this->postedGreaterThan;
    }
}