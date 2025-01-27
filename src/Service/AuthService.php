<?php

namespace Service;

use Model\User;

class AuthService
{
    public function check(): bool
    {
        $this->sessionStart();
        return isset($_SESSION['user_id']);
    }

    public function getCurrentUser(): ?User
    {
        if (!$this->check()) {
            return null;
        }
        $this->sessionStart();
        $userId = $_SESSION['user_id'];

        return User::getOneById($userId);
    }

    public function login(string $email, string $password): array
    {
        $user = User::getOneByEmail($email);
        if ($user === null || !password_verify($password, $user->getPassword())) {
            return ['success' => false, 'error' => 'Логин или пароль указаны неверно.'];
        }
        $_SESSION['user_id'] = $user->getId();
        return ['success' => true];
    }

    private function sessionStart(): void{
        if(session_status() !== PHP_SESSION_ACTIVE){
            session_start();
        }
    }



}