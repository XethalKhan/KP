<?php

namespace KP\SOLID\UseCase\Page;

use KP\SOLID\UseCase\BaseUseCaseInput;

class SignUpPageUseCaseInput extends BaseUseCaseInput {

    public function __construct(){
    }

    public function __toString(){
        return get_class($this);
    }

}