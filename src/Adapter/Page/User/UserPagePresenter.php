<?php

namespace KP\SOLID\Adapter\Page;

use KP\SOLID\Adapter\BaseViewModel;
use KP\SOLID\Adapter\Core\SignUpErrorViewModel;
use KP\SOLID\Adapter\Core\UserPresenter;
use KP\SOLID\UseCase\BaseUseCaseOutput;
use KP\SOLID\UseCase\Core\SignUpUseCaseOutput;
use KP\SOLID\UseCase\Page\SignUpPageUseCaseOutput;

class UserPagePresenter extends UserPresenter {

    public function __construct(){

    }

    public function viewModelFactoryMethod(BaseUseCaseOutput $input) : BaseViewModel {
        if($input instanceof SignUpPageUseCaseOutput){
            return new SignUpPageViewModel('Minimum 8 characters for password');
        }

        if($input instanceof SignUpUseCaseOutput && !($input->getSuccess())){
            $message = "";

            if($input->isEmptyEmail()){
                $message .= "Email must not be empty<br/>";
            }

            if($input->isEmailInvalid()){
                $message .= "Email is not in valid format<br/>";
            }

            if($input->isEmailBlacklisted()){
                $message .= "Email is blacklisted<br/>";
            }

            if($input->isPasswordMismatch()){
                $message .= "Passwords do not match<br/>";
            }

            if($input->doesUserAlreadyExist()){
                $message .= "User with specified email already exists<br/>";
            }

            if($input->isPasswordInvalid()){
                $message .= "Password does not satisfy requirements<br/>";
            }

            if($input->isPasswordRepeatInvalid()){
                $message .= "Repeated password does not satisfy requirements<br/>";
            }

            return new SignUpErrorViewModel($input->getEmail(), $message);
        }

        return parent::viewModelFactoryMethod($input);
    }
}