<?php
namespace Model;
use PDO;

class Product extends Model
{
    private int $id;
    private string $productName;
    private string $description;
    private int $price;
    private string $image;
    private ?int $orderAmount = null;
    private ?int $orderPrice = null;
    private ?int $amount = null;



    // Метод для получения всех продуктов из базы данных
    public static function getAllProducts(): array|null
    {
        $stmt = self::getPdo()->query("SELECT * FROM products ORDER BY id");
        $productsData = $stmt->fetchAll();

        if (empty($productsData)) {
            return null;
        }

        $products = [];
        foreach ($productsData as $data) {

            $product = new self();

            $product->id = $data['id'];
            $product->productName = $data['productname'];
            $product->description = $data['description'];
            $product->price = $data['price'];
            $product->image = $data['image'];

            $products[] = $product;
        }

        return $products;
    }

    // Метод для получения одного продукта по его идентификатору
    public static function getOneById(int $productId): self|null
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $productId]);

        $data = $stmt->fetch();

        if ($data === false) {
            return null;
        }
        $obj = new self;
        $obj->id = $data['id'];
        $obj->productName = $data['productname'];
        $obj->description = $data['description'];
        $obj->price = $data['price'];
        $obj->image = $data['image'];
        return $obj;
    }

    // Метод для получения нескольких продуктов по их идентификаторам
    public static function getAllById(array $productId): array
    {
        if (empty($productId)) {
            return [];
        }

        $placeHolders = implode(',', array_fill(0, count($productId), '?'));
        $stmt = self::getPdo()->prepare("SELECT * FROM products WHERE id IN ($placeHolders)");

        $stmt->execute($productId);
        $productsData = $stmt->fetchAll();

        $products = [];
        foreach ($productsData as $data) {
            $product = new self();
            $product->id = $data['id'];
            $product->productName = $data['productname'];
            $product->description = $data['description'];
            $product->price = $data['price'];
            $product->image = $data['image'];

            $products[] = $product;
        }

        return $products; // Возвращаем массив продуктов
    }

    public static function getProductById($productId): self|null
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM products WHERE id = :productId");
        $stmt->execute(['productId' => $productId]);

        $data = $stmt->fetch();

        if ($data === false) {
            return null;
        }
            $obj = new self;
            $obj->id = $data['id'];
            $obj->productName = $data['productname'];
            $obj->description = $data['description'];
            $obj->price = $data['price'];
            $obj->image = $data['image'];
            return $obj;

    }




    public function getId(): int
    {
        return $this->id;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setOrderAmount(?int $orderAmount): void
    {
        $this->orderAmount = $orderAmount;
    }

    public function setOrderPrice(?int $orderPrice): void
    {
        $this->orderPrice = $orderPrice;
    }

    public function setAmount(?int $amount): void
    {
        $this->amount = $amount;
    }

    public function getOrderAmount(): ?int
    {
        return $this->orderAmount;
    }

    public function getOrderPrice(): ?int
    {
        return $this->orderPrice;
    }


    public function getAmount(): ?int
    {
        return $this->amount;
    }



}
