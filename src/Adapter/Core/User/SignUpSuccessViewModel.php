<?php

namespace KP\SOLID\Adapter\Core;

use KP\SOLID\Adapter\BaseViewModel;

class SignUpSuccessViewModel extends BaseViewModel{

    private $email;
    
    public function __construct(string $email){
        $this->email = $email;
    }

    public function getEmail() : string {
        return $this->email;
    }
}