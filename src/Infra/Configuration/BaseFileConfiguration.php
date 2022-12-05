<?php

namespace KP\SOLID\Infra\Configuration;

abstract class BaseFileConfiguration extends BaseConfiguration {

    protected $file;
    protected $configurationMap;

    function __construct($file)
    {
        $this->file = $file;
        $this->configurationMap = array();
        parent::__construct();
    }

    protected abstract function load() : void;

    public function get($parameter) : string {
        return $this->has($parameter) ? $this->configurationMap[$parameter] : "";
    }

    public function has($parameter) : bool {
        return isset($this->configurationMap[$parameter]);
    }

}