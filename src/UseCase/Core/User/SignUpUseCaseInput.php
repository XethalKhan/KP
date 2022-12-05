<?php

namespace KP\SOLID\UseCase\Core;

use KP\SOLID\UseCase\BaseUseCaseInput;

class SignUpUseCaseInput extends BaseUseCaseInput {

    private $email;
    private $password;
    private $passwordRepeat;

    public function __construct(string $email, string $password, string $passwordRepeat){
        $this->email = $email;
        $this->password = $password;
        $this->passwordRepeat = $passwordRepeat;
    }

    public function getEmail() : string {
        return $this->email;
    }

    public function getPassword() : string {
        return $this->password;
    }

    public function getPasswordRepeat() : string {
        return $this->passwordRepeat;
    }

    public function __toString(){
        return get_class($this);
    }

}