<?php

namespace KP\SOLID\UseCase\Core;

use InvalidArgumentException;
use KP\SOLID\UseCase\BaseCommand;

class CreateUserCommand extends BaseCommand {

    protected $email;
    protected $password;
    protected $posted;

    public function __construct(string $email, string $password, string $posted = 'now'){
        $this->email = $email;
        $this->password = $password;

        if($posted === ''){
            $this->posted = '';
        } else {
            $postedTimestamp = strtotime($posted);
            if($postedTimestamp === false){
                throw new InvalidArgumentException(__CLASS__ . " posted parameter format must be supported by strtotime");
            }
            $this->posted = date('Y-m-d H:i:s', $postedTimestamp);
        }
    }

    public function getEmail() : string {
        return $this->email;
    }

    public function getPassword() : string {
        return $this->password;
    }

    public function getPosted() : string {
        return $this->posted;
    }
}