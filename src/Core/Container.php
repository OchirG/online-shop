<?php

namespace Core;

class Container
{
    private array $services = [];

    public function get(string $className)
    {
        if(!isset($this->services[$className])){
            return new $className;
        }
        $callback = $this->services[$className];
        return $callback($this);
    }

    public function set(string $className, callable $callback)
    {
        $this->services[$className] = $callback;
    }

}