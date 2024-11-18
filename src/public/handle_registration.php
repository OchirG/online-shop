<?php

function validateRegistrationForm(array $methodPost)
{
    $errors = [];

    // Валидация имени
    if (isset($methodPost['name'])) {
        $name = trim($methodPost['name']);
        if (empty($name)) {
            $errors['name'] = "Имя обязательно";
        } elseif (strlen($name) < 3) {
            $errors['name'] = "В имени должно быть не менее 3 символов";
        }
    }

    // Валидация email
    if (isset($methodPost['email'])) {
        $email = trim($methodPost['email']);
        if (empty($email)) {
            $errors['email'] = "Требуется адрес электронной почты";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Неверный формат электронной почты";
        }
    }

    // Валидация пароля
    if (isset($methodPost['psw'])) {
        $password = $methodPost['psw'];
        if (empty($password)) {
            $errors['psw'] = "Требуется пароль";
        } elseif (strlen($password) < 6) {
            $errors['psw'] = "Пароль должен содержать не менее 6 символов";
        }
    }

    // Валидация повторного пароля
    if (isset($methodPost['psw-repeat'])) {
        $passwordRepeat = $methodPost['psw-repeat'];
        if (empty($passwordRepeat)) {
            $errors['psw-repeat'] = "Повторите пароль";
        } elseif ($password !== $passwordRepeat) {
            $errors['psw-repeat'] = "Пароли не совпадают";
        }
    }

    return $errors;
}

// Получаем ошибки валидации
$errors = validateRegistrationForm($_POST);

// Если ошибок нет, продолжаем регистрацию
if (empty($errors)) {
    // Получаем значения из формы
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['psw'];
    $passwordRepeat = $_POST['psw-repeat'];

    // Соединение с базой данных
    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");

    // Хешируем пароль
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);

    // Получаем информацию о зарегистрированном пользователе
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    ($stmt->fetch());

    echo "Вы успешно зарегистрировались";
} else {
    require_once './get_registration.php';
}



