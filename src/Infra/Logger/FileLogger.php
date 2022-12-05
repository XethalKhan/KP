<?php

namespace KP\SOLID\Infra\Logger;

use KP\SOLID\UseCase\ILogger;
use KP\SOLID\UseCase\LoggerException;

class FileLogger implements ILogger{

    private $logFilePath;

    public function __construct($logFilePath = "solid.log"){
        $this->logFilePath = $logFilePath;
    }

    public function debug(string $entry): void
    {
        $this->write("[DEBUG][" . date('Y-m-d H:i:s') . "] {$entry}\n");
    }

    public function info(string $entry): void
    {
        $this->write("[INFO][" . date('Y-m-d H:i:s') . "] {$entry}\n");
    }

    public function warning(string $entry): void
    {
        $this->write("[WARNING][" . date('Y-m-d H:i:s') . "] {$entry}\n");
    }

    public function error(string $entry): void
    {
        $this->write("[ERROR][" . date('Y-m-d H:i:s') . "] {$entry}\n");
    }

    public function fatal(string $entry): void
    {
        $this->write("[FATAL][" . date('Y-m-d H:i:s') . "] {$entry}\n");
    }

    private function write(string $entry){
        $success = file_put_contents($this->logFilePath, $entry, LOCK_EX | FILE_APPEND);

        if($success === false){
            throw new LoggerException($this, "Logger " . get_class($this) . " failed to write to file {$this->logFilePath} entry {$entry}");
        }
    }
}