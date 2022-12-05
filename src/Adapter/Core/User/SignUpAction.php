<?php

namespace KP\SOLID\Adapter\Core;

use KP\SOLID\Adapter\BaseAction;

class SignUpAction extends BaseAction{

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
        return parent::__toString() . " email = {$this->getEmail()}, password = {$this->getPassword()}, repeated password = {$this->getPasswordRepeat()}";
    }
}