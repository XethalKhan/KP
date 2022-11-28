<?php

namespace KP\SOLID\UseCase;

interface ISession {
    public function set(string $key, $value);
    public function get(string $key);
}