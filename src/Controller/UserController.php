<?php
namespace Controller;
use Model\User;
use Request\RegistrateRequest;
use Request\Request;

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

    public function handleRegistrationForm(RegistrateRequest $request): void
    {
        $errors = $request->validate();

        if (empty($errors)) {
            $name = $request->getName();
            $email = $request->getEmail();
            $password = $request->getPassword();

            $user = $this->userModel->getOneByEmail($email);

            if ($user) {
                $errors['email'] = "Пользователь с таким адресом электронной почты уже существует";
            } else {
                $hashPassword = password_hash($password, PASSWORD_DEFAULT);
                if ($this->userModel->create($name, $email, $hashPassword)) {
                    header("Location: /login");
                    exit;
                } else {
                    $errors['name'] = "Ошибка при создании пользователя";
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
            if ($user === null || !password_verify($password, $user->getPassword())) {
                $errors['email'] = 'Логин или пароль указаны неверно';
            } else {
                $_SESSION['user_id'] = $user->getId();
                header("Location: /catalog");
                exit;
            }
        }

        require_once './../view/login.php';
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

