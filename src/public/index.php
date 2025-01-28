<?php
require_once './../Core/Autoload.php';
require_once './../Core/App.php';

use Controller\CartController;
use Controller\CatalogController;
use Controller\OrderController;
use Controller\UserController;
use Controller\UserProductController;
use Core\App;
use Core\Autoload;
use Service\Logger\LoggerFileService;


$rootPath = str_replace('public', '', __DIR__);
Autoload::autoload($rootPath);

$loggerService = new LoggerFileService();

$app = new App($loggerService);
$app->addRoute('/registration', 'GET', UserController::class,  'getRegistrationForm');
$app->addRoute('/registration', 'POST', UserController::class, 'handleRegistrationForm');
$app->addRoute('/login', 'GET', UserController::class, 'getLoginForm');
$app->addRoute('/login', 'POST', UserController::class, 'handleLoginForm');
$app->addRoute('/catalog', 'GET', CatalogController::class, 'getCatalogPage');
$app->addRoute('/add-product', 'GET', UserProductController::class, 'getAddProductForm');
$app->addRoute('/add-product', 'POST', UserProductController::class, 'handleAddUserProductForm');
$app->addRoute('/cart', 'GET', CartController::class, 'getCartPage');
$app->addRoute('/logout', 'GET', UserController::class, 'logout');
$app->addRoute('/remove-product', 'GET', CartController::class, 'removeProductFromCart');
$app->addRoute('/order', 'GET', OrderController::class, 'getOrderForm');
$app->addRoute('/order', 'POST', OrderController::class, 'handleOrder');
$app->addRoute('/order/confirm', 'GET', OrderController::class, 'getOrderConfirmForm');
$app->addRoute('/orders', 'GET', OrderController::class, 'getOrders');
$app->run();


//
//$autoloadCore = function (string $className) {
//    $path = "./../Core/$className.php";
//    if (file_exists($path)) {
//        require_once $path;
//        return true;
//    }
//    return false;
//};
//$autoloadController = function (string $className) {
//    $path = "./../Сontroller/$className.php";
//    if (file_exists($path)) {
//        require_once $path;
//        return true;
//    }
//    return false;
//};
//$autoloadModel = function (string $className) {
//    $path = "./../model/$className.php";
//    if (file_exists($path)) {
//        require_once $path;
//        return true;
//    }
//    return false;
//};
//spl_autoload_register($autoloadCore);
//spl_autoload_register($autoloadController);
//spl_autoload_register($autoloadModel);
