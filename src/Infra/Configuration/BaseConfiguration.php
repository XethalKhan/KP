<?php

namespace KP\SOLID\Infra\Configuration;

use KP\SOLID\UseCase\ConfigurationException;
use KP\SOLID\UseCase\IConfiguration;

abstract class BaseConfiguration implements IConfiguration {

    function __construct()
    {
        $this->load();
        $this->validate();
    }

    protected abstract function load() : void;

    protected function validate(){
        if(!$this->has("PASSWORD.MIN_LENGTH")){
            throw new ConfigurationException($this, "PASSWORD.MIN_LENGTH configuration not set");
        }

        if(!is_numeric($this->get("PASSWORD.MIN_LENGTH")) && !ctype_digit($this->get("PASSWORD.MIN_LENGTH"))){
            throw new ConfigurationException($this, "PASSWORD.MIN_LENGTH configuration must be integer value");
        }

        if(!$this->has("MAXMIND.USER")){
            throw new ConfigurationException($this, "MAXMIND.USER configuration not set");
        }

        if(!$this->has("MAXMIND.PASSWORD")){
            throw new ConfigurationException($this, "MAXMIND.PASSWORD configuration not set");
        }
    }

}