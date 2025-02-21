<?php

namespace Service;

use DataTransferObject\CreateOrderDTO;
use Exception;
use Model\Model;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;

class OrderService {
    private Order $order;
    private UserProduct $userProduct;
    private OrderProduct $orderProduct;
    private Product $product;



    public function __construct() {
        $this->order = new Order();
        $this->userProduct = new UserProduct();
        $this->orderProduct = new OrderProduct();
        $this->product = new Product();
    }

    public function create(CreateOrderDTO $orderDTO, int $userId): bool
    {

        $pdo = Model::getPdo();

        $pdo->beginTransaction();

        try {
            $userProducts = $this->userProduct->getAllByUserId($userId);

            $orderId = $this->order->createOrder(
                $userId,
                $orderDTO->getName(),
                $orderDTO->getEmail(),
                $orderDTO->getAddress(),
                $orderDTO->getNumber()
            );
            foreach ($userProducts as $userProduct) {
                $productId = $userProduct->getProductId();
                $amount = $userProduct->getAmount();

                $product = $this->product->getProductById($productId);

                if ($product === null) {
                    continue;
                }
                $total = $product->getPrice() * $amount;

                $this->orderProduct->createOrderDetail($orderId, $productId, $amount, $total);

                $this->userProduct->removeProductFromCart($userId, $productId);

            }

        } catch (Exception $e) {
            $pdo->rollBack();
            error_log("Ошибка: " . $e->getMessage());
            return false;
        }

        $pdo->commit();
        return true;
    }
}

