<?php
class Order extends GetConnection
{
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
}
