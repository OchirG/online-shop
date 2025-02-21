<?php

namespace Service\Auth;

interface AuthServiceInterface
{
    public function check();

    public function getCurrentUser();

    public function login(string $email, string $password);

    public function sessionStart();

}