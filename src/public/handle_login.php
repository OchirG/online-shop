<?php

function validateLogin(array $methodPost)
{
    $errors = [];


    if(isset($methodPost['email'])){
        $email = trim($methodPost['email']);
        if(empty($email)){
            $errors['email'] = 'Требуется адрес электронной почты';
        } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'Неверный адрес электронной почты';
        }
    }


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


$errors = validateLogin($_POST);

if (empty($errors)) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");

    $stmt->execute(['email' => $email]);
    $data = $stmt->fetch();


    if ($data === false) {
        $errors['email'] = 'логин или пароль указаны неверно';
        require_once './get_login.php';
    } else {

        if (password_verify($password, $data['password'])) {
            //setcookie('user_id', $data['id']);
            session_start();
            $_SESSION['user_id'] = $data['id'];
            header('Location: /catalog');

        } else {
            $errors['email'] = 'логин или пароль указаны неверно';
            require_once './get_login.php';
        }
    }
} else {

    require_once './get_login.php';
}