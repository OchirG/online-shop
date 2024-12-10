<?php
class OrderProduct extends GetConnection
{
    public function createOrderDetail(int $orderId, int $productId, int $amount, float $total): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO orders_products (order_id, product_id, amount, total) VALUES (:order_id, :product_id, :amount, :total)");
        $params = [
            'order_id' => $orderId,
            'product_id' => $productId,
            'amount' => $amount,
            'total' => $total,
        ];
        return $stmt->execute($params);
    }
}
