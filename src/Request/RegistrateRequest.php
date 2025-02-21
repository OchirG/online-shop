<?php

namespace Request;

class RegistrateRequest extends Request
{
    public function getName(){
       return $this->data['name'];
    }
    public function getEmail(){
        return $this->data['email'];
    }

    public function getPassword(){
        return $this->data['psw'];
    }

    public function validate(): array
    {
        $errors = [];

        if (isset($this->data['name'])) {
            $name = $this->data['name'];
            if (empty($name)) {
                $errors['name'] = "Имя обязательно";
            } elseif (strlen($name) < 3) {
                $errors['name'] = "В имени должно быть не менее 3 символов";
            }
        }

        if (isset($this->data['email'])) {
            $email = $this->data['email'];
            if (empty($email)) {
                $errors['email'] = "Требуется адрес электронной почты";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Неверный формат электронной почты";
            }
        }

        if (isset($this->data['psw'])) {
            $password = $this->data['psw'];
            if (empty($password)) {
                $errors['psw'] = "Требуется пароль";
            } elseif (strlen($password) < 6) {
                $errors['psw'] = "Пароль должен содержать не менее 6 символов";
            }
        }

        if (isset($this->data['psw-repeat'])) {
            $passwordRepeat = $this->data['psw-repeat'];
            if (empty($passwordRepeat)) {
                $errors['psw-repeat'] = "Повторите пароль";
            } elseif ($this->data['psw'] !== $passwordRepeat) {
                $errors['psw-repeat'] = "Пароли не совпадают";
            }
        }
        return $errors;
    }

}


