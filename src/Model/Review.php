<?php

namespace Model;

class Review extends Model
{
    private int $userId ;
    private int $productId ;
    private string $comment ;
    private float $rating;

    public static function create(int $userId, int $productId, float $rating, string $comment): bool
    {
        $stmt = self::getPdo()->prepare("INSERT INTO reviews (user_id, product_id,  rating, comment) VALUES (:user_id, :product_id,  :rating, :comment)");
        return $stmt->execute([
            'user_id' => $userId,
            'product_id' => $productId,
            'rating' => $rating,
            'comment' => $comment
        ]);
    }

    public static function getAllByProductId(int $productId): array
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM reviews WHERE product_id = :product_id ORDER BY created_at DESC");
        $stmt->execute(['product_id' => $productId]);

        $reviewsData = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $reviews = [];

        foreach ($reviewsData as $data) {
            $review = new self();
            $review->id = $data['id'];
            $review->userId = $data['user_id'];
            $review->productId = $data['product_id'];
            $review->rating = $data['rating'];
            $review->comment = $data['comment'];

            $reviews[] = $review;
        }

        return $reviews;
    }

    public static function getAverageRating(int $productId): float
    {
        $stmt = self::getPdo()->prepare("SELECT AVG(rating) as average FROM reviews WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $productId]);
        $data = $stmt->fetch();
        return (float) $data['average'];
    }

    public static function userHasPurchasedProduct(int $userId, int $productId): bool
    {
        $stmt = self::getPdo()->prepare("SELECT COUNT(*) FROM orders o 
                                               JOIN orders_products op ON o.id = op.order_id 
                                               WHERE o.user_id = :user_id AND op.product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        return $stmt->fetchColumn() > 0;
    }

    public function getUserName(): string
    {
        $user = User::getOneById($this->userId);
        return $user ? $user->getName() : "Неизвестный пользователь (userId: {$this->userId})";
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

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getRating(): float
    {
        return $this->rating;
    }



}
