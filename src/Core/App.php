<?php
namespace Core;

class App {

    private array $routes = [];

    public function run(): void {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        if (array_key_exists($uri, $this->routes) && array_key_exists($method, $this->routes[$uri])) {
            $route = $this->routes[$uri][$method];
            $controllerClass = $route['class'];
            $controllerMethod = $route['method'];

            $controller = new $controllerClass();
            $controller->$controllerMethod();
        } else {
            require_once './../view/404.php';
        }
    }

    public function addRoute(string $uriName, string $uriMethod, string $className, string $method): void {
        if(!isset($this->routes[$uriName][$uriMethod])) {
            $this->routes[$uriName][$uriMethod]['class'] = $className;
            $this->routes[$uriName][$uriMethod]['method'] = $method;
        }else{
            echo "$uriMethod зарегистрирован для $uriName";
        }


    }
}
//    private array $routes = [
//        '/registration' => [
//            'GET' => ['class' => 'Controller\UserController', 'method' => 'getRegistrationForm'],
//            'POST' => ['class' => 'Controller\UserController', 'method' => 'handleRegistrationForm']
//        ],
//        '/login' => [
//            'GET' => ['class' => 'Controller\UserController', 'method' => 'getLoginForm'],
//            'POST' => ['class' => 'Controller\UserController', 'method' => 'handleLoginForm']
//        ],
//        '/catalog' => [
//            'GET' => ['class' => 'Controller\CatalogController', 'method' => 'getCatalogPage']
//        ],
//        '/add-product' => [
//            'GET' => ['class' => 'Controller\UserProductController', 'method' => 'getAddProductForm'],
//            'POST' => ['class' => 'Controller\UserProductController', 'method' => 'handleAddUserProductForm']
//        ],
//        '/cart' => [
//            'GET' => ['class' => 'Controller\CartController', 'method' => 'getCartPage']
//        ],
//        '/logout' => [
//            'GET' => ['class' => 'Controller\UserController', 'method' => 'logout']
//        ],
//        '/remove-product'=> [
//            'GET' => ['class' => 'Controller\CartController', 'method' => 'removeProductFromCart']
//        ],
//        '/order' => [
//            'GET' => ['class' => 'Controller\OrderController', 'method' => 'getOrderForm'],
//            'POST' => ['class' => 'Controller\OrderController', 'method' => 'handleOrder']
//        ],
//        '/order/confirm' => [
//            'GET' => ['class' => 'Controller\OrderController', 'method' => 'getOrderConfirmForm']
//        ],
//        '/orders'=>[
//            'GET' => ['class' => 'Controller\OrderController', 'method' => 'getOrders'],
//        ]
//
//    ];