<?php

function validateLogin(array $methodPost)
{
    $errors = [];

    // Проверка email
    if(isset($methodPost['email'])){
        $email = trim($methodPost['email']);
        if(empty($email)){
            $errors['email'] = 'Требуется адрес электронной почты';
        } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'Неверный адрес электронной почты';
        }
    }

    // Проверка пароля
    if(isset($methodPost['password'])){
        $password = trim($methodPost['password']);
        if(empty($password)){
            $errors['password'] = 'Требуется пароль';
        } elseif(strlen($password) < 6){
            $errors['password'] = 'Пароль должен содержать не менее 6 символов';
        }
    }

    return $errors;
}

// Получаем ошибки валидации
$errors = validateLogin($_POST);

if (empty($errors)) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");

    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    // Проверяем, существует ли пользователь
    if ($user === false) {
        $errors['email'] = 'Неправильный адрес электронной почты';
        require_once './get_login.php';
    } else {
        // Проверяем пароль
        if (password_verify($password, $user['password'])) {
            echo "Успешный вход";
            // Здесь можно добавить редирект или другую логику после успешного входа
        } else {
            $errors['password'] = 'Неверный пароль';
            require_once './get_login.php';
        }
    }
} else {
    // Если есть ошибки, отображаем страницу входа
    require_once './get_login.php';
}