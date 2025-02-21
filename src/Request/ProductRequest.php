<?php

namespace Request;

class ProductRequest extends Request
{
    public function getUserId(): int
    {
        return $this->data['user_id'];
    }
    public function getProductId(): int
    {
        return $this->data['product_id'];
    }

    public function getComment(): string
    {
        return $this->data['comment'];
    }

    public function getRating(): int
    {
        return (int)$this->data['rating'];
    }

    public function validate(): array
    {
        $errors = [];

        if (!isset($this->data['comment']) || empty(trim($this->data['comment']))) {
            $errors[] = 'Комментарий не может быть пустым.';
        }

        if (!isset($this->data['rating']) || !in_array($this->data['rating'], [1, 2, 3, 4, 5])) {
            $errors[] = 'Рейтинг должен быть от 1 до 5.';
        }

        return $errors;
    }

}

