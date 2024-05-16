<?php

namespace Yui\Core\Helpers;

/**
 * The base class for all stub parsers.
 * @package Yui\Core\Helpers
 */
class StubParser
{
    public string $stubContent;

    public function __construct($stubName){
        $this->load($stubName);
    }

    public function load($stubName){
        $this->stubContent = file_get_contents("core/Stubs/{$stubName}.stub");
    }

    public function parse(string $variable, $value){
        $this->stubContent = str_replace("{{{$variable}}}", $value, $this->stubContent);
    }

    public function parseMultiple(array $variables){
        foreach($variables as $variable => $value){
            $this->parse($variable, $value);
        }
    }

    public function get(){
        return $this->stubContent;
    }
}