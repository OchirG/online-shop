<?php
namespace Core;

use Request\AddProductRequest;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\RegistrateRequest;
use Request\Request;
use Service\Auth\AuthSessionService;
use Service\CartService;
use Service\Logger\LoggerFileService;
use Service\Logger\LoggerServiceInterface;
use Service\OrderService;
use Controller\UserController;
use Model\User;

class App {
    private array $routes = [];
    private LoggerServiceInterface $logger;

    public function __construct(LoggerServiceInterface $logger) {
        $this->logger = $logger;
    }

    public function run(): void {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        if (array_key_exists($uri, $this->routes) && array_key_exists($method, $this->routes[$uri])) {
            $route = $this->routes[$uri][$method];
            $controllerClass = $route['class'];
            $controllerMethod = $route['method'];

            $orderService = new OrderService();
            $cartService = new CartService();
            $authService = new AuthSessionService();
            $userModel = new User();

            if ($controllerClass === UserController::class) {
                $controller = new UserController($userModel, $authService);
            } else {
                $controller = new $controllerClass($orderService, $cartService, $authService);
            }
            $request = $this->createRequestObject($uri, $method);

            try {
                $controller->$controllerMethod($request);

            } catch (\Throwable $exception) {
                $this->logger->error($exception);

                http_response_code(500);
                require_once './../view/500.php';
            }
        }
    }

    private function createRequestObject(string $uri, string $method): ?Request {
        if ($uri === '/registration' && $method === 'POST') {
            return new RegistrateRequest($uri, $method, $_POST);
        } elseif ($uri === '/login' && $method === 'POST') {
            return new LoginRequest($uri, $method, $_POST);
        } elseif ($uri === '/order' && $method === 'POST') {
            return new OrderRequest($uri, $method, $_POST);
        } elseif ($uri === '/add-product' && $method === 'POST') {
            return new AddProductRequest($uri, $method, $_POST);
        }

        return new Request($uri, $method, $_POST);
    }

    public function addRoute(string $uriName, string $uriMethod, string $className, string $method): void {
        if (!isset($this->routes[$uriName][$uriMethod])) {
            $this->routes[$uriName][$uriMethod]['class'] = $className;
            $this->routes[$uriName][$uriMethod]['method'] = $method;
        } else {
            echo "$uriMethod зарегистрирован для $uriName";
        }
    }
}
