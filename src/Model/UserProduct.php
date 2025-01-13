<?php
namespace Model;
use PDO;
class UserProduct extends Model
{
    private int $id;
    private int $user_id;
    private int $product_id;
    private int $amount;

    public function __construct(int $id, int $userId, int $productId, int $amount){
        parent::__construct();

        $this->id = $id;
        $this->user_id = $userId;
        $this->product_id = $productId;
        $this->amount = $amount;
    }



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
    public function getAllByUserId(int $userId): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id ORDER BY product_id");
        $stmt->execute(['user_id' => $userId]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($data)) {
            return null;
        }
        $products = [];
        foreach ($data as $item) {
            $product = new UserProduct(
                $item['id'],
                $item['product_id'],
                $item['amount'],
                $item['user_id']
            );

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
        return $this->user_id;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function clearCartByUserId(int $userId): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM user_products WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        return $stmt->execute();
    }
}



