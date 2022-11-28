<?php

namespace KP\SOLID\UseCase\Core;

use KP\SOLID\UseCase\BaseUseCaseOutput;

class SignUpUseCaseOutput extends BaseUseCaseOutput {

    private $email;

    private $emptyEmail;
    private $emailInvalid;
    private $passwordMismatch;
    private $passwordInvalid;
    private $passwordRepeatInvalid;
    private $userAlreadyExist;

    public function __construct(string $email, bool $emptyEmail, bool $emailInvalid, bool $emailBlacklisted, bool $passwordMismatch, bool $passwordInvalid, bool $passwordRepeatInvalid, bool $userAlreadyExist){
        $this->email = $email;
        $this->emptyEmail = $emptyEmail;
        $this->emailInvalid = $emailInvalid;
        $this->emailBlacklisted = $emailBlacklisted;
        $this->passwordMismatch = $passwordMismatch;
        $this->passwordInvalid = $passwordInvalid;
        $this->passwordRepeatInvalid = $passwordRepeatInvalid;
        $this->userAlreadyExist = $userAlreadyExist;
    }

    public function getEmail() : string {
        return $this->email;
    }

    public function isEmptyEmail() : bool {
        return $this->emptyEmail;
    }

    public function isEmailInvalid() : bool {
        return $this->emailInvalid;
    }

    public function isEmailBlacklisted() : bool {
        return $this->emailBlacklisted;
    }

    public function isPasswordMismatch() : bool {
        return $this->passwordMismatch;
    }

    public function isPasswordInvalid() : bool {
        return $this->passwordInvalid;
    }

    public function isPasswordRepeatInvalid() : bool {
        return $this->passwordRepeatInvalid;
    }

    public function doesUserAlreadyExist() : bool {
        return $this->userAlreadyExist;
    }

    public function getSuccess() : bool {
        return 
            !$this->emptyEmail
            && !$this->emailInvalid
            && !$this->emailBlacklisted
            && !$this->passwordMismatch
            && !$this->passwordInvalid
            && !$this->passwordRepeatInvalid
            && !$this->userAlreadyExist;
    }

}