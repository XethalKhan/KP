<?php
namespace KP\SOLID\Domain;

class UserEntity extends BaseEntity{
    private $email;
    private $password;

    public function __construct(int $id, string $email, string $password){
        parent::__construct($id);
        $this->email = $email;
        $this->password = $password;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPassword(){
        return $this->password;
    }
}
