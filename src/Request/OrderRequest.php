<?php

namespace Request;


class OrderRequest extends Request
{

    public function getName(): string
    {
        return $this->data['name'];
    }

    public function getEmail(): string
    {
        return $this->data['email'];
    }

    public function getAddress(): string
    {
        return $this->data['address'];
    }

    public function getNumber(): string
    {
        return $this->data['number'];
    }

    public function validate(){
        $errors = [];

        if (empty($this->data['name'])) {
            $errors[] = "Имя не может быть пустым.";
        } elseif (strlen($this->data['name']) > 100) {
            $errors[] = "Имя не должно превышать 100 символов.";
        }

        if (empty($this->data['email'])) {
            $errors[] = "Email не может быть пустым.";
        } elseif (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Неверный формат email.";
        }
        if (empty($this->data['address'])) {
            $errors[] = "Адрес не может быть пустым.";
        } elseif (strlen($this->data['address']) > 255) {
            $errors[] = "Адрес не должен превышать 255 символов.";
        }

//        if (empty($this->data['number'])) {
//            $errors[] = "Номер телефона не может быть пустым.";
//        } elseif (!preg_match('/^\+?[0-9]{10,15}$/', $this->data['number'])) {
//            $errors[] = "Неверный формат номера телефона. Должен составлять от 10 до 15 цифр.";
//        }
//
//        if (!empty($errors)) {
//
//            foreach ($errors as $error) {
//                echo $error;
//            }
//            return;
//        }
    }

}