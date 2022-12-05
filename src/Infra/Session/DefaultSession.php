<?php

namespace KP\SOLID\Infra\Session;

use KP\SOLID\UseCase\ISession;

class DefaultSession implements ISession{
    public function __construct(){
        session_start();
    }

    public function set(string $key, $value){
        $_SESSION[$key] = $value;
    }

    public function get(string $key){
        return $_SESSION[$key];
    }
}