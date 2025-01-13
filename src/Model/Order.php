<?php
namespace Model;
class Order extends Model
{
    private int $id;
    private int $userId;
    private string $name;
    private string $email;
    private string $address;
    private int $number;

    public function __construct(int $id, int $userId, string $name, string $email, string $address, int $number){

        parent::__construct();

        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
        $this->email = $email;
        $this->address = $address;
        $this->number = $number;


    }
    public function createOrder(int $userId, string $name, string $email, string $address, string $number): bool
    {

        $stmt = $this->pdo->prepare("
                INSERT INTO orders (user_id, name, email, address, number) 
                VALUES (:user_id, :name, :email, :address, :number)
            ");
        $stmt->execute([
            'user_id' => $userId,
            'name' => $name,
            'email' => $email,
            'address' => $address,
            'number' => $number
        ]);
        return $this->pdo->lastInsertId();
    }

    public function getAllByUserId(int $userId): array|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        $ordersData = $stmt->fetchAll();

        if (empty($ordersData)) {
            return null;
        }

        $orders = [];
        foreach ($ordersData as $orderData) {
            $orders[] = new self(
                $orderData['id'],
                $orderData['user_id'],
                $orderData['name'],
                $orderData['email'],
                $orderData['address'],
                $orderData['number']
            );
        }

        return $orders;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getNumber(): int
    {
        return $this->number;
    }
}


