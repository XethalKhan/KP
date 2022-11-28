<?php

namespace KP\SOLID\Adapter\Page;

use KP\SOLID\Adapter\BaseViewModel;

class SignUpPageViewModel extends BaseViewModel{

    private $passwordRequirementsMessage;
    
    public function __construct(string $passwordRequirementsMessage){
        $this->passwordRequirementsMessage = $passwordRequirementsMessage;
    }

    public function getPasswordRequirementsMessage() : string {
        return $this->passwordRequirementsMessage;
    }

}