<?php
namespace Model;
use PDO;
class UserProduct extends Model
{
    private int $id;
    private int $userId;
    private int $productId;
    private int $amount;

    // Метод для вставки или обновления записи о продукте для пользователя
    public static function getAddProduct($userId, $productId, $amount): bool
    {
        $stmt = self::getPdo()->prepare("
            INSERT INTO user_products (user_id, product_id, amount)
            VALUES (:user_id, :product_id, :amount)
            ON CONFLICT (user_id, product_id) 
            DO UPDATE SET amount = user_products.amount + excluded.amount;
        ");
        return $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    }

    // метод для получения всех продуктов для конкретного пользователя, с сортировкой по идентификатору продукта.
    public static function getAllByUserId(int $userId): ?array
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM user_products WHERE user_id = :user_id ORDER BY product_id");
        $stmt->execute(['user_id' => $userId]);
        $productsData = $stmt->fetchAll();


        if (empty($productsData)) {
            return null;
        }

        $products = [];
        foreach ($productsData as $data) {

            $product = new self();

            $product->id = $data['id'];
            $product->userId = $data['user_id'];
            $product->productId = $data['product_id'];
            $product->amount = $data['amount'];

            $products[] = $product;
        }

        return $products;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }


    public function getAmount(): int
    {
        return $this->amount;
    }

    public function removeProductFromCart(int $userId, int $productId): bool
    {
        $stmt = self::getPdo()->prepare("DELETE FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);

        return $stmt->execute();
    }
}



