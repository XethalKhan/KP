<?php

namespace KP\SOLID\Adapter\Core;

use KP\SOLID\Adapter\BasePresenter;
use KP\SOLID\Adapter\BaseViewModel;
use KP\SOLID\UseCase\BaseUseCaseOutput;
use KP\SOLID\UseCase\Core\SignUpUseCaseOutput;

class UserPresenter extends BasePresenter {

    public function __construct(){

    }

    public function viewModelFactoryMethod(BaseUseCaseOutput $input) : BaseViewModel {
        if($input instanceof SignUpUseCaseOutput && $input->getSuccess()){
            return new SignUpSuccessViewModel($input->getEmail());
        }

        if($input instanceof SignUpUseCaseOutput && !($input->getSuccess())){
            $message = "error";

            if($input->isEmptyEmail()){
                $message = "email";
            }

            if($input->isEmailInvalid()){
                $message = "email_format";
            }

            if($input->isEmailBlacklisted()){
                $message = "email_blacklist";
            }

            if($input->isPasswordMismatch() || $input->doesUserAlreadyExist()){
                $message = "password_mismatch";
            }

            if($input->isPasswordInvalid()){
                $message = "password";
            }

            if($input->isPasswordRepeatInvalid()){
                $message = "password2";
            }

            return new SignUpErrorViewModel($input->getEmail(), $message);
        }

        return parent::viewModelFactoryMethod($input);
    }
}