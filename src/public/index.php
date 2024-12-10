<?php

$autoloadCore = function (string $className) {
    $path = "./../Core/$className.php";
    if (file_exists($path)) {
        require_once $path;
        return true;
    }
    return false;
};
$autoloadController = function (string $className) {
    $path = "./../controller/$className.php";
    if (file_exists($path)) {
        require_once $path;
        return true;
    }
    return false;
};
$autoloadModel = function (string $className) {
    $path = "./../model/$className.php";
    if (file_exists($path)) {
        require_once $path;
        return true;
    }
    return false;
};



spl_autoload_register($autoloadCore);
spl_autoload_register($autoloadController);
spl_autoload_register($autoloadModel);

$app = new App();
$app->run();


