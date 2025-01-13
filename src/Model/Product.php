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

    public function __construct(int $id, string $productName, string $description, int $price, string $image)
    {
        parent::__construct();
        $this->id = $id;
        $this->productName = $productName;
        $this->description = $description;
        $this->price = $price;
        $this->image = $image;
    }

    // Метод для получения всех продуктов из базы данных
    public function getAllProducts(): array|null
    {
        $stmt = $this->pdo->query("SELECT * FROM products ORDER BY id");
        $productsData = $stmt->fetchAll();

        if (empty($productsData)) {
            return null;
        }

        $products = [];
        foreach ($productsData as $data) {
            $products[] = new self(
                $data['id'],
                $data['productName'],
                $data['description'],
                $data['price'],
                $data['image']
            );
        }

        return $products;
    }

    // Метод для получения одного продукта по его идентификатору
    public function getOneById(int $productId): self|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $productId]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new self(
                $data['id'],
                $data['productName'],
                $data['description'],
                $data['price'],
                $data['image']
            );
        }
        return null;
    }

    // Метод для получения нескольких продуктов по их идентификаторам
    public function getAllById(array $productIds): array|null
    {
        $placeHolders = implode(',', array_fill(0, count($productIds), '?'));
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id IN ($placeHolders)");
        $stmt->execute($productIds);

        $productsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $products = [];

        if(empty ($productsData)) {
            return null;
        }

        foreach ($productsData as $data) {
            $products[] = new self(
                $data['id'],
                $data['productName'],
                $data['description'],
                $data['price'],
                $data['image']
            );
        }

        return $products;
    }

    public function getProductById($productId): self|null {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :productId");
        $stmt->execute(['productId' => $productId]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new self(
                $data['id'],
                $data['productName'],
                $data['description'],
                $data['price'],
                $data['image']
            );
        }

        return null;
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
}
