<?php

namespace KP\SOLID\Infra\Configuration;

use KP\SOLID\UseCase\ConfigurationException;

class EnvFileConfiguration extends BaseFileConfiguration {

    function __construct($file = './.env')
    {
        parent::__construct($file);
    }

    protected function load() : void {
        $lines = file($this->file);
        foreach ($lines as $line){
            $configuration = explode("=", $line);
            if(count($configuration) !== 2){
                throw new ConfigurationException($this, "Invalid configuration definition for parameter {$configuration[0]} in file {$this->file}");
            }
            $this->configurationMap[$configuration[0]] = trim($configuration[1]);
        }

    }

}