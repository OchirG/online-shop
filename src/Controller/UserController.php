<?php
namespace Controller;
use Model\User;
use Request\LoginRequest;
use Request\RegistrateRequest;

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

            // Валидация email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Некорректный адрес электронной почты";
            } else {
                $user = $this->userModel->getOneByEmail($email);

                if ($user) {
                    $errors['email'] = "Пользователь с таким адресом электронной почты уже существует";
                } else {
                    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
                    if ($this->userModel->create($name, $email, $hashPassword)) {
                        header("Location: /login");
                        exit;
                    } else {
                        $errors['general'] = "Ошибка при создании пользователя";
                    }
                }
            }
        }

        require_once './../view/registration.php';
    }

    public function getLoginForm(): void
    {
        require_once './../view/login.php';
    }

    public function handleLoginForm(LoginRequest $request): void
    {
        session_start();
        $errors = $request->validate();

        if (empty($errors)) {
            $email = $request->getEmail();
            $password = $request->getPassword();

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
    public function logout(): void
    {
        session_start();
        $_SESSION = [];
        session_destroy();
        header('Location: /login');
        exit;
    }
}

