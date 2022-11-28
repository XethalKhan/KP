<?php

namespace KP\SOLID\Infra\Configuration;

use KP\SOLID\UseCase\IConfiguration;

class JSONFileConfiguration implements IConfiguration {

    private $file;
    private $configurationMap;

    function __construct($file = './.config.json')
    {
        $this->file = $file;
        $this->configurationMap = array();
        $this->load();
    }

    private function load() : void {
        $fileHandle = fopen($this->file, 'r');
        flock($fileHandle, LOCK_EX);
        $content = fread($fileHandle, filesize($this->file));
        $this->populateMap(json_decode($content), $this->configurationMap);
        flock($fileHandle, LOCK_UN);
        fclose($fileHandle);
    }

    private function populateMap($input, &$map,  $parent = ''){
        if(is_string($input)){
            return;
        }
        foreach($input as $key => $value){
            if(is_string($value)){
                $map[$parent . "." . $key] = $value;
            }
            $parentKey = $parent === '' ? $key : $parent . "." . $key;
            $this->populateMap($value, $map, $parentKey);
        }
    }

    public function get($parameter) : string {
        return $this->has($parameter) ? $this->configurationMap[$parameter] : "";
    }

    public function has($parameter) : bool {
        return $this->configurationMap[$parameter] != NULL;
    }

}