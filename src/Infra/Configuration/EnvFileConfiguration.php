<?php

namespace KP\SOLID\Infra\Configuration;

use KP\SOLID\UseCase\IConfiguration;

class EnvFileConfiguration implements IConfiguration {

    private $file;
    private $configurationMap;

    function __construct($file = './.env')
    {
        $this->file = $file;
        $this->load();
    }

    private function load() : void {
        $lines = file($this->file);
        foreach ($lines as $line){
            $configuration = explode("=", $line);
            $this->configurationMap[$configuration[0]] = trim($configuration[1]);
        }

    }

    public function get($parameter) : string {
        return $this->has($parameter) ? $this->configurationMap[$parameter] : "";
    }

    public function has($parameter) : bool {
        return $this->configurationMap[$parameter] != NULL;
    }

}