<?php
class UserController
{
    private User $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function getRegistrationForm(): void
    {
        require_once './../view/registration.php';
    }

    public function handleRegistrationForm(): void
    {
        $errors = $this->validateRegistrationForm($_POST);

        if (empty($errors)) {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = trim($_POST['psw']);

            if ($this->userModel->getOneByEmail($email) !== false) {
                $errors['email'] = "Пользователь с таким адресом электронной почты уже существует";
            } else {
                $hashPassword = password_hash($password, PASSWORD_DEFAULT);
                $newUser = $this->userModel->create($name, $email, $hashPassword);
                if ($newUser === false) {
                    $errors['name'] = "Ошибка при передаче данных";
                } else {
                    header("Location: /login");
                    exit;
                }
            }
        }

        require_once './../view/registration.php';
    }

    public function getLoginForm(): void
    {
        require_once './../view/login.php';
    }

    public function handleLoginForm(): void
    {
        session_start();

        $errors = $this->validateLoginForm($_POST);
        if (empty($errors)) {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            $user = $this->userModel->getOneByEmail($email);
            if ($user === false || !password_verify($password, $user['password'])) {
                $errors['email'] = 'Логин или пароль указаны неверно';
            } else {
                $_SESSION['user_id'] = $user['id'];
                header("Location: /catalog");
                exit;
            }
        }

        require_once './../view/login.php';
    }

    private function validateRegistrationForm(array $data): array
    {
        $errors = [];

        if (isset($data['name'])) {
            $name = trim($data['name']);
            if (empty($name)) {
                $errors['name'] = "Имя обязательно";
            } elseif (strlen($name) < 3) {
                $errors['name'] = "В имени должно быть не менее 3 символов";
            }
        }

        if (isset($data['email'])) {
            $email = trim($data['email']);
            if (empty($email)) {
                $errors['email'] = "Требуется адрес электронной почты";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Неверный формат электронной почты";
            }
        }

        if (isset($data['psw'])) {
            $password = $data['psw'];
            if (empty($password)) {
                $errors['psw'] = "Требуется пароль";
            } elseif (strlen($password) < 6) {
                $errors['psw'] = "Пароль должен содержать не менее 6 символов";
            }
        }

        if (isset($data['psw-repeat'])) {
            $passwordRepeat = $data['psw-repeat'];
            if (empty($passwordRepeat)) {
                $errors['psw-repeat'] = "Повторите пароль";
            } elseif ($data['psw'] !== $passwordRepeat) {
                $errors['psw-repeat'] = "Пароли не совпадают";
            }
        }
        return $errors;
    }

    private function validateLoginForm(array $data): array
    {
        $errors = [];

        if (isset($data['email'])) {
            $email = ($data['email']);
            if (empty($email)) {
                $errors['email'] = 'Требуется адрес электронной почты';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Неверный адрес электронной почты';
            }
        }

        if (isset($data['psw'])) {
            $password = ($data['psw']);
            if (empty($password)) {
                $errors['psw'] = 'Требуется пароль';
            } elseif (strlen($password) < 6) {
                $errors['psw'] = 'Пароль должен содержать не менее 6 символов';
            }
        }

        return $errors;
    }

    public function logout(): void
    {
        session_start();
        $_SESSION = [];
        session_destroy();
        header('Location: /login');
        exit;
    }
}

