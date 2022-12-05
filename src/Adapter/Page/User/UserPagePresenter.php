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
            $emailError = "";
            $passwordError = "";

            if($input->isEmailInvalid()){
                $emailError = "Email is not in valid format<br/>";
            }

            if($input->isEmptyEmail()){
                $emailError = "Email must not be empty<br/>";
            }

            if($input->isEmailBlacklisted()){
                $emailError = "Email is blacklisted<br/>";
            }

            if($input->doesUserAlreadyExist()){
                $emailError = "User with specified email already exists<br/>";
            }

            if($input->isPasswordMismatch()){
                $passwordError .= "Passwords do not match<br/>";
            }

            if($input->isPasswordInvalid()){
                $passwordError .= "Password does not satisfy requirements<br/>";
            }

            if($input->isPasswordRepeatInvalid()){
                $passwordError .= "Repeated password does not satisfy requirements<br/>";
            }

            return new SignUpErrorViewModel($input->getEmail(), $emailError . $passwordError);
        }

        return parent::viewModelFactoryMethod($input);
    }
}