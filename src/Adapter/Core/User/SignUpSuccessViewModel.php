<?php

namespace KP\SOLID\Adapter\Core;

use KP\SOLID\Adapter\BaseViewModel;

class SignUpSuccessViewModel extends BaseViewModel{

    private $email;
    private $id;
    
    public function __construct(string $email, int $id){
        $this->email = $email;
        $this->id = $id;
    }

    public function getEmail() : string {
        return $this->email;
    }

    public function getID() : string {
        return $this->id;
    }
}