<?php

namespace Service\Auth;

use Model\User;

class AuthSessionService implements AuthServiceInterface
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
    public function login(string $email, string $password): bool
    {
        $user = User::getOneByEmail($email);

        if ($user !== null && password_verify($password, $user->getPassword())) {
            $this->sessionStart();
            $_SESSION['user_id'] = $user->getId();
            return true;
        }
        return false;
    }
    public function sessionStart(): void{
        if(session_status() !== PHP_SESSION_ACTIVE){
            session_start();
        }
    }
}
