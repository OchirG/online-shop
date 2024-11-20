<?php

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri === '/login') {
    if ($requestMethod === 'GET') {
        require_once './get_login.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handle_login.php';
    } else {
        http_response_code(405); // Метод не разрешен
        require_once './404.php';
    }

// Маршрутизация для страницы регистрации
} elseif ($requestUri === '/registration') {
    if ($requestMethod === 'GET') {
        require_once './get_registration.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handle_registration.php';
    } else {
        http_response_code(405); // Метод не разрешен
        require_once './404.php';
    }

// Маршрутизация для каталога
} elseif ($requestUri === '/catalog') {
    // Обработка как GET и POST запрос
    require_once './catalog.php';
}
