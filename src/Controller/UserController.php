<?php
namespace Controller;
use Model\User;
use Request\LoginRequest;
use Request\RegistrateRequest;
use Service\AuthService;

class UserController
{
    private User $userModel;
    private AuthService $authService;

    public function __construct() {
        $this->userModel = new User();
        $this->authService = new AuthService();
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
                        $errors['errors'] = "Ошибка при создании пользователя";
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
        $this->checkSession();

        $errors = $request->validate();

        if (empty($errors)) {
            $email = $request->getEmail();
            $password = $request->getPassword();
            $loginResult = $this->authService->login($email, $password);

            if ($loginResult['success']) {
                header("Location: /catalog");
                exit();
            } else {
                $errors['login'] = $loginResult['error'];
            }
        }

        require_once './../view/login.php';
    }

    private function checkSession(): void {

        if (!$this->authService->check()) {
            header('Location: /login');
            exit;
        }
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

