<?php
namespace Core;

use Request\AddProductRequest;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\ProductRequest;
use Request\RegistrateRequest;
use Request\Request;
use Service\Logger\LoggerServiceInterface;


class App
{
    private array $routes = [];
    private LoggerServiceInterface $logger;
    private Container $container;

    public function __construct(LoggerServiceInterface $logger, Container $container)
    {
        $this->logger = $logger;
        $this->container = $container;
    }

    public function run(): void
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $routeUri => $methods) {
            $pattern = preg_replace('/\{[^\/]+\}/', '([^\/]+)', $routeUri);

            if (preg_match('@^' . $pattern . '$@', $uri, $matches) && isset($methods[$method])) {
                $route = $methods[$method];
                $controllerClass = $route['class'];
                $controllerMethod = $route['method'];
                $controller = $this->container->get($controllerClass);

                array_shift($matches);
                $request = $this->createRequestObject($uri, $method, $matches);

                try {
                    $controller->$controllerMethod($request);
                } catch (\Throwable $exception) {
                    $this->handleException($exception);
                }
                return;
            }
        }

        // Если маршрут не найден
        http_response_code(404);
        echo "404 Not Found";
    }

    private function handleException(\Throwable $exception): void
    {
        if ($exception instanceof \RuntimeException || $exception instanceof \InvalidArgumentException) {
            $this->logger->warning($exception);
        } else {
            $this->logger->error($exception);
        }
        $traceMessage = $exception->getTraceAsString();
        $traceException = new \Exception($traceMessage);
        $this->logger->info($traceException);

        http_response_code(500);
        $errorPagePath = './../view/500.php';
        if (file_exists($errorPagePath)) {
            require $errorPagePath;
        } else {
            echo "Внутренняя ошибка сервера. Страница ошибки не найдена.";
        }
    }

    private function createRequestObject(string $uri, string $method, array $params = []): Request
    {
        switch ($uri) {
            case '/registration':
                return new RegistrateRequest($uri, $method, $_POST);
            case '/login':
                return new LoginRequest($uri, $method, $_POST);
            case '/order':
                return new OrderRequest($uri, $method, $_POST);
            case '/add-product':
                return new AddProductRequest($uri, $method, $_POST);
            case preg_match('/^\/product\/(\d+)$/', $uri) ? $uri : '':
                if ($method === 'GET') {
                    return new ProductRequest($uri, $method, ['product_id' => explode('/', $uri)[2]]);
                } elseif ($method === 'POST') {
                    return new ProductRequest($uri, $method, $_POST);
                }
                break;
        }
        return new Request($uri, $method, $params);
    }
    public function addRoute(string $uriName, string $uriMethod, string $className, string $method): void
    {
        if (!isset($this->routes[$uriName][$uriMethod])) {
            $this->routes[$uriName][$uriMethod]['class'] = $className;
            $this->routes[$uriName][$uriMethod]['method'] = $method;
        } else {
            echo "$uriMethod зарегистрирован для $uriName";
        }
    }
}