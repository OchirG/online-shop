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
use Core\Container;
use Model\Order;
use Model\OrderProduct;
use Model\UserProduct;
use Service\CartService;
use Service\Logger\LoggerFileService;
use Model\User;
use Service\Auth\AuthSessionService;
use Model\Product;
use Service\OrderService;
use Model\Logger;
use Controller\ProductController;
use Service\ReviewService;


$rootPath = str_replace('public', '', __DIR__);
Autoload::autoload($rootPath);

$container = new Container();


$container->set(UserController::class , function (Container $container) {
    $authService = $container->get(\Service\Auth\AuthServiceInterface::class);
    $userModel = new User();
    return new UserController($userModel,$authService);
});
$container->set(CatalogController::class , function (Container $container){
    $productModel = new Product();
    $authService = $container->get(\Service\Auth\AuthServiceInterface::class);
    return new CatalogController($productModel,$authService);
});
$container->set(OrderController::class , function (Container $container){
    $order = new Order();
    $orderService = new OrderService();
    $authService = $container->get(\Service\Auth\AuthServiceInterface::class);
    $productModel = new Product();
    $orderProductModel = new OrderProduct();
    return new OrderController($orderService, $authService, $productModel, $order, $orderProductModel);
});
$container->set(CartController::class , function (Container $container){
    $cartService = new CartService();
    $authService = $container->get(\Service\Auth\AuthServiceInterface::class);
    $userProductModel = new UserProduct();
    return new CartController($cartService, $authService, $userProductModel);
});
$container->set(UserProductController::class , function (Container $container){
    $cartService = new CartService();
    $authService = $container->get(\Service\Auth\AuthServiceInterface::class);
    return new UserProductController($cartService, $authService);
});

$container->set(ProductController::class, function (Container $container) {
    $productModel = new Product();
    $authService = $container->get(\Service\Auth\AuthServiceInterface::class);
    $reviewService = new ReviewService($productModel,$authService );
    return new ProductController($reviewService);
});

$logger = new Logger();

$container->set(\Service\Logger\LoggerServiceInterface::class, function () use ($logger) {
    return new LoggerFileService();
});

$container->set(\Service\Auth\AuthServiceInterface::class, function () {
    return new AuthSessionService();
});

$loggerService = $container->get(\Service\Logger\LoggerServiceInterface::class);

$app = new App($loggerService, $container);

$app->addRoute('/registration', 'GET', UserController::class, 'getRegistrationForm');
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
$app->addRoute('/product/{id}', 'GET', ProductController::class, 'getProductPage');
$app->addRoute('/product/{id}', 'POST', ProductController::class, 'handleReviewForm');

$app->run();


