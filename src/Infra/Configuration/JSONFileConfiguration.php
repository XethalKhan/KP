<?php

namespace KP\SOLID\Infra\Configuration;

class JSONFileConfiguration extends BaseFileConfiguration {

    function __construct($file = './.config.json')
    {
        parent::__construct($file);
    }

    protected function load() : void {
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


}