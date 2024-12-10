<?php
class UserRegistration {
    private $pdo;
    private $errors = [];

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function validateRegistrationForm(array $data) {
        if (isset($data['name'])) {
            $name = trim($data['name']);
            if (empty($name)) {
                $this->errors['name'] = "Имя обязательно";
            } elseif (strlen($name) < 3) {
                $this->errors['name'] = "В имени должно быть не менее 3 символов";
            }
        }

        if (isset($data['email'])) {
            $email = trim($data['email']);
            if (empty($email)) {
                $this->errors['email'] = "Требуется адрес электронной почты";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->errors['email'] = "Неверный формат электронной почты";
            }
        }

        if (isset($data['psw'])) {
            $password = $data['psw'];
            if (empty($password)) {
                $this->errors['psw'] = "Требуется пароль";
            } elseif (strlen($password) < 6) {
                $this->errors['psw'] = "Пароль должен содержать не менее 6 символов";
            }
        }

        if (isset($data['psw-repeat'])) {
            $passwordRepeat = $data['psw-repeat'];
            if (empty($passwordRepeat)) {
                $this->errors['psw-repeat'] = "Повторите пароль";
            } elseif ($data['psw'] !== $passwordRepeat) {
                $this->errors['psw-repeat'] = "Пароли не совпадают";
            }
        }

        return $this->errors;
    }

    public function registerUser(array $data) {
        if (empty($this->errors)) {
            $name = trim($data['name']);
            $email = trim($data['email']);
            $password = $data['psw'];
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
            $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");

            $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);

            return true;
        }

        return false;
    }

    public function getErrors(): array {
        return $this->errors;
    }
}



$userRegistration = new UserRegistration($this->pdo);

$errors = $userRegistration->validateRegistrationForm($_POST);

if ($userRegistration->registerUser($_POST)) {
    header('Location: /login');
    echo "Вы успешно зарегистрировались";
} else {
    $errors = $userRegistration->getErrors();
    require_once './get_registration.php';
}