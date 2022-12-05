<?php

namespace KP\SOLID\UseCase;

interface IConfiguration {

    public function get(string $parameter) : string;

    public function has(string $parameter) : bool;

}