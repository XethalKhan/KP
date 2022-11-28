<?php

namespace KP\SOLID\Infra\App;

use KP\SOLID\Adapter\BaseAction;
use KP\SOLID\Adapter\EmptyAction;

class BaseActionLoader{
    public function create() : BaseAction{
        return new EmptyAction();
    }
}