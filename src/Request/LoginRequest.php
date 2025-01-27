<?php

namespace Request;

class LoginRequest extends Request
{

    public function getEmail(): string{
        return $this->data['email'];
    }
    public function getPassword(): string{
        return $this->data['password'];
    }

    public function validate(): array
    {
        $errors = [];

        if (isset($this->data['email'])) {
            $email = ($this->data['email']);
            if (empty($email)) {
                $errors['email'] = 'Требуется адрес электронной почты';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Неверный адрес электронной почты';
            }
        }

        if (isset($this->data['psw'])) {
            $password = ($this->data['psw']);
            if (empty($password)) {
                $errors['psw'] = 'Требуется пароль';
            } elseif (strlen($password) < 6) {
                $errors['psw'] = 'Пароль должен содержать не менее 6 символов';
            }
        }

        return $errors;
    }
}