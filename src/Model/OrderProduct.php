<?php
namespace Model;

class OrderProduct extends Model
{
    private int $id;
    private int $orderId;
    private int $productId;
    private int $amount;
    private int $total;

    public function __construct(int $id, int $orderId, int $productId, int $amount, int $total){
        parent::__construct();

        $this->id = $id;
        $this->orderId = $orderId;
        $this->productId = $productId;
        $this->amount = $amount;
        $this->total = $total;

    }

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

    public function getByOrderId(int $orderId): array|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders_products WHERE order_id = :order_id");
        $stmt->execute(['order_id' => $orderId]);

        $orderProductsData = $stmt->fetchAll();

        if (empty($orderProductsData)) {
            return null;
        }

        $orderProducts = [];
        foreach ($orderProductsData as $data) {
            $orderProducts[] = new OrderProduct(
                $data['id'],
                $data['order_id'],
                $data['product_id'],
                $data['amount'],
                $data['total']
            );
        }

        return $orderProducts;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

}
