<?php

class UserProduct extends GetConnection
{

    // Метод для вставки или обновления записи о продукте для пользователя
    public function getAddProduct($userId, $productId, $amount): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO user_products (user_id, product_id, amount)
            VALUES (:user_id, :product_id, :amount)
            ON CONFLICT (user_id, product_id) 
            DO UPDATE SET amount = user_products.amount + excluded.amount;
        ");
        return $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    }

    // метод для получения всех продуктов для конкретного пользователя, с сортировкой по идентификатору продукта.
    public function getAllByUserId(int $userId): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id ORDER BY product_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function clearCartByUserId(int $userId): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM user_products WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        return $stmt->execute();
    }
}



