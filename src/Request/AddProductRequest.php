<?php

namespace Request;


class AddProductRequest extends Request
{
    public function getProductId(): int
    {
        return $this->data['product_id'];
    }

    public function getAmount(): int
    {
        return $this->data['amount'];
    }

    public function validate(): array
    {
        $errors = [];

        if (isset($this->data['product_id'])) {
            $productId = $this->data['product_id'];
            if (empty($productId)) {
                $errors['product_id'] = 'Идентификатор продукта не может быть пустым';
            } elseif ($productId < 1) {
                $errors['product_id'] = 'Идентификатор продукта должен быть положительным';
            } elseif (!is_numeric($productId)) {
                $errors['product_id'] = 'Идентификатор продукта должен быть числом';
            }

        }

        if (isset($this->data['amount'])) {
            $amount = $this->data['amount'];
            if (empty($amount)) {
                $errors['amount'] = "Количество продуктов не должно быть пустым";
            } elseif ($amount < 1) {
                $errors['amount'] = "Количество продуктов должно быть положительным";
            } elseif (!is_numeric($amount)) {
                $errors['amount'] = "Количество продуктов должно быть числом";
            } elseif (floor($amount) != $amount) {
                $errors['amount'] = "Количество должно быть натуральным числом";
            }
        } else {
            $errors['amount'] = "Количество продуктов не передано";
        }

        return $errors;
    }
}