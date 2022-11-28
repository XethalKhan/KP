<?php

namespace KP\SOLID\UseCase;

interface ILogger {

    public function debug(string $entry) : void;

    public function info(string $entry) : void;

    public function warning(string $entry) : void;

    public function error(string $entry) : void;

    public function fatal(string $entry) : void;

}