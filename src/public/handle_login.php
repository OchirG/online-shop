<?php
class UserLogin {
    private $pdo;
    private $errors = [];

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function validateLogin(array $data) {
        if (isset($data['email'])) {
            $email = trim($data['email']);
            if (empty($email)) {
                $this->errors['email'] = 'Требуется адрес электронной почты';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->errors['email'] = 'Неверный адрес электронной почты';
            }
        }

        if (isset($data['password'])) {
            $password = trim($data['password']);
            if (empty($password)) {
                $this->errors['password'] = 'Требуется пароль';
            } elseif (strlen($password) < 6) {
                $this->errors['password'] = 'Пароль должен содержать не менее 6 символов';
            }
        }

        return $this->errors;
    }

    public function loginUser(array $data) {
        $email = trim($data['email']);
        $password = trim($data['password']);

        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user === false) {
            $this->errors['email'] = 'Логин или пароль указаны неверно';
            return false;
        }

        if (password_verify($password, $user['password'])) {
            // Установка сессии
            session_start();
            $_SESSION['user_id'] = $user['id'];
            return true;
        } else {
            $this->errors['email'] = 'Логин или пароль указаны неверно';
            return false;
        }
    }

    public function getErrors(): array {
        return $this->errors;
    }
}

$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');

$userLogin = new UserLogin($pdo);

$errors = $userLogin->validateLogin($_POST);

if (empty($errors)) {
    if ($userLogin->loginUser($_POST)) {
        header('Location: /catalog');
        exit;
    } else {
        $errors = $userLogin->getErrors();
        require_once './get_login.php';
    }
} else {
    require_once './get_login.php';
}