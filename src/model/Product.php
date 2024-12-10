<?php

class Product extends GetConnection
{

    // Метод для получения всех продуктов из базы данных
    public function getAllProducts(): array // CATALOG.PHP
    {
        $stmt = $this->pdo->query("SELECT * FROM products ORDER BY id");
        return $stmt->fetchAll();
    }

    // Метод для получения одного продукта по его идентификатору
    public function getOneById(int $productId): array|false   //handle_add_product
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $productId]);
        return $stmt->fetch();
    }

    // Метод для получения нескольких продуктов по их идентификаторам
    public function getAllById(array $productIds): array|false
    {
        $placeHolders = implode(',', array_fill(0, count($productIds), '?'));
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id IN ($placeHolders)");
        $stmt->execute($productIds);
        return $stmt->fetchAll();
    }

    public function getProductPriceById($productId): ?float {
        $stmt = $this->pdo->prepare("SELECT price FROM products WHERE id = :productId");
        $stmt->execute(['productId' => $productId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? (float)$result['price'] : null;
    }
}
