<?php

namespace KP\SOLID\UseCase\Core;

use KP\SOLID\UseCase\BaseUseCaseOutput;

class SignUpUseCaseOutput extends BaseUseCaseOutput {

    private $email;
    private $id;
    private $success;

    public function __construct(string $email, int $id, int $success){
        $this->email = $email;
        $this->id = $id;
        $this->success = $success;
    }

    public function getEmail() : string {
        return $this->email;
    }

    public function getID() : string {
        return $this->id;
    }

    public function isEmptyEmail() : bool {
        return $this->success & SIGN_UP_USE_CASE_ERROR_EMPTY_EMAIL;
    }

    public function isEmailInvalid() : bool {
        return $this->success & SIGN_UP_USE_CASE_ERROR_INVALID_EMAIL_FORMAT;
    }

    public function isEmailBlacklisted() : bool {
        return $this->success & SIGN_UP_USE_CASE_ERROR_BLACKLISTED_EMAIL;
    }

    public function isPasswordMismatch() : bool {
        return $this->success & SIGN_UP_USE_CASE_ERROR_PASSWORD_MISMATCH;
    }

    public function isPasswordInvalid() : bool {
        return $this->success & SIGN_UP_USE_CASE_ERROR_INVALID_PASSWORD;
    }

    public function isPasswordRepeatInvalid() : bool {
        return $this->success & SIGN_UP_USE_CASE_ERROR_INVALID_PASSWORD_REPEAT;
    }

    public function doesUserAlreadyExist() : bool {
        return $this->success & SIGN_UP_USE_CASE_ERROR_USER_EXISTS;
    }

    public function storageError() : bool {
        return $this->success & SIGN_UP_USE_CASE_STORAGE_ERROR;
    }

    public function getSuccess() : bool {
        return $this->success == SIGN_UP_USE_CASE_NO_ERRORS;
    }

}