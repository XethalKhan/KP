<?php

namespace KP\SOLID\Adapter;

class BaseAction{
    public function __construct(){

    }

    public function __toString(){
        return get_class($this);
    }
}