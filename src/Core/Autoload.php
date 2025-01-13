<?php

namespace Core;

class Autoload
{
    public static function autoload(string $rootPath)
    {
        $autoload = function (string $className) use ($rootPath)
        {
            $classPath = str_replace("\\", "/", $className);
            $path = $rootPath . $classPath . '.php';

            if (file_exists($path)) {
                require_once $path;
                return true;
            }
            return false;
        };

        spl_autoload_register($autoload);
    }
}