<?php
class App {

    private array $routes = [
        '/registration' => [
            'GET' => ['class' => 'UserController', 'method' => 'getRegistrationForm'],
            'POST' => ['class' => 'UserController', 'method' => 'handleRegistrationForm']
        ],
        '/login' => [
            'GET' => ['class' => 'UserController', 'method' => 'getLoginForm'],
            'POST' => ['class' => 'UserController', 'method' => 'handleLoginForm']
        ],
        '/catalog' => [
            'GET' => ['class' => 'CatalogController', 'method' => 'getCatalogPage']
        ],
        '/add-product' => [
            'GET' => ['class' => 'UserProductController', 'method' => 'getAddProductForm'],
            'POST' => ['class' => 'UserProductController', 'method' => 'handleAddUserProductForm']
        ],
        '/cart' => [
            'GET' => ['class' => 'CartController', 'method' => 'getCartPage']
        ],
        '/logout' => [
            'GET' => ['class' => 'UserController', 'method' => 'logout']
        ],
        '/order' => [
            'GET' => ['class' => 'OrderController', 'method' => 'getOrderForm'],
            'POST' => ['class' => 'OrderController', 'method' => 'handleOrder']
        ],
        '/order/confirm' => [
            'GET' => ['class' => 'OrderController', 'method' => 'getOrderConfirmForm']
        ]
    ];

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
            require_once './../view/404.php'; // Отображение страницы 404
        }
    }
}


//class App {
//    public function run(): void
//    {
//        $uri = $_SERVER['REQUEST_URI'];
//        $method = $_SERVER['REQUEST_METHOD'];
//
//        switch ($uri) {
//            case '/registration':
//                $registration = new UserController();
//                if ($method === 'GET') {
//                    $registration->getRegistrationForm();
//                } elseif ($method === 'POST') {
//                    $registration->handleRegistrationForm();
//                } else {
//                    echo "$method не поддерживается адресом $uri";
//                }
//                break;
//            case '/login':
//                $login = new UserController();
//                if ($method === 'GET') {
//                    $login->getLoginForm();
//                } elseif ($method === 'POST') {
//                    $login->handleLoginForm();
//                } else {
//                    echo "$method не поддерживается адресом $uri";
//                }
//                break;
//            case '/catalog':
//                $catalog = new CatalogController();
//                if ($method === 'GET') {
//                    $catalog->getCatalogPage();
//                } else {
//                    echo "$method не поддерживается адресом $uri";
//                }
//                break;
//            case '/add-product':
//                $userProduct = new UserProductController();
//                if ($method === 'GET') {
//                    $userProduct->getAddProductForm();
//                } elseif ($method === 'POST') {
//                    $userProduct->handleAddUserProductForm();
//                } else {
//                    echo "$method не поддерживается адресом $uri";
//                }
//                break;
//            case '/cart':
//                $cart = new CartController();
//                if ($method === 'GET') {
//                    $cart->getCartPage();
//                } else {
//                    echo "$method не поддерживается адресом $uri";
//                }
//                break;
//            case '/logout':
//                $logout = new UserController();
//                if ($method === 'GET') {
//                    $logout->logout();
//                } else {
//                    echo "$method не поддерживается адресом $uri";
//                }
//                break;
//            case '/order':
//                $order = new OrderController();
//                if ($method === 'GET') {
//                    $order->getOrderForm();
//                }elseif ($method === 'POST') {
//                    $order->processOrder();
//                }else{
//                    echo "$method не поддерживается адресом $uri";
//                }
//                break;
//            default:
//                require_once './../view/404.php';
//                break;
//        }
//    }
//}